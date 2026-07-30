<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Conversation extends Model
{
    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    // conversation belongs to sender and receiver
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function unreadMessagesCount()
    {
        return Message::where('conversation_id', '=', $this->id)
            ->where('receiver_id', auth()->user()->id)
            ->whereNull('read_at')
            ->count();
    }
    public function isLastMessageRead(): bool
    {
        $user = auth()->user();
        $lastMessage = $this->messages()->latest()->first();
        if ($lastMessage) {
            return $lastMessage->read_at !== null && $lastMessage->sender_id == $user->id;
        }
    }
}
