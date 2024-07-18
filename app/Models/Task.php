<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'name',
        'estimated_duration',
        'difficulty_level',
        'sprint_id',
        'assigned_developer_id',
    ];

    protected $casts = [
        'estimated_duration' => 'integer',
        'difficulty_level' => 'integer',
        'sprint_id' => 'integer',
        'assigned_developer_id' => 'integer',
    ];

    public function assignedDeveloper(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function scopeUnassigned(Builder $query): Builder
    {
        return $query->whereNull('sprint_id')
            ->whereNull('assigned_developer_id');
    }
}
