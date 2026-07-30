<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;
    public $paginate_var = 10;

    #[On('loadMoreMessages')]
    public function loadMoreMessages(): void
    {
        $this->paginate_var += 10;
        $this->loadMessages();
        $this->dispatch('messages-loaded');
        $this->dispatch('scroll-bottom');
    }
    #[On('messageReceived')]
    public function messageReceived($conversationId, $message)
    {
        if ($conversationId != $this->selectedConversation->id) {
            return;
        }
        $newMessage =  Message::find($message['id']);

        $this->loadedMessages->push($newMessage);

        $this->dispatch('scroll-bottom');
        $this->dispatch('refresh-chat-list');

        $newMessage->read_at = now();
        $newMessage->save();

        $this->notifySenderMessagesRead();
    }

    public function messageRead($conversationId): void
    {
        if ($conversationId != $this->selectedConversation->id) {
            return;
        }

        $this->loadMessages();
        $this->dispatch('refresh-chat-list');
    }

    protected function notifySenderMessagesRead(): void
    {
        $sender = $this->selectedConversation->sender_id == auth()->id()
            ? $this->selectedConversation->receiver
            : $this->selectedConversation->sender;

        $sender->notify(
            new MessageRead($this->selectedConversation->id)
        );
    }

    public function sendMessage()
    {
        $this->validate([
            'body' => 'required|string'
        ]);

        $receiverId = $this->selectedConversation->sender_id == auth()->id()
            ? $this->selectedConversation->receiver_id
            : $this->selectedConversation->sender_id;

        $createdMessage =  Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'content' => $this->body
        ]);
        $this->reset('body');
        $this->dispatch('scroll-bottom');
        $this->loadedMessages->push($createdMessage);
        // $this->loadMessages();

        // Update conversation model to latest conversation
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        // Refresh chat list 
        $this->dispatch('refresh-chat-list');

        // Notify message sent (Broadcast message)
        $receiver = $this->selectedConversation->sender_id == auth()->id()
            ? $this->selectedConversation->receiver
            : $this->selectedConversation->sender;

        $receiver->notify(
            new MessageSent(
                auth()->user(),
                $createdMessage,
                $this->selectedConversation,
                $receiver->id
            )
        );
    }

    public function loadMessages()
    {
        $count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $skip = max(0, $count - $this->paginate_var);
        $this->loadedMessages = Message::with(['sender', 'receiver'])
        ->where('conversation_id', $this->selectedConversation->id)
            ->skip($skip)
            ->take($this->paginate_var)
            ->get();
        return $this->loadedMessages;
    }

    public function mount($selectedConversation)
    {
        $this->selectedConversation = $selectedConversation;
        $this->paginate_var = 10;
        $this->loadMessages();
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}