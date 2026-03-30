<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use App\Models\Source;
use App\Support\AdminLayoutData;
use App\Models\Vocabulary;
use App\Services\ContentSourceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VocabularyController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedSource = $request->string('source')->toString();
        $search = trim($request->string('search')->toString());

        $query = Vocabulary::query()
            ->with('jlptLevel:id,name,slug', 'source:id,name,slug')
            ->orderBy('sort_order')
            ->orderBy('word');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel));
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

        $paginator = $query->paginate(15)->withQueryString();

        return view('vue-page', [
            'title' => 'Manage Vocabulary',
            'pageComponent' => 'admin-vocabulary',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'level' => $selectedLevel,
                    'source' => $selectedSource,
                    'search' => $search,
                ],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_VOCABULARY),
                'items' => collect($paginator->items())->map(function (Vocabulary $item) {
                    return [
                        'id' => $item->id,
                        'word' => $item->word,
                        'slug' => $item->slug,
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
                    'publicIndex' => route('vocabulary.index'),
                    'index' => route('admin.vocabulary.index'),
                    'create' => route('admin.vocabulary.create'),
                    'editBase' => url('/admin/vocabulary'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Vocabulary',
                    'Control searchable vocabulary entries for learners.',
                    'vocabulary',
                ),
            ],
        ]);
    }

    public function create(Request $request)
    {
        return $this->formPage(new Vocabulary([
            'jlpt_level_id' => $this->levelIdFromSlug($request->string('level')->toString()),
            'source_id' => $this->sourceIdFromSlug($request->string('source')->toString(), Source::CONTENT_TYPE_VOCABULARY),
            'is_published' => true,
        ]), 'create', route('admin.vocabulary.store'));
    }

    public function store(Request $request): RedirectResponse
    {
        Vocabulary::create($this->validatePayload($request));

        return redirect()->route('admin.vocabulary.index')->with('status', 'Vocabulary created successfully.');
    }

    public function edit(Vocabulary $vocabulary)
    {
        return $this->formPage($vocabulary, 'edit', route('admin.vocabulary.update', $vocabulary));
    }

    public function update(Request $request, Vocabulary $vocabulary): RedirectResponse
    {
        $vocabulary->update($this->validatePayload($request, $vocabulary));

        return redirect()->route('admin.vocabulary.index')->with('status', 'Vocabulary updated successfully.');
    }

    public function destroy(Vocabulary $vocabulary): RedirectResponse
    {
        $vocabulary->delete();

        return redirect()->route('admin.vocabulary.index')->with('status', 'Vocabulary deleted successfully.');
    }

    protected function formPage(Vocabulary $vocabulary, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Vocabulary' : 'Edit Vocabulary',
            'pageComponent' => 'admin-vocabulary-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'item' => [
                    'id' => $vocabulary->id,
                    'jlpt_level_id' => old('jlpt_level_id', $vocabulary->jlpt_level_id ?? ''),
                    'source_id' => old('source_id', $vocabulary->source_id ?? ''),
                    'chapter' => old('chapter', $vocabulary->chapter ?? ''),
                    'word' => old('word', $vocabulary->word ?? ''),
                    'slug' => old('slug', $vocabulary->slug ?? ''),
                    'reading' => old('reading', $vocabulary->reading ?? ''),
                    'meaning' => old('meaning', $vocabulary->meaning ?? ''),
                    'meaning_mm' => old('meaning_mm', $vocabulary->meaning_mm ?? ''),
                    'example_sentence' => old('example_sentence', $vocabulary->example_sentence ?? ''),
                    'example_translation' => old('example_translation', $vocabulary->example_translation ?? ''),
                    'sort_order' => old('sort_order', $vocabulary->sort_order ?? ''),
                    'is_published' => old('is_published', $vocabulary->is_published ?? true),
                ],
                'sources' => ContentSourceService::optionsForType(Source::CONTENT_TYPE_VOCABULARY),
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.vocabulary.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Vocabulary' : 'Edit Vocabulary',
                    'Manage the word, reading, meaning, and examples.',
                    'vocabulary',
                ),
            ],
        ]);
    }

    protected function validatePayload(Request $request, ?Vocabulary $vocabulary = null): array
    {
        $validated = $request->validate([
            'jlpt_level_id' => ['required', 'exists:jlpt_levels,id'],
            'source_id' => [
                Rule::requiredIf(fn () => ContentSourceService::shouldRequireForLevel(
                    $request->integer('jlpt_level_id') ?: null,
                    Source::CONTENT_TYPE_VOCABULARY,
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
                        Source::CONTENT_TYPE_VOCABULARY,
                    )) {
                        $fail('The selected source is invalid for this JLPT level.');
                    }
                },
            ],
            'word' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('vocabularies', 'slug')->ignore($vocabulary?->id)],
            'chapter' => ['nullable', 'string', 'max:100'],
            'reading' => ['required', 'string', 'max:255'],
            'meaning' => ['required', 'string', 'max:255'],
            'meaning_mm' => ['nullable', 'string', 'max:255'],
            'example_sentence' => ['nullable', 'string', 'max:1000'],
            'example_translation' => ['nullable', 'string', 'max:1000'],
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
