<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamPracticeAttempt extends Model
{
    protected $fillable = [
        'exam_practice_set_id',
        'user_id',
        'score',
        'total_questions',
        'answers',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
        ];
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(ExamPracticeSet::class, 'exam_practice_set_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
