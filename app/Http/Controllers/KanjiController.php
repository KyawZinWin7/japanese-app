<?php

namespace App\Http\Controllers;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Source;
use App\Services\ContentSourceService;
use App\Support\StudyAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KanjiController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());
        $items = $this->kanjiIndexItems($request->user(), $levelIds);

        return view('vue-page', [
            'title' => 'Kanji',
            'pageComponent' => 'kanji',
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
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI, $levelIds),
                'items' => $items,
                'csrfToken' => csrf_token(),
                'status' => session('status'),
                'routes' => [
                    'dashboard' => route('study.home'),
                    'flashcards' => route('kanji-flashcards.index'),
                    'index' => route('kanji.index'),
                    'launch' => route('kanji.launch'),
                ],
            ],
        ]);
    }

    public function launch(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());
        $items = collect($this->kanjiIndexItems($request->user(), $levelIds));

        $filteredItems = $items
            ->filter(function (array $item) use ($selectedLevel, $selectedSource, $selectedChapter) {
                if ($selectedLevel === '' || ($item['level']['slug'] ?? '') !== $selectedLevel) {
                    return false;
                }

                if ($selectedSource !== '' && ($item['source']['slug'] ?? '') !== $selectedSource) {
                    return false;
                }

                if ($selectedChapter !== '' && ($item['chapter'] ?? '') !== $selectedChapter) {
                    return false;
                }

                return true;
            })
            ->values();

        abort_if($selectedLevel === '' || $filteredItems->isEmpty(), 404);

        return view('vue-page', [
            'title' => 'Kanji Study Page',
            'pageComponent' => 'kanji-launch',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                    'chapter' => $selectedChapter,
                ],
                'items' => $filteredItems->all(),
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI, $levelIds),
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'index' => route('kanji.index', array_filter([
                        'level' => $selectedLevel,
                        'source' => $selectedSource,
                        'chapter' => $selectedChapter,
                    ])),
                    'kanji' => route('kanji.index'),
                ],
            ],
        ]);
    }

    public function show(Request $request, Kanji $kanji)
    {
        abort_unless($kanji->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $kanji->jlpt_level_id), 403);
        $kanji->load('jlptLevel:id,name,slug', 'source:id,name,slug', 'exampleWords:id,word,reading,meaning,meaning_mm,sort_order');
        $isBookmarked = $request->user()->bookmarkedKanji()->whereKey($kanji->id)->exists();
        $sequence = Kanji::query()
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', StudyAccess::allowedLevelIds($request->user()))
            ->where('jlpt_level_id', $kanji->jlpt_level_id)
            ->when($kanji->source_id !== null, fn ($builder) => $builder->where('source_id', $kanji->source_id))
            ->when($kanji->chapter !== null && $kanji->chapter !== '', fn ($builder) => $builder->where('chapter', $kanji->chapter))
            ->orderBy('sort_order')
            ->orderBy('character')
            ->get(['id', 'slug', 'character', 'meaning', 'onyomi', 'kunyomi', 'sort_order']);
        $currentIndex = $sequence->search(fn (Kanji $item) => $item->id === $kanji->id);
        $previousKanji = $currentIndex !== false && $currentIndex > 0 ? $sequence[$currentIndex - 1] : null;
        $nextKanji = $currentIndex !== false && $currentIndex < ($sequence->count() - 1) ? $sequence[$currentIndex + 1] : null;

        return view('vue-page', [
            'title' => $kanji->character,
            'pageComponent' => 'kanji-detail',
            'pageProps' => [
                'item' => [
                    'id' => $kanji->id,
                    'character' => $kanji->character,
                    'onyomi' => $kanji->onyomi,
                    'kunyomi' => $kanji->kunyomi,
                    'meaning' => $kanji->meaning,
                    'meaning_mm' => $kanji->meaning_mm,
                    'example_sentence' => $kanji->example_sentence,
                    'example_translation' => $kanji->example_translation,
                    'example_translation_mm' => $kanji->example_translation_mm,
                    'chapter' => $kanji->chapter,
                    'sort_order' => $kanji->sort_order,
                    'sequence' => [
                        'position' => $currentIndex !== false ? $currentIndex + 1 : null,
                        'total' => $sequence->count(),
                        'items' => $sequence->values()->map(fn (Kanji $item, int $index) => [
                            'id' => $item->id,
                            'number' => $index + 1,
                            'slug' => $item->slug,
                            'character' => $item->character,
                            'meaning' => $item->meaning,
                            'onyomi' => $item->onyomi,
                            'kunyomi' => $item->kunyomi,
                            'sortOrder' => $item->sort_order,
                            'isCurrent' => $item->id === $kanji->id,
                            'url' => route('kanji.show', $item),
                        ])->all(),
                    ],
                    'canBookmark' => true,
                    'bookmarkUrl' => route('kanji.bookmarks.toggle', $kanji),
                    'isBookmarked' => $isBookmarked,
                    'level' => [
                        'name' => $kanji->jlptLevel?->name,
                        'slug' => $kanji->jlptLevel?->slug,
                    ],
                    'source' => $kanji->source ? [
                        'name' => $kanji->source->name,
                        'slug' => $kanji->source->slug,
                    ] : null,
                    'exampleWords' => $kanji->exampleWords->map(fn ($word) => [
                        'id' => $word->id,
                        'word' => $word->word,
                        'reading' => $word->reading,
                        'meaning' => $word->meaning,
                        'meaning_mm' => $word->meaning_mm,
                    ])->values()->all(),
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'csrfToken' => csrf_token(),
                'status' => session('status'),
                'routes' => [
                    'index' => route('kanji.index', array_filter([
                        'level' => $kanji->jlptLevel?->slug,
                        'source' => $kanji->source?->slug,
                        'chapter' => $kanji->chapter,
                    ])),
                    'previous' => $previousKanji ? route('kanji.show', $previousKanji->slug) : null,
                    'next' => $nextKanji ? route('kanji.show', $nextKanji->slug) : null,
                ],
            ],
        ]);
    }

    public function flashcards(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $query = Kanji::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug', 'exampleWords:id,word,reading,meaning,meaning_mm,sort_order')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->orderBy('sort_order')
            ->orderBy('character');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel)->whereIn('id', $levelIds));
        }

        if ($selectedSource !== '') {
            $query->whereHas('source', fn ($builder) => $builder->where('slug', $selectedSource));
        }

        if ($selectedChapter !== '') {
            $query->where('chapter', $selectedChapter);
        }

        $cards = $query->get()->map(function (Kanji $item) {
            return [
                'id' => $item->id,
                'character' => $item->character,
                'onyomi' => $item->onyomi,
                'kunyomi' => $item->kunyomi,
                'meaning' => $item->meaning,
                'meaning_mm' => $item->meaning_mm,
                'chapter' => $item->chapter,
                'example_sentence' => $item->example_sentence,
                'example_translation' => $item->example_translation,
                'example_translation_mm' => $item->example_translation_mm,
                'related_words' => $item->exampleWords->map(fn ($word) => [
                    'id' => $word->id,
                    'word' => $word->word,
                    'reading' => $word->reading,
                    'meaning' => $word->meaning,
                    'meaning_mm' => $word->meaning_mm,
                ])->values()->all(),
                'level' => [
                    'name' => $item->jlptLevel?->name,
                    'slug' => $item->jlptLevel?->slug,
                ],
                'detailUrl' => route('kanji.show', $item),
            ];
        })->values()->all();

        return view('vue-page', [
            'title' => 'Kanji Flashcards',
            'pageComponent' => 'kanji-flashcards',
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
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI, $levelIds),
                'cards' => $cards,
                'routes' => [
                    'dashboard' => route('study.home'),
                    'index' => route('kanji-flashcards.index'),
                    'kanji' => route('kanji.index'),
                ],
            ],
        ]);
    }

    public function toggleBookmark(Request $request, Kanji $kanji): RedirectResponse
    {
        abort_unless(StudyAccess::canAccessLevel($request->user(), $kanji->jlpt_level_id), 403);

        $relation = $request->user()->bookmarkedKanji();
        $isBookmarked = $relation->whereKey($kanji->id)->exists();

        if ($isBookmarked) {
            $relation->detach($kanji->id);
            $message = 'Kanji bookmark removed.';
        } else {
            $relation->syncWithoutDetaching([$kanji->id]);
            $message = 'Kanji bookmarked.';
        }

        return back()->with('status', $message);
    }

    private function kanjiIndexItems($user, array $levelIds): array
    {
        $bookmarkIds = $user->bookmarkedKanji()->pluck('kanji_id')->all();

        return Kanji::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->orderBy('sort_order')
            ->orderBy('character')
            ->get()
            ->map(function (Kanji $item) use ($bookmarkIds) {
                return [
                    'id' => $item->id,
                    'character' => $item->character,
                    'slug' => $item->slug,
                    'onyomi' => $item->onyomi,
                    'kunyomi' => $item->kunyomi,
                    'meaning' => $item->meaning,
                    'meaning_mm' => $item->meaning_mm,
                    'chapter' => $item->chapter,
                    'sort_order' => $item->sort_order,
                    'canBookmark' => true,
                    'bookmarkUrl' => route('kanji.bookmarks.toggle', $item),
                    'isBookmarked' => in_array($item->id, $bookmarkIds, true),
                    'level' => [
                        'name' => $item->jlptLevel?->name,
                        'slug' => $item->jlptLevel?->slug,
                    ],
                    'source' => $item->source ? [
                        'name' => $item->source->name,
                        'slug' => $item->source->slug,
                    ] : null,
                    'showUrl' => route('kanji.show', $item),
                ];
            })
            ->values()
            ->all();
    }
}
