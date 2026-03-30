<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vocabulary extends Model
{
    protected $fillable = [
        'jlpt_level_id',
        'source_id',
        'chapter',
        'word',
        'slug',
        'reading',
        'meaning',
        'meaning_mm',
        'example_sentence',
        'example_translation',
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

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vocabulary_bookmarks')->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
