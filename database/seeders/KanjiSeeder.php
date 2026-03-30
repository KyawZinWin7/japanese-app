<?php

namespace Database\Seeders;

use App\Models\JlptLevel;
use App\Models\Kanji;
use Illuminate\Database\Seeder;

class KanjiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'N5' => [
                ['character' => '日', 'slug' => 'n5-hi', 'onyomi' => 'ニチ, ジツ', 'kunyomi' => 'ひ, び, か', 'meaning' => 'day, sun', 'example_sentence' => '毎日日記を書きます。', 'example_translation' => 'I write in my diary every day.', 'sort_order' => 1],
                ['character' => '月', 'slug' => 'n5-tsuki', 'onyomi' => 'ゲツ, ガツ', 'kunyomi' => 'つき', 'meaning' => 'month, moon', 'example_sentence' => '来月日本へ行きます。', 'example_translation' => 'I will go to Japan next month.', 'sort_order' => 2],
                ['character' => '人', 'slug' => 'n5-hito', 'onyomi' => 'ジン, ニン', 'kunyomi' => 'ひと', 'meaning' => 'person', 'example_sentence' => 'あの人は親切です。', 'example_translation' => 'That person is kind.', 'sort_order' => 3],
                ['character' => '山', 'slug' => 'n5-yama', 'onyomi' => 'サン', 'kunyomi' => 'やま', 'meaning' => 'mountain', 'example_sentence' => '山の空気はきれいです。', 'example_translation' => 'The air in the mountains is clean.', 'sort_order' => 4],
                ['character' => '川', 'slug' => 'n5-kawa', 'onyomi' => 'セン', 'kunyomi' => 'かわ', 'meaning' => 'river', 'example_sentence' => '川の水が冷たいです。', 'example_translation' => 'The river water is cold.', 'sort_order' => 5],
            ],
            'N4' => [
                ['character' => '朝', 'slug' => 'n4-asa', 'onyomi' => 'チョウ', 'kunyomi' => 'あさ', 'meaning' => 'morning', 'example_sentence' => '朝早く起きました。', 'example_translation' => 'I woke up early in the morning.', 'sort_order' => 1],
                ['character' => '夜', 'slug' => 'n4-yoru', 'onyomi' => 'ヤ', 'kunyomi' => 'よる, よ', 'meaning' => 'night', 'example_sentence' => '夜は星が見えます。', 'example_translation' => 'You can see the stars at night.', 'sort_order' => 2],
                ['character' => '思', 'slug' => 'n4-omou', 'onyomi' => 'シ', 'kunyomi' => 'おもう', 'meaning' => 'think', 'example_sentence' => 'それは面白いと思います。', 'example_translation' => 'I think that is interesting.', 'sort_order' => 3],
                ['character' => '場', 'slug' => 'n4-ba', 'onyomi' => 'ジョウ', 'kunyomi' => 'ば', 'meaning' => 'place', 'example_sentence' => 'ここは静かな場所です。', 'example_translation' => 'This is a quiet place.', 'sort_order' => 4],
                ['character' => '問', 'slug' => 'n4-ton', 'onyomi' => 'モン', 'kunyomi' => 'と(う)', 'meaning' => 'question, ask', 'example_sentence' => '分からないことを先生に問いました。', 'example_translation' => 'I asked the teacher about what I did not understand.', 'sort_order' => 5],
            ],
            'N3' => [
                ['character' => '決', 'slug' => 'n3-ketsu', 'onyomi' => 'ケツ', 'kunyomi' => 'き(める), き(まる)', 'meaning' => 'decide', 'example_sentence' => '来年の目標を決めました。', 'example_translation' => 'I decided next year’s goal.', 'sort_order' => 1],
                ['character' => '続', 'slug' => 'n3-tsuzuku', 'onyomi' => 'ゾク', 'kunyomi' => 'つづ(く), つづ(ける)', 'meaning' => 'continue', 'example_sentence' => '毎日続けることが大切です。', 'example_translation' => 'It is important to continue every day.', 'sort_order' => 2],
                ['character' => '発', 'slug' => 'n3-hatsu', 'onyomi' => 'ハツ, ホツ', 'kunyomi' => '', 'meaning' => 'departure, emit', 'example_sentence' => '電車は九時に出発します。', 'example_translation' => 'The train departs at nine.', 'sort_order' => 3],
                ['character' => '相', 'slug' => 'n3-ai', 'onyomi' => 'ソウ, ショウ', 'kunyomi' => 'あい', 'meaning' => 'mutual, together', 'example_sentence' => '相手の意見も聞いてください。', 'example_translation' => 'Please listen to the other person’s opinion too.', 'sort_order' => 4],
                ['character' => '談', 'slug' => 'n3-dan', 'onyomi' => 'ダン', 'kunyomi' => '', 'meaning' => 'discuss, talk', 'example_sentence' => '将来について友達と相談しました。', 'example_translation' => 'I discussed the future with my friend.', 'sort_order' => 5],
            ],
            'N2' => [
                ['character' => '援', 'slug' => 'n2-en', 'onyomi' => 'エン', 'kunyomi' => '', 'meaning' => 'aid, support', 'example_sentence' => '家族がいつも私を支援してくれます。', 'example_translation' => 'My family always supports me.', 'sort_order' => 1],
                ['character' => '測', 'slug' => 'n2-hakaru', 'onyomi' => 'ソク', 'kunyomi' => 'はか(る)', 'meaning' => 'measure, estimate', 'example_sentence' => '距離を正確に測りました。', 'example_translation' => 'I measured the distance accurately.', 'sort_order' => 2],
                ['character' => '資', 'slug' => 'n2-shi', 'onyomi' => 'シ', 'kunyomi' => '', 'meaning' => 'resources, capital', 'example_sentence' => '会社は新しい設備に投資しました。', 'example_translation' => 'The company invested in new equipment.', 'sort_order' => 3],
                ['character' => '導', 'slug' => 'n2-michibiku', 'onyomi' => 'ドウ', 'kunyomi' => 'みちび(く)', 'meaning' => 'guide, lead', 'example_sentence' => '先生が私たちを正しく導きます。', 'example_translation' => 'The teacher guides us correctly.', 'sort_order' => 4],
                ['character' => '検', 'slug' => 'n2-ken', 'onyomi' => 'ケン', 'kunyomi' => '', 'meaning' => 'examine, inspect', 'example_sentence' => '出発前に荷物を点検してください。', 'example_translation' => 'Please inspect your luggage before departure.', 'sort_order' => 5],
            ],
            'N1' => [
                ['character' => '顕', 'slug' => 'n1-ken', 'onyomi' => 'ケン', 'kunyomi' => 'あらわ(れる)', 'meaning' => 'appear clearly, manifest', 'example_sentence' => '努力の成果が顕れました。', 'example_translation' => 'The results of the effort became apparent.', 'sort_order' => 1],
                ['character' => '緻', 'slug' => 'n1-chi', 'onyomi' => 'チ', 'kunyomi' => '', 'meaning' => 'fine, detailed', 'example_sentence' => '彼は緻密な計画を立てました。', 'example_translation' => 'He made a detailed plan.', 'sort_order' => 2],
                ['character' => '概', 'slug' => 'n1-gai', 'onyomi' => 'ガイ', 'kunyomi' => '', 'meaning' => 'outline, general', 'example_sentence' => '会議の概要を説明します。', 'example_translation' => 'I will explain the outline of the meeting.', 'sort_order' => 3],
                ['character' => '是', 'slug' => 'n1-ze', 'onyomi' => 'ゼ', 'kunyomi' => 'これ', 'meaning' => 'right, correct', 'example_sentence' => 'その判断が是か非か議論しました。', 'example_translation' => 'We debated whether that judgment was right or wrong.', 'sort_order' => 4],
                ['character' => '遂', 'slug' => 'n1-sui', 'onyomi' => 'スイ', 'kunyomi' => 'と(げる)', 'meaning' => 'accomplish, carry out', 'example_sentence' => '彼は研究を遂げました。', 'example_translation' => 'He accomplished the research.', 'sort_order' => 5],
            ],
        ];

        foreach ($items as $levelName => $kanjiItems) {
            $level = JlptLevel::where('name', $levelName)->first();

            if (! $level) {
                continue;
            }

            foreach ($kanjiItems as $item) {
                Kanji::updateOrCreate(
                    ['slug' => $item['slug']],
                    array_merge($item, [
                        'jlpt_level_id' => $level->id,
                        'is_published' => true,
                    ]),
                );
            }
        }
    }
}
