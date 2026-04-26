<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kanji_quiz_questions', function (Blueprint $table) {
            $table->string('quiz_type', 50)->default('kanji')->after('kanji_id');
            $table->string('question')->nullable()->after('quiz_type');
            $table->text('explanation')->nullable()->after('correct_answer');
        });

        DB::table('kanji_quiz_questions')->update([
            'quiz_type' => DB::raw("CASE WHEN question_type IS NULL OR question_type = '' OR question_type = 'meaning' THEN 'kanji' ELSE question_type END"),
            'question' => DB::raw('prompt'),
        ]);
    }

    public function down(): void
    {
        Schema::table('kanji_quiz_questions', function (Blueprint $table) {
            $table->dropColumn(['quiz_type', 'question', 'explanation']);
        });
    }
};
