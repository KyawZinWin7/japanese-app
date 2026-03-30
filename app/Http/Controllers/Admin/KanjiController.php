<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Source;
use App\Services\ContentSourceService;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KanjiController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();

        $query = Kanji::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug')
            ->orderBy('sort_order')
            ->orderBy('character');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel));
        }

        if ($selectedSource !== '') {
            $query->whereHas('source', fn ($builder) => $builder->where('slug', $selectedSource));
        }

        $paginator = $query->paginate(15)->withQueryString();

        return view('vue-page', [
            'title' => 'Manage Kanji',
            'pageComponent' => 'admin-kanji',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                ],
                'csrfToken' => csrf_token(),
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI),
                'items' => collect($paginator->items())->map(function (Kanji $item) {
                    return [
                        'character' => $item->character,
                        'slug' => $item->slug,
                        'onyomi' => $item->onyomi,
                        'kunyomi' => $item->kunyomi,
                        'meaning' => $item->meaning,
                        'meaning_mm' => $item->meaning_mm,
                        'chapter' => $item->chapter,
                        'is_published' => $item->is_published,
                        'level' => [
                            'name' => $item->jlptLevel?->name,
                            'slug' => $item->jlptLevel?->slug,
                        ],
                        'source' => $item->source ? [
                            'name' => $item->source->name,
                            'slug' => $item->source->slug,
                        ] : null,
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
                'routes' => [
                    'publicIndex' => route('kanji.index'),
                    'index' => route('admin.kanji.index'),
                    'create' => route('admin.kanji.create'),
                    'editBase' => url('/admin/kanji'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Kanji',
                    'Maintain kanji records, readings, and examples.',
                    'kanji',
                ),
            ],
        ]);
    }

    public function create(Request $request)
    {
        return $this->formPage(new Kanji([
            'jlpt_level_id' => $this->levelIdFromSlug($request->string('level')->toString()),
            'source_id' => $this->sourceIdFromSlug($request->string('source')->toString(), Source::CONTENT_TYPE_KANJI),
            'is_published' => true,
        ]), 'create', route('admin.kanji.store'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);
        Kanji::create($validated);

        return redirect()->route('admin.kanji.index')->with('status', 'Kanji created successfully.');
    }

    public function edit(Kanji $kanji)
    {
        return $this->formPage($kanji, 'edit', route('admin.kanji.update', $kanji));
    }

    public function update(Request $request, Kanji $kanji): RedirectResponse
    {
        $validated = $this->validatePayload($request, $kanji);
        $kanji->update($validated);

        return redirect()->route('admin.kanji.index')->with('status', 'Kanji updated successfully.');
    }

    public function destroy(Kanji $kanji): RedirectResponse
    {
        $kanji->delete();

        return redirect()->route('admin.kanji.index')->with('status', 'Kanji deleted successfully.');
    }

    protected function formPage(Kanji $kanji, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Kanji' : 'Edit Kanji',
            'pageComponent' => 'admin-kanji-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'item' => [
                    'jlpt_level_id' => old('jlpt_level_id', $kanji->jlpt_level_id ?? ''),
                    'source_id' => old('source_id', $kanji->source_id ?? ''),
                    'chapter' => old('chapter', $kanji->chapter ?? ''),
                    'character' => old('character', $kanji->character ?? ''),
                    'slug' => old('slug', $kanji->slug ?? ''),
                    'onyomi' => old('onyomi', $kanji->onyomi ?? ''),
                    'kunyomi' => old('kunyomi', $kanji->kunyomi ?? ''),
                    'meaning' => old('meaning', $kanji->meaning ?? ''),
                    'meaning_mm' => old('meaning_mm', $kanji->meaning_mm ?? ''),
                    'example_sentence' => old('example_sentence', $kanji->example_sentence ?? ''),
                    'example_translation' => old('example_translation', $kanji->example_translation ?? ''),
                    'example_translation_mm' => old('example_translation_mm', $kanji->example_translation_mm ?? ''),
                    'sort_order' => old('sort_order', $kanji->sort_order ?? ''),
                    'is_published' => old('is_published', $kanji->is_published ?? true),
                ],
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_KANJI),
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.kanji.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Kanji' : 'Edit Kanji',
                    'Manage the character, readings, meaning, and example usage.',
                    'kanji',
                ),
            ],
        ]);
    }

    protected function validatePayload(Request $request, ?Kanji $kanji = null): array
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
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    if ($value === null || $value === '') {
                        return;
                    }

                    if (! ContentSourceService::sourceMatchesLevelAndType(
                        (int) $value,
                        $request->integer('jlpt_level_id') ?: null,
                        Source::CONTENT_TYPE_KANJI,
                    )) {
                        $fail('The selected source is invalid for this JLPT level.');
                    }
                },
            ],
            'character' => ['required', 'string', 'max:10'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('kanji', 'slug')->ignore($kanji?->id)],
            'chapter' => ['nullable', 'string', 'max:100'],
            'onyomi' => ['nullable', 'string', 'max:255'],
            'kunyomi' => ['nullable', 'string', 'max:255'],
            'meaning' => ['required', 'string', 'max:255'],
            'meaning_mm' => ['nullable', 'string', 'max:255'],
            'example_sentence' => ['nullable', 'string', 'max:1000'],
            'example_translation' => ['nullable', 'string', 'max:1000'],
            'example_translation_mm' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['source_id'] = $request->filled('source_id') ? (int) $request->input('source_id') : null;
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
