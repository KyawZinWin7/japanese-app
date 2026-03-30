<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\ExampleWord;
use App\Models\Source;
use App\Services\ContentSourceService;
use App\Models\Vocabulary;
use App\Support\StudyAccess;
use Illuminate\Http\Request;

class FlashcardLauncherController extends Controller
{
    public function __invoke(Request $request)
    {
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $levels = JlptLevel::query()
            ->whereIn('id', $levelIds)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug'])
            ->map(fn (JlptLevel $level) => [
                'id' => $level->id,
                'name' => $level->name,
                'slug' => $level->slug,
            ])
            ->values()
            ->all();

        $kanjiChapters = Kanji::query()
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->whereNotNull('chapter')
            ->where('chapter', '!=', '')
            ->with('jlptLevel:id,slug')
            ->get(['jlpt_level_id', 'chapter'])
            ->groupBy(fn (Kanji $item) => $item->jlptLevel?->slug)
            ->map(fn ($items) => $items->pluck('chapter')->unique()->sort(fn ($left, $right) => $this->compareChapters($left, $right))->values()->all())
            ->all();

        $vocabularyChapters = Vocabulary::query()
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->whereNotNull('chapter')
            ->where('chapter', '!=', '')
            ->with('jlptLevel:id,slug')
            ->get(['jlpt_level_id', 'chapter'])
            ->groupBy(fn (Vocabulary $item) => $item->jlptLevel?->slug)
            ->map(fn ($items) => $items->pluck('chapter')->unique()->sort(fn ($left, $right) => $this->compareChapters($left, $right))->values()->all())
            ->all();

        $exampleWordSources = collect(ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI, $levelIds))
            ->groupBy(fn (array $source) => $source['level']['slug'] ?? null)
            ->map(function ($items) {
                return $items
                    ->map(fn (array $source) => [
                        'id' => $source['id'],
                        'name' => $source['name'],
                        'slug' => $source['slug'],
                    ])
                    ->values()
                    ->all();
            })
            ->all();

        $exampleWordChapters = ExampleWord::query()
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->whereNotNull('chapter')
            ->where('chapter', '!=', '')
            ->with('jlptLevel:id,slug', 'source:id,slug')
            ->get(['jlpt_level_id', 'source_id', 'chapter'])
            ->groupBy(fn (ExampleWord $item) => ($item->jlptLevel?->slug ?? '').'|'.($item->source?->slug ?? ''))
            ->map(fn ($items) => $items->pluck('chapter')->unique()->sort(fn ($left, $right) => $this->compareChapters($left, $right))->values()->all())
            ->all();

        return view('vue-page', [
            'title' => 'Flashcards',
            'pageComponent' => 'flashcards-launcher',
            'pageProps' => [
                'levels' => $levels,
                'chapters' => [
                    'kanji' => $kanjiChapters,
                    'vocabulary' => $vocabularyChapters,
                    'exampleWords' => $exampleWordChapters,
                ],
                'sources' => [
                    'exampleWords' => $exampleWordSources,
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'dashboard' => route('study.home'),
                    'kanji' => route('kanji-flashcards.index'),
                    'vocabulary' => route('vocabulary-flashcards.index'),
                    'exampleWords' => route('example-word-flashcards.index'),
                ],
                'status' => session('status'),
            ],
        ]);
    }

    protected function compareChapters(string $left, string $right): int
    {
        $leftNumber = is_numeric($left) ? (float) $left : null;
        $rightNumber = is_numeric($right) ? (float) $right : null;

        if ($leftNumber !== null && $rightNumber !== null) {
            return $leftNumber <=> $rightNumber;
        }

        return strnatcasecmp($left, $right);
    }
}
