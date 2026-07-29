<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamPracticeQuestion extends Model
{
    protected $fillable = [
        'exam_practice_set_id',
        'question',
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

    public function set(): BelongsTo
    {
        return $this->belongsTo(ExamPracticeSet::class, 'exam_practice_set_id');
    }

    public function correctAnswers(): array
    {
        $stored = $this->getAttributeFromArray('correct_answer');

        if (is_string($stored)) {
            $decoded = json_decode($stored, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values($decoded);
            }

            return $stored === '' ? [] : [$stored];
        }

        if (is_array($stored)) {
            return array_values($stored);
        }

        return [];
    }

    public function correctOptionValues(): array
    {
        $options = $this->options ?? [];

        return collect($this->correctAnswers())
            ->map(function ($answer) use ($options) {
                if (is_int($answer) || (is_string($answer) && ctype_digit($answer))) {
                    return $options[(int) $answer] ?? null;
                }

                return is_string($answer) ? trim($answer) : null;
            })
            ->filter(fn ($answer) => is_string($answer) && $answer !== '')
            ->values()
            ->all();
    }

    public function requiredAnswerCount(): int
    {
        return max(1, count($this->correctOptionValues()));
    }

    public function allowsMultipleAnswers(): bool
    {
        return $this->requiredAnswerCount() > 1;
    }
}
