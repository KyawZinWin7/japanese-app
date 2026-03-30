<?php

namespace Database\Seeders;

use App\Models\ExampleWord;
use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class N2SomatomeChapter5Seeder extends Seeder
{
    public function run(): void
    {
        $level = JlptLevel::query()->where('slug', 'n2')->firstOrFail();
        $source = Source::query()
            ->where('jlpt_level_id', $level->id)
            ->where('name', 'Somatome')
            ->orderBy('id')
            ->firstOrFail();

        $chapter = '5';
        $kanjiItems = $this->pendingKanjiItems();

        if ($kanjiItems === []) {
            return;
        }

        $kanjiSortOrder = (int) Kanji::query()
            ->where('jlpt_level_id', $level->id)
            ->where('source_id', $source->id)
            ->where('chapter', $chapter)
            ->max('sort_order');

        $exampleWordSortOrder = (int) ExampleWord::query()
            ->where('jlpt_level_id', $level->id)
            ->where('source_id', $source->id)
            ->where('chapter', $chapter)
            ->max('sort_order');

        foreach ($kanjiItems as $kanjiData) {
            $kanjiSlug = 'n2-somatome-ch5-kanji-'.Str::slug(($kanjiData['meaning'] ?? '').'-'.($kanjiData['onyomi'] ?? $kanjiData['character']), '-');
            $kanji = Kanji::query()->where('slug', $kanjiSlug)->first();

            if (! $kanji) {
                $kanjiSortOrder++;
            }

            Kanji::updateOrCreate(
                ['slug' => $kanjiSlug],
                [
                    'jlpt_level_id' => $level->id,
                    'source_id' => $source->id,
                    'chapter' => $chapter,
                    'character' => $kanjiData['character'],
                    'onyomi' => $kanjiData['onyomi'],
                    'kunyomi' => $kanjiData['kunyomi'],
                    'meaning' => $kanjiData['meaning'],
                    'meaning_mm' => $kanjiData['meaning_mm'],
                    'example_sentence' => $kanjiData['example_sentence'],
                    'example_translation' => $kanjiData['example_translation'],
                    'example_translation_mm' => $kanjiData['example_translation_mm'] ?? null,
                    'sort_order' => $kanji?->sort_order ?? $kanjiSortOrder,
                    'is_published' => true,
                ],
            );

            $savedKanji = Kanji::query()->where('slug', $kanjiSlug)->firstOrFail();

            foreach ($kanjiData['words'] as $wordData) {
                $exampleWord = ExampleWord::query()
                    ->where('jlpt_level_id', $level->id)
                    ->where('source_id', $source->id)
                    ->where('chapter', $chapter)
                    ->where('word', $wordData['word'])
                    ->where('reading', $wordData['reading'])
                    ->first();

                if (! $exampleWord) {
                    $exampleWordSortOrder++;
                }

                $exampleWord = ExampleWord::updateOrCreate(
                    [
                        'jlpt_level_id' => $level->id,
                        'source_id' => $source->id,
                        'chapter' => $chapter,
                        'word' => $wordData['word'],
                        'reading' => $wordData['reading'],
                    ],
                    [
                        'meaning' => $wordData['meaning'],
                        'meaning_mm' => $wordData['meaning_mm'],
                        'sort_order' => $exampleWord?->sort_order ?? $exampleWordSortOrder,
                        'is_published' => true,
                    ],
                );

                $exampleWord->kanji()->syncWithoutDetaching([$savedKanji->id]);
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function pendingKanjiItems(): array
    {
        $path = database_path('seeders/data/n2_somatome_ch5_pending.php');

        if (! file_exists($path)) {
            return [];
        }

        $batches = require $path;
        $items = [];

        foreach ($batches as $batch) {
            foreach ($batch['items'] as $item) {
                $items[] = $item;
            }
        }

        return $items;
    }
}
