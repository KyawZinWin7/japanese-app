<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kanji', function (Blueprint $table) {
            $table->string('example_translation_mm', 1000)->nullable()->after('example_translation');
        });
    }

    public function down(): void
    {
        Schema::table('kanji', function (Blueprint $table) {
            $table->dropColumn('example_translation_mm');
        });
    }
};
