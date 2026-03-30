<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KanjiQuiz extends Model
{
    protected $fillable = [
        'jlpt_level_id',
        'title',
        'slug',
        'description',
        'question_count',
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

    public function questions(): HasMany
    {
        return $this->hasMany(KanjiQuizQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(KanjiQuizAttempt::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
