<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'avatar_url',
        'status',
        'notes',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
