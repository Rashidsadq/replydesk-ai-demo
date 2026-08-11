<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_type',
        'sender_name',
        'content',
        'content_ar',
        'is_booking_confirmation',
        'booking_details',
    ];

    protected $casts = [
        'is_booking_confirmation' => 'boolean',
        'booking_details' => 'array',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
