<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JlptLevel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'description',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function kanji(): HasMany
    {
        return $this->hasMany(Kanji::class);
    }

    public function kanjiQuizzes(): HasMany
    {
        return $this->hasMany(KanjiQuiz::class);
    }

    public function sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }
}
