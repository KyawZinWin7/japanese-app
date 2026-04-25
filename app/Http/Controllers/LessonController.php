<?php

namespace App\Http\Controllers;

use App\Models\JlptLevel;
use App\Models\Lesson;
use App\Support\StudyHistoryKey;
use App\Support\StudyAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();
        $levelIds = StudyAccess::allowedLevelIds($request->user());

        $query = Lesson::query()
            ->with('jlptLevel:id,name,slug')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->orderBy('sort_order')
            ->orderBy('title');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', function ($builder) use ($selectedLevel, $levelIds) {
                $builder->where('slug', $selectedLevel)->whereIn('id', $levelIds);
            });
        }

        $paginator = $query->paginate(6)->withQueryString();
        $bookmarkIds = $request->user()->bookmarkedLessons()->pluck('lesson_id')->all();
        $completedIds = $request->user()->completedLessons()->pluck('lesson_id')->all();

        return view('vue-page', [
            'title' => 'Lessons',
            'pageComponent' => 'lessons',
            'pageProps' => [
                'filters' => [
                    'level' => $selectedLevel,
                ],
                'levels' => JlptLevel::query()->whereIn('id', $levelIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'lessons' => collect($paginator->items())->map(function (Lesson $lesson) use ($bookmarkIds, $completedIds) {
                    return [
                        'id' => $lesson->id,
                        'title' => $lesson->title,
                        'slug' => $lesson->slug,
                        'excerpt' => $lesson->excerpt,
                        'sort_order' => $lesson->sort_order,
                        'canBookmark' => true,
                        'bookmarkUrl' => route('lessons.bookmarks.toggle', $lesson),
                        'isBookmarked' => in_array($lesson->id, $bookmarkIds, true),
                        'completionUrl' => route('lessons.complete.toggle', $lesson),
                        'isCompleted' => in_array($lesson->id, $completedIds, true),
                        'level' => [
                            'name' => $lesson->jlptLevel?->name,
                            'slug' => $lesson->jlptLevel?->slug,
                        ],
                        'showUrl' => route('lessons.show', $lesson->slug),
                    ];
                })->values()->all(),
                'pagination' => [
                    'currentPage' => $paginator->currentPage(),
                    'lastPage' => $paginator->lastPage(),
                    'perPage' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'links' => collect($paginator->linkCollection())->map(fn ($link) => [
                        'url' => $link['url'],
                        'label' => strip_tags($link['label']),
                        'active' => $link['active'],
                    ])->all(),
                ],
                'csrfToken' => csrf_token(),
                'status' => session('status'),
                'routes' => [
                    'dashboard' => route('study.home'),
                    'index' => route('lessons.index'),
                ],
            ],
        ]);
    }

    public function show(Request $request, Lesson $lesson)
    {
        abort_unless($lesson->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $lesson->jlpt_level_id), 403);
        $lesson->load('jlptLevel:id,name,slug');
        $isBookmarked = $request->user()->bookmarkedLessons()->whereKey($lesson->id)->exists();
        $isCompleted = $request->user()->completedLessons()->whereKey($lesson->id)->exists();

        return view('vue-page', [
            'title' => $lesson->title,
            'pageComponent' => 'lesson-detail',
            'pageProps' => [
                'lesson' => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'slug' => $lesson->slug,
                    'excerpt' => $lesson->excerpt,
                    'content' => $lesson->content,
                    'sort_order' => $lesson->sort_order,
                    'canBookmark' => true,
                    'bookmarkUrl' => route('lessons.bookmarks.toggle', $lesson),
                    'isBookmarked' => $isBookmarked,
                    'completionUrl' => route('lessons.complete.toggle', $lesson),
                    'isCompleted' => $isCompleted,
                    'level' => [
                        'name' => $lesson->jlptLevel?->name,
                        'slug' => $lesson->jlptLevel?->slug,
                    ],
                ],
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'csrfToken' => csrf_token(),
                'status' => session('status'),
                'routes' => [
                    'index' => route('lessons.index'),
                ],
                'studyState' => $request->user()->studyHistoryEntries()
                    ->where('entry_key', StudyHistoryKey::fromPath($request, 'lesson', false))
                    ->first()?->state ?? [],
            ],
        ]);
    }

    public function toggleBookmark(Request $request, Lesson $lesson): RedirectResponse
    {
        abort_unless(StudyAccess::canAccessLevel($request->user(), $lesson->jlpt_level_id), 403);

        $relation = $request->user()->bookmarkedLessons();
        $isBookmarked = $relation->whereKey($lesson->id)->exists();

        if ($isBookmarked) {
            $relation->detach($lesson->id);
            $message = 'Lesson bookmark removed.';
        } else {
            $relation->syncWithoutDetaching([$lesson->id]);
            $message = 'Lesson bookmarked.';
        }

        return back()->with('status', $message);
    }

    public function toggleCompletion(Request $request, Lesson $lesson): RedirectResponse
    {
        abort_unless(StudyAccess::canAccessLevel($request->user(), $lesson->jlpt_level_id), 403);

        $relation = $request->user()->completedLessons();
        $isCompleted = $relation->whereKey($lesson->id)->exists();

        if ($isCompleted) {
            $relation->detach($lesson->id);
            $message = 'Lesson marked as incomplete.';
        } else {
            $relation->syncWithoutDetaching([$lesson->id]);
            $message = 'Lesson marked as completed.';
        }

        return back()->with('status', $message);
    }
}
