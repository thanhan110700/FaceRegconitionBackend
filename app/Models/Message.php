<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'from',
        'to',
        'message',
        'read'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}
