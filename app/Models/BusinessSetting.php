<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'location',
        'phone',
        'opening_hours',
        'currency',
        'language',
        'ai_enabled',
        'capabilities',
        'rules',
    ];

    protected $casts = [
        'ai_enabled' => 'boolean',
        'capabilities' => 'array',
        'rules' => 'array',
    ];
}
