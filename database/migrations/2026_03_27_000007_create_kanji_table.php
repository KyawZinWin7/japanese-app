<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kanji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jlpt_level_id')->constrained()->cascadeOnDelete();
            $table->string('character', 10);
            $table->string('slug')->unique();
            $table->string('onyomi')->nullable();
            $table->string('kunyomi')->nullable();
            $table->string('meaning');
            $table->string('example_sentence', 1000)->nullable();
            $table->string('example_translation', 1000)->nullable();
            $table->unsignedInteger('sort_order')->default(1);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['jlpt_level_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanji');
    }
};
