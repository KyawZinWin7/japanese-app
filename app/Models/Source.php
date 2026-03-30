<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    public const CONTENT_TYPE_BOTH = 'both';
    public const CONTENT_TYPE_VOCABULARY = 'vocabulary';
    public const CONTENT_TYPE_KANJI = 'kanji';

    protected $fillable = [
        'jlpt_level_id',
        'name',
        'slug',
        'content_type',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function contentTypeOptions(): array
    {
        return [
            self::CONTENT_TYPE_BOTH,
            self::CONTENT_TYPE_VOCABULARY,
            self::CONTENT_TYPE_KANJI,
        ];
    }

    public function jlptLevel(): BelongsTo
    {
        return $this->belongsTo(JlptLevel::class);
    }

    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function kanji(): HasMany
    {
        return $this->hasMany(Kanji::class);
    }
}
