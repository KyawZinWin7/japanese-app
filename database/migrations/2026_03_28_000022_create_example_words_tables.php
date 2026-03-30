<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('example_words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jlpt_level_id')->constrained('jlpt_levels')->cascadeOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('sources')->nullOnDelete();
            $table->string('chapter', 100)->nullable();
            $table->string('word');
            $table->string('reading');
            $table->string('meaning');
            $table->string('meaning_mm')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('example_word_kanji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('example_word_id')->constrained('example_words')->cascadeOnDelete();
            $table->foreignId('kanji_id')->constrained('kanji')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['example_word_id', 'kanji_id']);
        });

        if (! Schema::hasTable('kanji_example_words')) {
            return;
        }

        $legacyRows = DB::table('kanji_example_words')
            ->join('kanji', 'kanji.id', '=', 'kanji_example_words.kanji_id')
            ->select(
                'kanji_example_words.*',
                'kanji.jlpt_level_id',
                'kanji.source_id',
                'kanji.chapter'
            )
            ->orderBy('kanji_example_words.id')
            ->get();

        foreach ($legacyRows as $row) {
            $exampleWordId = DB::table('example_words')->insertGetId([
                'jlpt_level_id' => $row->jlpt_level_id,
                'source_id' => $row->source_id,
                'chapter' => $row->chapter,
                'word' => $row->word,
                'reading' => $row->reading,
                'meaning' => $row->meaning,
                'meaning_mm' => $row->meaning_mm,
                'sort_order' => $row->sort_order,
                'is_published' => true,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);

            DB::table('example_word_kanji')->insert([
                'example_word_id' => $exampleWordId,
                'kanji_id' => $row->kanji_id,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('example_word_kanji');
        Schema::dropIfExists('example_words');
    }
};
