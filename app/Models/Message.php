<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    protected $dates = ['read_at'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
