<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kanji_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kanji_id')->constrained('kanji')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'kanji_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanji_bookmarks');
    }
};
