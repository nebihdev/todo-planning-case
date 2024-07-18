<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sprint extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
