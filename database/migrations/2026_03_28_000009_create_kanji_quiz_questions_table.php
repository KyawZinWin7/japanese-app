<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kanji_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kanji_quiz_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kanji_id')->nullable()->constrained('kanji')->nullOnDelete();
            $table->string('prompt');
            $table->string('question_type', 50)->default('meaning');
            $table->json('options');
            $table->string('correct_answer');
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanji_quiz_questions');
    }
};
