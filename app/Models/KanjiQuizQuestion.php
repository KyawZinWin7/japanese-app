<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanjiQuizQuestion extends Model
{
    protected $fillable = [
        'kanji_quiz_id',
        'kanji_id',
        'prompt',
        'question_type',
        'quiz_type',
        'question',
        'highlight_text',
        'options',
        'correct_answer',
        'explanation',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(KanjiQuiz::class, 'kanji_quiz_id');
    }

    public function kanji(): BelongsTo
    {
        return $this->belongsTo(Kanji::class);
    }
}
