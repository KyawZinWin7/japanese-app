<?php

namespace App\Http\Controllers;

use App\Models\JlptLevel;
use App\Models\Source;
use App\Models\Vocabulary;
use App\Services\ContentSourceService;
use App\Support\StudyAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $search = trim($request->string('search')->toString());
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $query = Vocabulary::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug')
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

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('word', 'like', "%{$search}%")
                    ->orWhere('reading', 'like', "%{$search}%")
                    ->orWhere('meaning', 'like', "%{$search}%")
                    ->orWhere('meaning_mm', 'like', "%{$search}%");
            });
        }

        $paginator = $query->paginate(12)->withQueryString();
        $bookmarkIds = $request->user()->bookmarkedVocabulary()->pluck('vocabulary_id')->all();

        return view('vue-page', [
            'title' => 'Vocabulary',
            'pageComponent' => 'vocabulary',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                    'search' => $search,
                ],
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_VOCABULARY, $levelIds),
                'items' => collect($paginator->items())->map(function (Vocabulary $item) use ($bookmarkIds) {
                    return [
                        'id' => $item->id,
                        'word' => $item->word,
                        'slug' => $item->slug,
                        'reading' => $item->reading,
                        'meaning' => $item->meaning,
                        'meaning_mm' => $item->meaning_mm,
                        'sort_order' => $item->sort_order,
                        'level' => [
                            'name' => $item->jlptLevel?->name,
                            'slug' => $item->jlptLevel?->slug,
                        ],
                        'source' => $item->source ? [
                            'name' => $item->source->name,
                            'slug' => $item->source->slug,
                        ] : null,
                        'canBookmark' => true,
                        'showUrl' => route('vocabulary.show', $item->slug),
                        'bookmarkUrl' => route('vocabulary.bookmarks.toggle', $item),
                        'isBookmarked' => in_array($item->id, $bookmarkIds, true),
                    ];
                })->values()->all(),
                'pagination' => [
                    'currentPage' => $paginator->currentPage(),
                    'lastPage' => $paginator->lastPage(),
                    'total' => $paginator->total(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'links' => collect($paginator->linkCollection())->map(fn ($link) => [
                        'url' => $link['url'],
                        'label' => strip_tags($link['label']),
                        'active' => $link['active'],
                    ])->all(),
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'dashboard' => route('study.home'),
                    'index' => route('vocabulary.index'),
                ],
                'csrfToken' => csrf_token(),
                'status' => session('status'),
            ],
        ]);
    }

    public function show(Request $request, Vocabulary $vocabulary)
    {
        abort_unless($vocabulary->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $vocabulary->jlpt_level_id), 403);
        $vocabulary->load('jlptLevel:id,name,slug', 'source:id,name,slug');
        $isBookmarked = $request->user()->bookmarkedVocabulary()->whereKey($vocabulary->id)->exists();

        return view('vue-page', [
            'title' => $vocabulary->word,
            'pageComponent' => 'vocabulary-detail',
            'pageProps' => [
                'item' => [
                    'id' => $vocabulary->id,
                    'word' => $vocabulary->word,
                    'reading' => $vocabulary->reading,
                    'meaning' => $vocabulary->meaning,
                    'meaning_mm' => $vocabulary->meaning_mm,
                    'example_sentence' => $vocabulary->example_sentence,
                    'example_translation' => $vocabulary->example_translation,
                    'level' => [
                        'name' => $vocabulary->jlptLevel?->name,
                        'slug' => $vocabulary->jlptLevel?->slug,
                    ],
                    'source' => $vocabulary->source ? [
                        'name' => $vocabulary->source->name,
                        'slug' => $vocabulary->source->slug,
                    ] : null,
                    'canBookmark' => true,
                    'bookmarkUrl' => route('vocabulary.bookmarks.toggle', $vocabulary),
                    'isBookmarked' => $isBookmarked,
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'index' => route('vocabulary.index'),
                ],
                'csrfToken' => csrf_token(),
                'status' => session('status'),
            ],
        ]);
    }

    public function flashcards(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $query = Vocabulary::query()
            ->with('jlptLevel:id,name,slug')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->orderBy('sort_order')
            ->orderBy('word');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel)->whereIn('id', $levelIds));
        }

        if ($selectedChapter !== '') {
            $query->where('chapter', $selectedChapter);
        }

        $cards = $query->get()->map(function (Vocabulary $item) {
            return [
                'id' => $item->id,
                'word' => $item->word,
                'reading' => $item->reading,
                'meaning' => $item->meaning,
                'meaning_mm' => $item->meaning_mm,
                'chapter' => $item->chapter,
                'level' => [
                    'name' => $item->jlptLevel?->name,
                    'slug' => $item->jlptLevel?->slug,
                ],
                'detailUrl' => route('vocabulary.show', $item),
            ];
        })->values()->all();

        return view('vue-page', [
            'title' => 'Vocabulary Flashcards',
            'pageComponent' => 'vocabulary-flashcards',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                    'chapter' => $selectedChapter,
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'cards' => $cards,
                'routes' => [
                    'dashboard' => route('study.home'),
                    'index' => route('vocabulary-flashcards.index'),
                    'vocabulary' => route('vocabulary.index'),
                ],
            ],
        ]);
    }

    public function toggleBookmark(Request $request, Vocabulary $vocabulary): RedirectResponse
    {
        abort_unless(StudyAccess::canAccessLevel($request->user(), $vocabulary->jlpt_level_id), 403);

        $relation = $request->user()->bookmarkedVocabulary();
        $isBookmarked = $relation->whereKey($vocabulary->id)->exists();

        if ($isBookmarked) {
            $relation->detach($vocabulary->id);
            $message = 'Vocabulary bookmark removed.';
        } else {
            $relation->syncWithoutDetaching([$vocabulary->id]);
            $message = 'Vocabulary bookmarked.';
        }

        return back()->with('status', $message);
    }
}
