<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'is_admin',
        'is_approved',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
            'is_approved' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function bookmarkedVocabulary(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class, 'vocabulary_bookmarks')->withTimestamps();
    }

    public function bookmarkedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_bookmarks')->withTimestamps();
    }

    public function bookmarkedKanji(): BelongsToMany
    {
        return $this->belongsToMany(Kanji::class, 'kanji_bookmarks')->withTimestamps();
    }

    public function accessibleJlptLevels(): BelongsToMany
    {
        return $this->belongsToMany(JlptLevel::class)->withTimestamps();
    }

    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_completions')->withTimestamps();
    }

    public function kanjiQuizAttempts(): HasMany
    {
        return $this->hasMany(KanjiQuizAttempt::class);
    }

    public function studyHistoryEntries(): HasMany
    {
        return $this->hasMany(StudyHistory::class);
    }
}
