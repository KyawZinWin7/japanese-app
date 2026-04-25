<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('entry_key');
            $table->text('href');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('progress_label')->nullable();
            $table->json('state')->nullable();
            $table->boolean('is_resume')->default(false);
            $table->timestamp('last_accessed_at');
            $table->timestamps();

            $table->unique(['user_id', 'entry_key']);
            $table->index(['user_id', 'last_accessed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_histories');
    }
};
