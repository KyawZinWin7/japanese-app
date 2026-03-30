<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExampleWord extends Model
{
    protected $fillable = [
        'jlpt_level_id',
        'source_id',
        'chapter',
        'word',
        'reading',
        'meaning',
        'meaning_mm',
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

    public function kanji(): BelongsToMany
    {
        return $this->belongsToMany(Kanji::class, 'example_word_kanji')->withTimestamps();
    }
}
