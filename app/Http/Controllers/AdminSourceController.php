<?php

namespace App\Http\Controllers;

use App\Http\SourceRequest;
use App\Models\JlptLevel;
use App\Models\Source;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSourceController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $selectedType = $request->string('content_type')->toString();

        $query = Source::query()
            ->with('jlptLevel:id,name,slug')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel));
        }

        if ($selectedType !== '') {
            $query->where('content_type', $selectedType);
        }

        return view('vue-page', [
            'title' => 'Manage Sources',
            'pageComponent' => 'admin-sources',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'level' => $selectedLevel,
                    'content_type' => $selectedType,
                ],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'contentTypes' => collect(Source::contentTypeOptions())->map(fn (string $type) => [
                    'value' => $type,
                    'label' => str($type)->headline()->toString(),
                ])->all(),
                'items' => $query->get()->map(fn (Source $source) => [
                    'id' => $source->id,
                    'name' => $source->name,
                    'slug' => $source->slug,
                    'content_type' => $source->content_type,
                    'sort_order' => $source->sort_order,
                    'is_active' => $source->is_active,
                    'level' => [
                        'name' => $source->jlptLevel?->name,
                        'slug' => $source->jlptLevel?->slug,
                    ],
                ])->values()->all(),
                'routes' => [
                    'create' => route('admin.sources.create'),
                    'index' => route('admin.sources.index'),
                    'editBase' => url('/admin/sources'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Sources',
                    'Create reusable book and source options for vocabulary and kanji.',
                    'sources',
                ),
            ],
        ]);
    }

    public function create(Request $request)
    {
        $source = new Source([
            'jlpt_level_id' => $this->levelIdFromSlug($request->string('level')->toString()),
            'content_type' => $request->string('content_type')->toString() ?: Source::CONTENT_TYPE_BOTH,
            'is_active' => true,
        ]);

        return $this->formPage($source, 'create', route('admin.sources.store'));
    }

    public function store(SourceRequest $request): RedirectResponse
    {
        Source::create($request->validated());

        return redirect()->route('admin.sources.index')->with('status', 'Source created successfully.');
    }

    public function edit(Source $source)
    {
        return $this->formPage($source, 'edit', route('admin.sources.update', $source));
    }

    public function update(SourceRequest $request, Source $source): RedirectResponse
    {
        $source->update($request->validated());

        return redirect()->route('admin.sources.index')->with('status', 'Source updated successfully.');
    }

    public function destroy(Source $source): RedirectResponse
    {
        $source->delete();

        return redirect()->route('admin.sources.index')->with('status', 'Source deleted successfully.');
    }

    protected function formPage(Source $source, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Source' : 'Edit Source',
            'pageComponent' => 'admin-source-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'item' => [
                    'id' => $source->id,
                    'jlpt_level_id' => old('jlpt_level_id', $source->jlpt_level_id ?? ''),
                    'name' => old('name', $source->name ?? ''),
                    'slug' => old('slug', $source->slug ?? ''),
                    'content_type' => old('content_type', $source->content_type ?? Source::CONTENT_TYPE_BOTH),
                    'sort_order' => old('sort_order', $source->sort_order ?? 1),
                    'is_active' => old('is_active', $source->is_active ?? true),
                ],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'contentTypes' => collect(Source::contentTypeOptions())->map(fn (string $type) => [
                    'value' => $type,
                    'label' => str($type)->headline()->toString(),
                ])->all(),
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.sources.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Source' : 'Edit Source',
                    'Set the JLPT level, source name, and supported content types.',
                    'sources',
                ),
            ],
        ]);
    }

    protected function levelIdFromSlug(string $slug): ?int
    {
        if ($slug === '') {
            return null;
        }

        return JlptLevel::query()->where('slug', $slug)->value('id');
    }
}
