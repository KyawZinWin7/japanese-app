<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kanji extends Model
{
    protected $table = 'kanji';

    protected $fillable = [
        'jlpt_level_id',
        'source_id',
        'chapter',
        'character',
        'slug',
        'onyomi',
        'kunyomi',
        'meaning',
        'meaning_mm',
        'example_sentence',
        'example_translation',
        'example_translation_mm',
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
        return $this->belongsToMany(User::class, 'kanji_bookmarks')->withTimestamps();
    }

    public function exampleWords(): BelongsToMany
    {
        return $this->belongsToMany(ExampleWord::class, 'example_word_kanji')
            ->withTimestamps()
            ->orderBy('example_words.sort_order')
            ->orderBy('example_words.id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
