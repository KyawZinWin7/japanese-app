<?php

namespace App\Http\Controllers;

use App\Http\Requests\KanjiQuizSubmitRequest;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizAttempt;
use App\Support\StudyHistoryKey;
use App\Support\StudyAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KanjiQuizController extends Controller
{
    public function index(Request $request)
    {
        $levelIds = StudyAccess::allowedLevelIds($request->user());
        $levels = \App\Models\JlptLevel::query()
            ->whereIn('id', $levelIds)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug'])
            ->map(fn ($level) => [
                'id' => $level->id,
                'name' => $level->name,
                'slug' => $level->slug,
            ])
            ->values();

        $selectedLevel = (string) $request->query('level', '');
        $selectedLevelModel = $levels->firstWhere('slug', $selectedLevel);

        $quizzes = KanjiQuiz::query()
            ->with('jlptLevel:id,name,slug')
            ->where('is_published', true)
            ->whereIn('jlpt_level_id', $levelIds)
            ->when($selectedLevelModel, fn ($query) => $query->where('jlpt_level_id', $selectedLevelModel['id']))
            ->orderBy('title')
            ->get();

        return view('vue-page', [
            'title' => 'Quizzes',
            'pageComponent' => 'kanji-quizzes',
            'pageProps' => [
                'levels' => $levels->all(),
                'selectedLevel' => $selectedLevelModel ? [
                    'name' => $selectedLevelModel['name'],
                    'slug' => $selectedLevelModel['slug'],
                ] : null,
                'items' => $quizzes->map(fn (KanjiQuiz $quiz) => [
                    'title' => $quiz->title,
                    'slug' => $quiz->slug,
                    'description' => $quiz->description,
                    'question_count' => $quiz->question_count,
                    'level' => [
                        'name' => $quiz->jlptLevel?->name,
                    ],
                    'showUrl' => route('kanji-quizzes.show', $quiz),
                ])->values()->all(),
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'dashboard' => route('study.home'),
                    'kanji' => route('kanji.index'),
                    'index' => route('kanji-quizzes.index'),
                ],
            ],
        ]);
    }

    public function show(Request $request, KanjiQuiz $quiz)
    {
        abort_unless($quiz->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $quiz->jlpt_level_id), 403);
        $quiz->load('jlptLevel:id,name,slug', 'questions');

        return view('vue-page', [
            'title' => $quiz->title,
            'pageComponent' => 'kanji-quiz-detail',
            'pageProps' => [
                'quiz' => [
                    'title' => $quiz->title,
                    'description' => $quiz->description,
                    'question_count' => $quiz->questions->count(),
                    'level' => [
                        'name' => $quiz->jlptLevel?->name,
                    ],
                    'takeUrl' => route('kanji-quizzes.take', $quiz),
                ],
                'latestAttempt' => $request->user()->kanjiQuizAttempts()
                    ->where('kanji_quiz_id', $quiz->id)
                    ->latest()
                    ->first(['id', 'score', 'total_questions'])?->toArray(),
                'viewer' => [
                    'isAuthenticated' => true,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'index' => route('kanji-quizzes.index'),
                    'login' => route('login'),
                ],
            ],
        ]);
    }

    public function take(Request $request, KanjiQuiz $quiz)
    {
        abort_unless($quiz->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $quiz->jlpt_level_id), 403);
        $quiz->load('jlptLevel:id,name,slug', 'questions');

        return view('vue-page', [
            'title' => 'Take Quiz',
            'pageComponent' => 'kanji-quiz-take',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'quiz' => [
                    'title' => $quiz->title,
                    'description' => $quiz->description,
                    'level' => [
                        'name' => $quiz->jlptLevel?->name,
                    ],
                    'submitUrl' => route('kanji-quizzes.submit', $quiz),
                    'questions' => $quiz->questions
                        ->sortBy('sort_order')
                        ->values()
                        ->map(fn ($question) => [
                            'id' => $question->id,
                            'quiz_type' => $question->quiz_type ?: 'kanji',
                            'question' => $question->question ?: $question->prompt,
                            'highlight_text' => $question->highlight_text,
                            'options' => $question->options,
                        ])->all(),
                ],
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'oldAnswers' => old('answers', []),
                'studyState' => $request->user()->studyHistoryEntries()
                    ->where('entry_key', StudyHistoryKey::quiz(route('kanji-quizzes.show', $quiz)))
                    ->first()?->state ?? [],
                'routes' => [
                    'detail' => route('kanji-quizzes.show', $quiz),
                ],
            ],
        ]);
    }

    public function submit(KanjiQuizSubmitRequest $request, KanjiQuiz $quiz): RedirectResponse
    {
        abort_unless($quiz->is_published, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $quiz->jlpt_level_id), 403);
        $quiz->load('questions');

        $submitted = $request->validated('answers');
        $score = 0;
        $answers = [];

        foreach ($quiz->questions as $question) {
            $selected = $submitted[$question->id] ?? null;
            $isCorrect = $selected === $question->correct_answer;

            if ($isCorrect) {
                $score++;
            }

            $answers[] = [
                'question_id' => $question->id,
                'question' => $question->question ?: $question->prompt,
                'quiz_type' => $question->quiz_type ?: 'kanji',
                'selected' => $selected,
                'correct' => $question->correct_answer,
                'explanation' => $question->explanation,
                'is_correct' => $isCorrect,
            ];
        }

        $attempt = KanjiQuizAttempt::create([
            'kanji_quiz_id' => $quiz->id,
            'user_id' => $request->user()->id,
            'score' => $score,
            'total_questions' => $quiz->questions->count(),
            'answers' => $answers,
        ]);

        return redirect()->route('kanji-quizzes.results.show', [$quiz, $attempt]);
    }

    public function result(Request $request, KanjiQuiz $quiz, KanjiQuizAttempt $attempt)
    {
        abort_unless($attempt->kanji_quiz_id === $quiz->id && $attempt->user_id === $request->user()->id, 404);
        abort_unless(StudyAccess::canAccessLevel($request->user(), $quiz->jlpt_level_id), 403);

        return view('vue-page', [
            'title' => 'Quiz Result',
            'pageComponent' => 'kanji-quiz-result',
            'pageProps' => [
                'result' => [
                    'quizTitle' => $quiz->title,
                    'score' => $attempt->score,
                    'total' => $attempt->total_questions,
                    'percentage' => $attempt->total_questions > 0
                        ? (int) round(($attempt->score / $attempt->total_questions) * 100)
                        : 0,
                    'answers' => $attempt->answers,
                ],
                'routes' => [
                    'index' => route('kanji-quizzes.index'),
                    'detail' => route('kanji-quizzes.show', $quiz),
                    'retry' => route('kanji-quizzes.take', $quiz),
                ],
            ],
        ]);
    }
}
