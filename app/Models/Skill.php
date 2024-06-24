<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'name',
        'reference',
        'difficulty',
        'defaults',
        'tech_level',
        'specialization',
    ];

    protected $casts = [
        'defaults' => 'array',   // Cast defaults as an array
    ];
}
