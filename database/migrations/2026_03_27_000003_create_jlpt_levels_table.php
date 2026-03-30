<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jlpt_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->string('slug', 20)->unique();
            $table->unsignedTinyInteger('sort_order')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jlpt_levels');
    }
};
