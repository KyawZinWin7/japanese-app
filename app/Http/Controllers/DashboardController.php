<?php

namespace App\Http\Controllers;

use App\Models\JlptLevel;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (! $user->is_admin) {
            return redirect()->route('study.home');
        }

        $totalLessons = Lesson::query()->where('is_published', true)->count();
        $completedLessons = $user->completedLessons()->count();
        $lessonCompletionRate = $totalLessons > 0
            ? (int) round(($completedLessons / $totalLessons) * 100)
            : 0;

        $quizAttempts = $user->kanjiQuizAttempts()
            ->with('quiz:id,title,slug,jlpt_level_id', 'quiz.jlptLevel:id,name,slug')
            ->latest()
            ->get();

        $averageQuizScore = $quizAttempts->isNotEmpty()
            ? (int) round($quizAttempts->avg(fn ($attempt) => $attempt->total_questions > 0
                ? ($attempt->score / $attempt->total_questions) * 100
                : 0))
            : 0;

        $bestQuizScore = $quizAttempts->isNotEmpty()
            ? (int) $quizAttempts->max(fn ($attempt) => $attempt->total_questions > 0
                ? (int) round(($attempt->score / $attempt->total_questions) * 100)
                : 0)
            : 0;

        $levelProgress = JlptLevel::query()
            ->withCount(['lessons as lessons_count' => fn ($query) => $query->where('is_published', true)])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($level) use ($user) {
                $completed = $user->completedLessons()
                    ->where('lessons.jlpt_level_id', $level->id)
                    ->count();
                $total = (int) $level->lessons_count;

                return [
                    'name' => $level->name,
                    'completedLessons' => $completed,
                    'totalLessons' => $total,
                    'percentage' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
                ];
            })
            ->values()
            ->all();

        return view('vue-page', [
            'title' => 'Dashboard',
            'pageComponent' => 'dashboard',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'isAdmin' => true,
                'progress' => [
                    'summary' => [
                        'completedLessons' => $completedLessons,
                        'totalLessons' => $totalLessons,
                        'lessonCompletionRate' => $lessonCompletionRate,
                        'quizAttempts' => $quizAttempts->count(),
                        'averageQuizScore' => $averageQuizScore,
                        'bestQuizScore' => $bestQuizScore,
                    ],
                    'levels' => $levelProgress,
                    'recentQuizAttempts' => $quizAttempts
                        ->take(5)
                        ->map(fn ($attempt) => [
                            'id' => $attempt->id,
                            'quizTitle' => $attempt->quiz?->title ?? 'Kanji Quiz',
                            'level' => $attempt->quiz?->jlptLevel?->name ?? 'Mixed',
                            'score' => $attempt->score,
                            'totalQuestions' => $attempt->total_questions,
                            'percentage' => $attempt->total_questions > 0
                                ? (int) round(($attempt->score / $attempt->total_questions) * 100)
                                : 0,
                        ])
                        ->values()
                        ->all(),
                ],
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'routes' => [
                    'logout' => route('logout'),
                    'adminDashboard' => route('admin.dashboard'),
                    'levels' => route('levels.index'),
                    'lessons' => route('lessons.index'),
                    'bookmarks' => route('bookmarks.index'),
                    'progress' => route('dashboard'),
                    'vocabulary' => route('vocabulary.index'),
                    'kanji' => route('kanji.index'),
                    'kanjiQuizzes' => route('kanji-quizzes.index'),
                    'kanjiFlashcards' => route('kanji-flashcards.index'),
                ],
            ],
        ]);
    }
}
