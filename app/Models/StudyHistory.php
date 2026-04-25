<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entry_key',
        'href',
        'title',
        'subtitle',
        'progress_label',
        'state',
        'is_resume',
        'last_accessed_at',
    ];

    protected function casts(): array
    {
        return [
            'state' => 'array',
            'is_resume' => 'boolean',
            'last_accessed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
