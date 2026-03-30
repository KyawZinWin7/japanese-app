<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JlptLevelRequest;
use App\Models\JlptLevel;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;

class JlptLevelController extends Controller
{
    public function index()
    {
        return view('vue-page', [
            'title' => 'Manage JLPT Levels',
            'pageComponent' => 'admin-jlpt-levels',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'levels' => JlptLevel::query()
                    ->orderBy('sort_order')
                    ->get(['id', 'name', 'slug', 'sort_order', 'description'])
                    ->toArray(),
                'routes' => [
                    'publicIndex' => route('levels.index'),
                    'create' => route('admin.levels.create'),
                    'editBase' => url('/admin/levels'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage JLPT Levels',
                    'Create, edit, and organize your JLPT structure.',
                    'levels',
                ),
            ],
        ]);
    }

    public function create()
    {
        return $this->formPage(new JlptLevel(), 'create', route('admin.levels.store'));
    }

    public function store(JlptLevelRequest $request): RedirectResponse
    {
        JlptLevel::create($request->validated());

        return redirect()
            ->route('admin.levels.index')
            ->with('status', 'JLPT level created successfully.');
    }

    public function edit(JlptLevel $level)
    {
        return $this->formPage($level, 'edit', route('admin.levels.update', $level));
    }

    public function update(JlptLevelRequest $request, JlptLevel $level): RedirectResponse
    {
        $level->update($request->validated());

        return redirect()
            ->route('admin.levels.index')
            ->with('status', 'JLPT level updated successfully.');
    }

    public function destroy(JlptLevel $level): RedirectResponse
    {
        $level->delete();

        return redirect()
            ->route('admin.levels.index')
            ->with('status', 'JLPT level deleted successfully.');
    }

    protected function formPage(JlptLevel $level, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create JLPT Level' : 'Edit JLPT Level',
            'pageComponent' => 'admin-jlpt-level-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'level' => [
                    'id' => $level->id,
                    'name' => old('name', $level->name ?? ''),
                    'slug' => old('slug', $level->slug ?? ''),
                    'sort_order' => old('sort_order', $level->sort_order ?? ''),
                    'description' => old('description', $level->description ?? ''),
                ],
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.levels.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create JLPT Level' : 'Edit JLPT Level',
                    'Update the level label, slug, and study order.',
                    'levels',
                ),
            ],
        ]);
    }
}
