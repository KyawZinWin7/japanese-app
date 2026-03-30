<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\JlptLevel;
use App\Models\Lesson;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();

        $query = Lesson::query()
            ->with('jlptLevel:id,name,slug')
            ->orderBy('sort_order')
            ->orderBy('title');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', function ($builder) use ($selectedLevel) {
                $builder->where('slug', $selectedLevel);
            });
        }

        $paginator = $query->paginate(10)->withQueryString();

        return view('vue-page', [
            'title' => 'Manage Lessons',
            'pageComponent' => 'admin-lessons',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'level' => $selectedLevel,
                ],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'lessons' => collect($paginator->items())->map(function (Lesson $lesson) {
                    return [
                        'id' => $lesson->id,
                        'title' => $lesson->title,
                        'slug' => $lesson->slug,
                        'excerpt' => $lesson->excerpt,
                        'sort_order' => $lesson->sort_order,
                        'is_published' => $lesson->is_published,
                        'level' => [
                            'name' => $lesson->jlptLevel?->name,
                            'slug' => $lesson->jlptLevel?->slug,
                        ],
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
                    'publicIndex' => route('lessons.index'),
                    'create' => route('admin.lessons.create'),
                    'editBase' => url('/admin/lessons'),
                    'index' => route('admin.lessons.index'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Lessons',
                    'Maintain lesson content for the frontend learning area.',
                    'lessons',
                ),
            ],
        ]);
    }

    public function create()
    {
        return $this->formPage(new Lesson([
            'is_published' => true,
        ]), 'create', route('admin.lessons.store'));
    }

    public function store(LessonRequest $request): RedirectResponse
    {
        Lesson::create($request->validated());

        return redirect()->route('admin.lessons.index')->with('status', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        return $this->formPage($lesson, 'edit', route('admin.lessons.update', $lesson));
    }

    public function update(LessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($request->validated());

        return redirect()->route('admin.lessons.index')->with('status', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('status', 'Lesson deleted successfully.');
    }

    protected function formPage(Lesson $lesson, string $mode, string $action)
    {
        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Lesson' : 'Edit Lesson',
            'pageComponent' => 'admin-lesson-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'lesson' => [
                    'id' => $lesson->id,
                    'jlpt_level_id' => old('jlpt_level_id', $lesson->jlpt_level_id ?? ''),
                    'title' => old('title', $lesson->title ?? ''),
                    'slug' => old('slug', $lesson->slug ?? ''),
                    'excerpt' => old('excerpt', $lesson->excerpt ?? ''),
                    'content' => old('content', $lesson->content ?? ''),
                    'sort_order' => old('sort_order', $lesson->sort_order ?? ''),
                    'is_published' => old('is_published', $lesson->is_published ?? true),
                ],
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.lessons.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Lesson' : 'Edit Lesson',
                    'Create or update lesson content for learners.',
                    'lessons',
                ),
            ],
        ]);
    }
}
