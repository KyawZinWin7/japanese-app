<?php

namespace Database\Seeders;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\KanjiQuiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class N5KanjiQuizSeeder extends Seeder
{
    protected const TOTAL_QUESTIONS = 50;
    protected const QUESTIONS_PER_QUIZ = 10;

    public function run(): void
    {
        $level = JlptLevel::query()->where('slug', 'n5')->firstOrFail();
        $kanji = Kanji::query()
            ->where('jlpt_level_id', $level->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'character', 'meaning']);

        if ($kanji->count() < 4) {
            $this->command?->warn('N5KanjiQuizSeeder skipped because at least 4 N5 kanji are required.');

            return;
        }

        $slugs = [];

        $quizTotal = (int) ceil(self::TOTAL_QUESTIONS / self::QUESTIONS_PER_QUIZ);

        for ($index = 1; $index <= $quizTotal; $index++) {
            $quizNumber = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
            $slug = "seed-n5-kanji-quiz-{$quizNumber}";
            $slugs[] = $slug;

            $quiz = KanjiQuiz::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'jlpt_level_id' => $level->id,
                    'title' => "N5 Kanji Quiz {$quizNumber}",
                    'description' => "Ten-question meaning practice set {$quizNumber} for N5 kanji.",
                    'question_count' => self::QUESTIONS_PER_QUIZ,
                    'is_published' => true,
                ],
            );

            $quiz->questions()->delete();

            for ($questionIndex = 1; $questionIndex <= self::QUESTIONS_PER_QUIZ; $questionIndex++) {
                $globalSeed = (($index - 1) * self::QUESTIONS_PER_QUIZ) + $questionIndex;
                $targetKanji = $kanji[($globalSeed - 1) % $kanji->count()];
                $options = $this->buildOptions($kanji, $targetKanji->id, $globalSeed);

                $quiz->questions()->create([
                    'kanji_id' => $targetKanji->id,
                    'prompt' => 'What is the meaning of this kanji?',
                    'question_type' => 'kanji',
                    'quiz_type' => 'kanji',
                    'question' => "What is the meaning of {$targetKanji->character}?",
                    'options' => $options,
                    'correct_answer' => $targetKanji->meaning,
                    'sort_order' => $questionIndex,
                ]);
            }
        }

        KanjiQuiz::query()
            ->where('jlpt_level_id', $level->id)
            ->where('slug', 'like', 'seed-n5-kanji-quiz-%')
            ->whereNotIn('slug', $slugs)
            ->delete();
    }

    protected function buildOptions(Collection $kanji, int $correctKanjiId, int $seed): array
    {
        $correct = $kanji->firstWhere('id', $correctKanjiId);
        $distractors = $kanji
            ->where('id', '!=', $correctKanjiId)
            ->values();

        $rotation = ($seed - 1) % max($distractors->count(), 1);
        $rotated = $distractors
            ->slice($rotation)
            ->concat($distractors->slice(0, $rotation))
            ->pluck('meaning')
            ->values();

        $options = collect([$correct->meaning])
            ->concat($rotated)
            ->take(4)
            ->values();

        $answerPosition = ($seed - 1) % $options->count();
        $ordered = $options->values()->all();

        if ($answerPosition !== 0) {
            $correctMeaning = $ordered[0];
            array_splice($ordered, 0, 1);
            array_splice($ordered, $answerPosition, 0, [$correctMeaning]);
        }

        return $ordered;
    }
}
