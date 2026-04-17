<?php

namespace Database\Seeders;

use App\Models\ExampleWord;
use App\Models\JlptLevel;
use App\Models\Kanji;
use Illuminate\Database\Seeder;

class N5Chapter1Seeder extends Seeder
{
    public function run(): void
    {
        $level = JlptLevel::query()->where('slug', 'n5')->firstOrFail();
        $chapter = '1';
        $items = $this->items();

        $this->deleteLegacyExampleWords($level->id, $chapter);

        $kanjiSortOrder = (int) Kanji::query()
            ->where('jlpt_level_id', $level->id)
            ->whereNull('source_id')
            ->where('chapter', $chapter)
            ->max('sort_order');

        $exampleWordSortOrder = (int) ExampleWord::query()
            ->where('jlpt_level_id', $level->id)
            ->whereNull('source_id')
            ->where('chapter', $chapter)
            ->max('sort_order');

        foreach ($items as $item) {
            $kanji = Kanji::query()->where('slug', $item['slug'])->first();

            if (! $kanji) {
                $kanjiSortOrder++;
            }

            $savedKanji = Kanji::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'jlpt_level_id' => $level->id,
                    'source_id' => null,
                    'chapter' => $chapter,
                    'character' => $item['character'],
                    'onyomi' => $item['onyomi'],
                    'kunyomi' => $item['kunyomi'],
                    'meaning' => $item['meaning'],
                    'meaning_mm' => $item['meaning_mm'],
                    'example_sentence' => $item['example_sentence'],
                    'example_translation' => $item['example_translation'],
                    'example_translation_mm' => $item['example_translation_mm'],
                    'sort_order' => $kanji?->sort_order ?? $kanjiSortOrder,
                    'is_published' => true,
                ],
            );

            foreach ($item['words'] as $wordData) {
                $exampleWord = ExampleWord::query()
                    ->where('jlpt_level_id', $level->id)
                    ->whereNull('source_id')
                    ->where('chapter', $chapter)
                    ->where('word', $wordData['word'])
                    ->where('reading', $wordData['reading'])
                    ->first();

                if (! $exampleWord) {
                    $exampleWordSortOrder++;
                }

                $savedWord = ExampleWord::updateOrCreate(
                    [
                        'jlpt_level_id' => $level->id,
                        'source_id' => null,
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

                if (! $savedWord->kanji()->whereKey($savedKanji->id)->exists()) {
                    $savedWord->kanji()->attach($savedKanji->id);
                }
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function items(): array
    {
        return [
            [
                'character' => '一',
                'slug' => 'n5-ch1-ichi',
                'onyomi' => "イチ\n(イッ-)",
                'kunyomi' => 'ひと-つ',
                'meaning' => 'one',
                'meaning_mm' => 'တစ်',
                'example_sentence' => '一つずつ読みましょう。',
                'example_translation' => 'Let us read them one by one.',
                'example_translation_mm' => 'တစ်ခုချင်းစီ ဖတ်ကြရအောင်။',
                'words' => [
                    ['word' => '一', 'reading' => 'いち', 'meaning' => 'one', 'meaning_mm' => 'တစ်'],
                    ['word' => '一つ', 'reading' => 'ひとつ', 'meaning' => 'one thing', 'meaning_mm' => 'တစ်ခု'],
                    ['word' => '一人', 'reading' => 'ひとり', 'meaning' => 'one person', 'meaning_mm' => 'တစ်ယောက်'],
                    ['word' => '一枚', 'reading' => 'いちまい', 'meaning' => 'one flat object', 'meaning_mm' => 'တစ်ရွက်'],
                    ['word' => '一がつ', 'reading' => 'いちがつ', 'meaning' => 'January', 'meaning_mm' => 'ဇန်နဝါရီလ'],
                    ['word' => '一にち', 'reading' => 'いちにち', 'meaning' => 'one day', 'meaning_mm' => 'တစ်ရက်'],
                    ['word' => '一番', 'reading' => 'いちばん', 'meaning' => 'first, best', 'meaning_mm' => 'ပထမ / အကောင်းဆုံး'],
                    ['word' => '一個', 'reading' => 'いっこ', 'meaning' => 'one small item', 'meaning_mm' => 'တစ်ခု'],
                ],
            ],
            [
                'character' => '二',
                'slug' => 'n5-ch1-ni',
                'onyomi' => 'ニ',
                'kunyomi' => 'ふた-つ',
                'meaning' => 'two',
                'meaning_mm' => 'နှစ်',
                'example_sentence' => 'りんごを二つ買いました。',
                'example_translation' => 'I bought two apples.',
                'example_translation_mm' => 'ပန်းသီး နှစ်လုံး ဝယ်ခဲ့တယ်။',
                'words' => [
                    ['word' => '二', 'reading' => 'に', 'meaning' => 'two', 'meaning_mm' => 'နှစ်'],
                    ['word' => '二つ', 'reading' => 'ふたつ', 'meaning' => 'two things', 'meaning_mm' => 'နှစ်ခု'],
                    ['word' => '二人', 'reading' => 'ふたり', 'meaning' => 'two people', 'meaning_mm' => 'နှစ်ယောက်'],
                    ['word' => '二だい', 'reading' => 'にだい', 'meaning' => 'two machines or vehicles', 'meaning_mm' => 'နှစ်စီး'],
                    ['word' => '二かい', 'reading' => 'にかい', 'meaning' => 'two times', 'meaning_mm' => 'နှစ်ခါ'],
                    ['word' => '二がつ', 'reading' => 'にがつ', 'meaning' => 'February', 'meaning_mm' => 'ဖေဖော်ဝါရီလ'],
                ],
            ],
            [
                'character' => '三',
                'slug' => 'n5-ch1-san',
                'onyomi' => 'サン',
                'kunyomi' => 'みっ-つ',
                'meaning' => 'three',
                'meaning_mm' => 'သုံး',
                'example_sentence' => '三人で勉強しています。',
                'example_translation' => 'The three of us are studying.',
                'example_translation_mm' => 'ကျွန်တော်တို့ သုံးယောက် စာလေ့လာနေပါတယ်။',
                'words' => [
                    ['word' => '三', 'reading' => 'さん', 'meaning' => 'three', 'meaning_mm' => 'သုံး'],
                    ['word' => '三つ', 'reading' => 'みっつ', 'meaning' => 'three things', 'meaning_mm' => 'သုံးခု'],
                    ['word' => '三人', 'reading' => 'さんにん', 'meaning' => 'three people', 'meaning_mm' => 'သုံးယောက်'],
                    ['word' => '三まい', 'reading' => 'さんまい', 'meaning' => 'three flat objects', 'meaning_mm' => 'သုံးရွက်'],
                    ['word' => '三ぼん', 'reading' => 'さんぼん', 'meaning' => 'three long objects', 'meaning_mm' => 'သုံးချောင်း'],
                    ['word' => '三さい', 'reading' => 'さんさい', 'meaning' => 'three years old', 'meaning_mm' => 'သုံးနှစ် (အသက်)'],
                ],
            ],
            [
                'character' => '四',
                'slug' => 'n5-ch1-yon',
                'onyomi' => "シ\nよ\nよん",
                'kunyomi' => 'よっ-つ',
                'meaning' => 'four',
                'meaning_mm' => 'လေး',
                'example_sentence' => '四つの箱があります。',
                'example_translation' => 'There are four boxes.',
                'example_translation_mm' => 'သေတ္တာ လေးလုံး ရှိပါတယ်။',
                'words' => [
                    ['word' => '四', 'reading' => 'よん/し', 'meaning' => 'four', 'meaning_mm' => 'လေး'],
                    ['word' => '四つ', 'reading' => 'よっつ', 'meaning' => 'four things', 'meaning_mm' => 'လေးခု'],
                    ['word' => '四人', 'reading' => 'よにん', 'meaning' => 'four people', 'meaning_mm' => 'လေးယောက်'],
                    ['word' => '四じかん', 'reading' => 'よじかん', 'meaning' => 'four hours', 'meaning_mm' => '၄ နာရီကြာ'],
                    ['word' => '四ほん', 'reading' => 'よんほん', 'meaning' => 'four long objects', 'meaning_mm' => 'လေးချောင်း'],
                    ['word' => '四がつ', 'reading' => 'しがつ', 'meaning' => 'April', 'meaning_mm' => 'ဧပြီလ'],
                ],
            ],
        ];
    }

    protected function deleteLegacyExampleWords(int $levelId, string $chapter): void
    {
        ExampleWord::query()
            ->where('jlpt_level_id', $levelId)
            ->whereNull('source_id')
            ->where('chapter', $chapter)
            ->whereIn('word', [
                '一月',
                '一日',
                '二台',
                '二回',
                '二月',
                '三枚',
                '三本',
                '三歳',
                '四時間',
                '四本',
                '四月',
            ])
            ->delete();
    }
}
