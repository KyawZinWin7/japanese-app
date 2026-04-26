<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kanji_quiz_questions', function (Blueprint $table) {
            $table->string('highlight_text')->nullable()->after('question');
        });
    }

    public function down(): void
    {
        Schema::table('kanji_quiz_questions', function (Blueprint $table) {
            $table->dropColumn('highlight_text');
        });
    }
};
