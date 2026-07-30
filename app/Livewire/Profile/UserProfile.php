<?php

namespace App\Livewire\Profile;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class UserProfile extends Component
{
    public User $user;
    public function mount($user)
    {
        $this->user = $user;
    }
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
        return view('livewire.profile.user-profile');
    }
}
