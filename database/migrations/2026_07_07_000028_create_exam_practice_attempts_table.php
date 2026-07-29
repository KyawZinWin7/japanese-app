<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_practice_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_practice_set_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('score');
            $table->unsignedInteger('total_questions');
            $table->json('answers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_practice_attempts');
    }
};
