<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper',
        'is_full',
    ];

    /**
     * Users that belong to the chat room.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
