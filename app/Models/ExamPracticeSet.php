<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamPracticeSet extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'exam_code',
        'question_count',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamPracticeQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamPracticeAttempt::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
