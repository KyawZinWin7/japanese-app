<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kanji_example_words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_id')->constrained('kanji')->cascadeOnDelete();
            $table->string('word');
            $table->string('reading');
            $table->string('meaning');
            $table->string('meaning_mm')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanji_example_words');
    }
};
