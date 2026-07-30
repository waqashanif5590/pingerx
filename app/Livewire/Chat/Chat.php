<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\MessageRead;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Chat extends Component
{
    public $chat;
    public $selectedConversation;
    public function mount($chat)
    {
        $this->chat = $chat;
        $this->selectedConversation = Conversation::findOrFail($chat);

        $updated = Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($updated > 0) {
            $sender = $this->selectedConversation->sender_id == auth()->id()
                ? $this->selectedConversation->receiver
                : $this->selectedConversation->sender;

            $sender->notify(new MessageRead($this->selectedConversation->id));
        }
    }
    public function render()
    {
        return view('livewire.chat.chat');
    }
}
