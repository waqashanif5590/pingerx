<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Attributes\Layout;

use Livewire\Component;
use App\Models\User;

#[Layout('layouts.app')]
class Users extends Component
{
    public function message(int $userId)
    {
        $authenticatedUserId = auth()->id();

        // Check if conversation exists
        $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $authenticatedUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('receiver_id', $authenticatedUserId)
                ->where('sender_id', $userId);
        })->first();
        if ($existingConversation) {
            return redirect()->route('chat.show', $existingConversation->id);
        }

        // else create new conversation
        $createdConversation = Conversation::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId
        ]);
        return redirect()->route('chat.show', $createdConversation->id);
    }

    public function addFriend(int $userId)
    {
        // Not yet implemented
        $this->dispatch('show-alert', [
            'message' => 'Add Friend feature is currently not implemented',
        ]);
    }
    public function render()
    {
        return view('livewire.users', ['users' => User::where('id', '!=', auth()->id())->get()]);
    }
}
