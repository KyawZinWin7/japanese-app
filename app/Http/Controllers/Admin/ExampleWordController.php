<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExampleWord;
use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Source;
use App\Services\ContentSourceService;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExampleWordController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $selectedChapter = $request->string('chapter')->toString();
        $search = trim($request->string('search')->toString());

        $query = ExampleWord::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug', 'kanji:id,character')
            ->orderBy('sort_order')
            ->orderBy('word');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel));
        }

        if ($selectedSource !== '') {
            $query->whereHas('source', fn ($builder) => $builder->where('slug', $selectedSource));
        }

        if ($selectedChapter !== '') {
            $query->where('chapter', $selectedChapter);
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

        $paginator = $query->paginate(15)->withQueryString();

        return view('vue-page', [
            'title' => 'Manage Example Words',
            'pageComponent' => 'admin-example-words',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                    'chapter' => $selectedChapter,
                    'search' => $search,
                ],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI),
                'items' => collect($paginator->items())->map(fn (ExampleWord $item) => [
                    'id' => $item->id,
                    'word' => $item->word,
                    'reading' => $item->reading,
                    'meaning' => $item->meaning,
                    'meaning_mm' => $item->meaning_mm,
                    'chapter' => $item->chapter,
                    'sort_order' => $item->sort_order,
                    'is_published' => $item->is_published,
                    'level' => [
                        'name' => $item->jlptLevel?->name,
                        'slug' => $item->jlptLevel?->slug,
                    ],
                    'source' => $item->source ? [
                        'name' => $item->source->name,
                        'slug' => $item->source->slug,
                    ] : null,
                    'kanji' => $item->kanji->map(fn (Kanji $kanji) => [
                        'id' => $kanji->id,
                        'character' => $kanji->character,
                    ])->values()->all(),
                ])->values()->all(),
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
                'routes' => [
                    'index' => route('admin.example-words.index'),
                    'create' => route('admin.example-words.create'),
                    'editBase' => url('/admin/example-words'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Example Words',
                    'Create compound words once and attach them to any kanji you want.',
                    'example-words',
                ),
            ],
        ]);
    }

    public function create(Request $request)
    {
        return $this->formPage(new ExampleWord([
            'jlpt_level_id' => $this->levelIdFromSlug($request->string('level')->toString()),
            'source_id' => $this->sourceIdFromSlug($request->string('source')->toString(), Source::CONTENT_TYPE_KANJI),
            'chapter' => $request->string('chapter')->toString(),
            'is_published' => true,
        ]), 'create', route('admin.example-words.store'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);
        $exampleWord = ExampleWord::create($validated);
        $exampleWord->kanji()->sync($validated['kanji_ids']);

        return redirect()->route('admin.example-words.index')->with('status', 'Example word created successfully.');
    }

    public function edit(ExampleWord $exampleWord)
    {
        $exampleWord->load('kanji:id');

        return $this->formPage($exampleWord, 'edit', route('admin.example-words.update', $exampleWord));
    }

    public function update(Request $request, ExampleWord $exampleWord): RedirectResponse
    {
        $validated = $this->validatePayload($request);
        $exampleWord->update($validated);
        $exampleWord->kanji()->sync($validated['kanji_ids']);

        return redirect()->route('admin.example-words.index')->with('status', 'Example word updated successfully.');
    }

    public function destroy(ExampleWord $exampleWord): RedirectResponse
    {
        $exampleWord->delete();

        return redirect()->route('admin.example-words.index')->with('status', 'Example word deleted successfully.');
    }

    protected function formPage(ExampleWord $exampleWord, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Example Word' : 'Edit Example Word',
            'pageComponent' => 'admin-example-word-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI),
                'kanjiOptions' => Kanji::query()
                    ->with('jlptLevel:id,name,slug', 'source:id,name,slug')
                    ->orderBy('sort_order')
                    ->orderBy('character')
                    ->get()
                    ->map(fn (Kanji $kanji) => [
                        'id' => $kanji->id,
                        'character' => $kanji->character,
                        'meaning' => $kanji->meaning,
                        'jlpt_level_id' => $kanji->jlpt_level_id,
                        'source_id' => $kanji->source_id,
                        'chapter' => $kanji->chapter,
                    ])
                    ->values()
                    ->all(),
                'item' => [
                    'jlpt_level_id' => old('jlpt_level_id', $exampleWord->jlpt_level_id ?? ''),
                    'source_id' => old('source_id', $exampleWord->source_id ?? ''),
                    'chapter' => old('chapter', $exampleWord->chapter ?? ''),
                    'word' => old('word', $exampleWord->word ?? ''),
                    'reading' => old('reading', $exampleWord->reading ?? ''),
                    'meaning' => old('meaning', $exampleWord->meaning ?? ''),
                    'meaning_mm' => old('meaning_mm', $exampleWord->meaning_mm ?? ''),
                    'sort_order' => old('sort_order', $exampleWord->sort_order ?? ''),
                    'is_published' => old('is_published', $exampleWord->is_published ?? true),
                    'kanji_ids' => old('kanji_ids', $exampleWord->relationLoaded('kanji') ? $exampleWord->kanji->pluck('id')->all() : []),
                ],
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.example-words.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Example Word' : 'Edit Example Word',
                    'Create a compound word once, then attach it to one or more kanji.',
                    'example-words',
                ),
            ],
        ]);
    }

    protected function validatePayload(Request $request): array
    {
        $validated = $request->validate([
            'jlpt_level_id' => ['required', 'exists:jlpt_levels,id'],
            'source_id' => [
                Rule::requiredIf(fn () => ContentSourceService::shouldRequireForLevel(
                    $request->integer('jlpt_level_id') ?: null,
                    Source::CONTENT_TYPE_KANJI,
                )),
                'nullable',
                'integer',
                'exists:sources,id',
            ],
            'chapter' => ['nullable', 'string', 'max:100'],
            'word' => ['required', 'string', 'max:255'],
            'reading' => ['required', 'string', 'max:255'],
            'meaning' => ['required', 'string', 'max:255'],
            'meaning_mm' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
            'kanji_ids' => ['required', 'array', 'min:1'],
            'kanji_ids.*' => ['integer', 'exists:kanji,id'],
        ]);

        $validated['source_id'] = $request->filled('source_id') ? (int) $request->input('source_id') : null;
        $validated['kanji_ids'] = collect($request->input('kanji_ids', []))->map(fn ($id) => (int) $id)->values()->all();
        $validated['is_published'] = $request->boolean('is_published');

        return $validated;
    }

    protected function levelIdFromSlug(string $slug): ?int
    {
        if ($slug === '') {
            return null;
        }

        return JlptLevel::query()->where('slug', $slug)->value('id');
    }

    protected function sourceIdFromSlug(string $slug, string $contentType): ?int
    {
        if ($slug === '') {
            return null;
        }

        return ContentSourceService::queryForType($contentType)
            ->where('slug', $slug)
            ->value('id');
    }
}
