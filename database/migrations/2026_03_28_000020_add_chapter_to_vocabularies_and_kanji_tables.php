<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->string('chapter', 100)->nullable()->after('source_id');
        });

        Schema::table('kanji', function (Blueprint $table) {
            $table->string('chapter', 100)->nullable()->after('source_id');
        });
    }

    public function down(): void
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->dropColumn('chapter');
        });

        Schema::table('kanji', function (Blueprint $table) {
            $table->dropColumn('chapter');
        });
    }
};
