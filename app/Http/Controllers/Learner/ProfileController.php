<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use App\Models\KanjiQuizAttempt;
use App\Models\Lesson;
use App\Models\StudyHistory;
use App\Support\StudyAccess;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $levelIds = StudyAccess::allowedLevelIds($user);

        $publishedLessonCount = Lesson::query()
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->count();

        $levels = JlptLevel::query()
            ->whereIn('id', $levelIds)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'sort_order', 'description'])
            ->map(fn (JlptLevel $level) => [
                'id' => $level->id,
                'name' => $level->name,
                'slug' => $level->slug,
                'sortOrder' => $level->sort_order,
                'description' => $level->description,
            ])
            ->values()
            ->all();

        $completedLessons = $user->completedLessons()
            ->where('is_published', true)
            ->count();

        $bookmarkedLessons = $user->bookmarkedLessons()
            ->where('is_published', true)
            ->count();

        $quizAttempts = $user->kanjiQuizAttempts()->get(['score', 'total_questions']);
        $quizAttemptsCount = $quizAttempts->count();
        $averageQuizScore = $quizAttemptsCount > 0
            ? (int) round($quizAttempts->avg(function (KanjiQuizAttempt $attempt) {
                return $attempt->total_questions > 0
                    ? ($attempt->score / $attempt->total_questions) * 100
                    : 0;
            }))
            : null;

        $recentStudy = $user->studyHistoryEntries()
            ->latest('last_accessed_at')
            ->limit(8)
            ->get();

        $resumeItems = $user->studyHistoryEntries()
            ->where('is_resume', true)
            ->latest('last_accessed_at')
            ->limit(4)
            ->get();

        return view('vue-page', [
            'title' => 'Profile',
            'pageComponent' => 'profile',
            'pageProps' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'joinedAt' => optional($user->created_at)->format('M j, Y'),
                ],
                'progress' => [
                    'completedLessons' => $completedLessons,
                    'totalLessons' => $publishedLessonCount,
                    'completionRate' => $publishedLessonCount > 0
                        ? (int) round(($completedLessons / $publishedLessonCount) * 100)
                        : 0,
                    'bookmarkedLessons' => $bookmarkedLessons,
                    'quizAttempts' => $quizAttemptsCount,
                    'averageQuizScore' => $averageQuizScore,
                ],
                'resumeItems' => $resumeItems->map(fn (StudyHistory $entry) => $this->mapStudyHistoryEntry($entry))->values()->all(),
                'historyItems' => $recentStudy->map(fn (StudyHistory $entry) => $this->mapStudyHistoryEntry($entry))->values()->all(),
                'levels' => $levels,
                'routes' => [
                    'levels' => route('levels.index'),
                ],
            ],
        ]);
    }

    private function mapStudyHistoryEntry(StudyHistory $entry): array
    {
        return [
            'id' => $entry->entry_key,
            'href' => $entry->href,
            'title' => $entry->title,
            'subtitle' => $entry->subtitle,
            'progressLabel' => $entry->progress_label,
            'updatedAtLabel' => optional($entry->last_accessed_at)->format('M j, Y g:i A'),
        ];
    }
}
