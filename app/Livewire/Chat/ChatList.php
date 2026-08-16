<?php

namespace App\Livewire\Chat;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class ChatList extends Component
{
    #[On('refresh-chat-list')]
    public function refresh() {}

    public $selectedConversation;
    public $search = '';
    public function deleteChat($encryptedId)
    {
        $conversationId = Crypt::decrypt($encryptedId);

        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->firstOrFail();

        DB::transaction(function () use ($conversation) {

            // Delete all messages
            $conversation->messages()->delete();

            // Delete conversation
            $conversation->delete();
        });

        return redirect()->route('chat');
    }
    public function render()
    {
        $user = auth()->user();
        return view('livewire.chat.chat-list', [
            'conversations' => $user->conversations()
                ->with(['sender', 'receiver', 'latestMessage'])
                ->when($this->search, function ($query) {
                    $query->where(function ($query) {
                        $query->whereHas('sender', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        })
                            ->orWhereHas('receiver', function ($query) {
                                $query->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->orderBy('updated_at', 'desc')
                ->get()
        ]);
    }
}
