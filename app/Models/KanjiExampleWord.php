<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanjiExampleWord extends Model
{
    protected $fillable = [
        'kanji_id',
        'word',
        'reading',
        'meaning',
        'meaning_mm',
        'sort_order',
    ];

    public function kanji(): BelongsTo
    {
        return $this->belongsTo(Kanji::class);
    }
}
