<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jlpt_level_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jlpt_level_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'jlpt_level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jlpt_level_user');
    }
};
