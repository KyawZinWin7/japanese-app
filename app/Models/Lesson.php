<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    protected $fillable = [
        'jlpt_level_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function jlptLevel(): BelongsTo
    {
        return $this->belongsTo(JlptLevel::class);
    }

    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_bookmarks')->withTimestamps();
    }

    public function completedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_completions')->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
