<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->foreignId('source_id')->nullable()->after('jlpt_level_id')->constrained()->nullOnDelete();
            $table->index(['jlpt_level_id', 'source_id', 'sort_order'], 'vocabularies_level_source_sort_index');
        });

        Schema::table('kanji', function (Blueprint $table) {
            $table->foreignId('source_id')->nullable()->after('jlpt_level_id')->constrained()->nullOnDelete();
            $table->index(['jlpt_level_id', 'source_id', 'sort_order'], 'kanji_level_source_sort_index');
        });
    }

    public function down(): void
    {
        Schema::table('vocabularies', function (Blueprint $table) {
            $table->dropIndex('vocabularies_level_source_sort_index');
            $table->dropConstrainedForeignId('source_id');
        });

        Schema::table('kanji', function (Blueprint $table) {
            $table->dropIndex('kanji_level_source_sort_index');
            $table->dropConstrainedForeignId('source_id');
        });
    }
};
