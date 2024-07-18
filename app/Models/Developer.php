<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_difficulty_level',
    ];

    protected $casts = [
        'max_difficulty_level' => 'integer',
    ];
}
