<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'body',
        'is_read',
        'read_at',
        'edited_at',
        'deleted_for_everyone',
        'deleted_for_sender',
        'deleted_for_receiver',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'deleted_for_everyone' => 'boolean',
        'deleted_for_sender' => 'boolean',
        'deleted_for_receiver' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
        'edited_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
