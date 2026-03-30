<?php

namespace App\Http\Controllers;

use App\Models\ExampleWord;
use App\Models\JlptLevel;
use App\Models\Source;
use App\Support\StudyAccess;
use Illuminate\Http\Request;

class ExampleWordFlashcardController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $query = ExampleWord::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug', 'kanji:id,character')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->orderBy('sort_order')
            ->orderBy('word');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel)->whereIn('id', $levelIds));
        }

        if ($selectedSource !== '') {
            $query->whereHas('source', fn ($builder) => $builder->where('slug', $selectedSource));
        }

        if ($selectedChapter !== '') {
            $query->where('chapter', $selectedChapter);
        }

        $cards = $query->get()->map(function (ExampleWord $item) {
            return [
                'id' => $item->id,
                'word' => $item->word,
                'reading' => $item->reading,
                'meaning' => $item->meaning,
                'meaning_mm' => $item->meaning_mm,
                'chapter' => $item->chapter,
                'source' => $item->source ? [
                    'name' => $item->source->name,
                    'slug' => $item->source->slug,
                ] : null,
                'level' => [
                    'name' => $item->jlptLevel?->name,
                    'slug' => $item->jlptLevel?->slug,
                ],
                'kanji' => $item->kanji->map(fn ($kanji) => [
                    'id' => $kanji->id,
                    'character' => $kanji->character,
                ])->values()->all(),
            ];
        })->values()->all();

        return view('vue-page', [
            'title' => 'Kanji Word Flashcards',
            'pageComponent' => 'example-word-flashcards',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                    'chapter' => $selectedChapter,
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'sources' => Source::query()
                    ->whereIn('id', ExampleWord::query()
                        ->where('is_published', true)
                        ->whereIn('jlpt_level_id', $levelIds)
                        ->when($selectedLevel !== '', fn ($builder) => $builder->whereHas('jlptLevel', fn ($levelQuery) => $levelQuery->where('slug', $selectedLevel)->whereIn('id', $levelIds)))
                        ->pluck('source_id')
                        ->filter()
                        ->unique()
                        ->values())
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug'])
                    ->toArray(),
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'cards' => $cards,
                'routes' => [
                    'dashboard' => route('study.home'),
                    'index' => route('example-word-flashcards.index'),
                    'flashcards' => route('flashcards.index'),
                ],
            ],
        ]);
    }
}
