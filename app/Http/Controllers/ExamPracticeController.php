<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamPracticeSubmitRequest;
use App\Models\ExamPracticeAttempt;
use App\Models\ExamPracticeQuestion;
use App\Models\ExamPracticeSet;
use App\Support\StudyHistoryKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExamPracticeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $sets = ExamPracticeSet::query()
            ->where('is_published', true)
            ->orderBy('title')
            ->get();

        return view('vue-page', [
            'title' => 'Exam Practice',
            'pageComponent' => 'exam-practice-sets',
            'pageProps' => [
                'items' => $sets->map(fn (ExamPracticeSet $set) => [
                    'title' => $set->title,
                    'slug' => $set->slug,
                    'description' => $set->description,
                    'exam_code' => $set->exam_code,
                    'question_count' => $set->question_count,
                    'showUrl' => route('exam-practice.show', $set),
                ])->values()->all(),
                'viewer' => [
                    'isAuthenticated' => $user !== null,
                    'isApproved' => (bool) ($user?->is_approved),
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                    'pendingUrl' => $user ? route('approval.pending') : route('login'),
                ],
            ],
        ]);
    }

    public function show(Request $request, ExamPracticeSet $set)
    {
        abort_unless($set->is_published, 404);

        $user = $request->user();

        return view('vue-page', [
            'title' => $set->title,
            'pageComponent' => 'exam-practice-detail',
            'pageProps' => [
                'set' => [
                    'title' => $set->title,
                    'description' => $set->description,
                    'exam_code' => $set->exam_code,
                    'question_count' => $set->question_count,
                    'takeUrl' => route('exam-practice.take', $set),
                ],
                'latestAttempt' => $user
                    ? $user->examPracticeAttempts()
                        ->where('exam_practice_set_id', $set->id)
                        ->latest()
                        ->first(['id', 'score', 'total_questions'])?->toArray()
                    : null,
                'viewer' => [
                    'isAuthenticated' => $user !== null,
                    'isApproved' => (bool) ($user?->is_approved),
                    'loginUrl' => route('login'),
                    'pendingUrl' => $user ? route('approval.pending') : route('login'),
                ],
                'routes' => [
                    'index' => route('exam-practice.index'),
                    'login' => route('login'),
                ],
            ],
        ]);
    }

    public function take(Request $request, ExamPracticeSet $set)
    {
        abort_unless($set->is_published, 404);
        $set->load(['questions' => fn ($query) => $query->orderBy('sort_order')]);

        return view('vue-page', [
            'title' => 'Take Exam Practice',
            'pageComponent' => 'exam-practice-take',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'set' => [
                    'title' => $set->title,
                    'description' => $set->description,
                    'exam_code' => $set->exam_code,
                    'submitUrl' => route('exam-practice.submit', $set),
                    'questions' => $set->questions->map(fn (ExamPracticeQuestion $question) => [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => $question->options,
                        'allowsMultipleAnswers' => $question->allowsMultipleAnswers(),
                        'requiredAnswerCount' => $question->requiredAnswerCount(),
                        'correctAnswers' => $question->correctOptionValues(),
                        'explanation' => $question->explanation,
                    ])->all(),
                ],
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'oldAnswers' => old('answers', []),
                'studyState' => $request->user()->studyHistoryEntries()
                    ->where('entry_key', StudyHistoryKey::quiz(route('exam-practice.show', $set)))
                    ->first()?->state ?? [],
                'routes' => [
                    'detail' => route('exam-practice.show', $set),
                ],
            ],
        ]);
    }

    public function submit(ExamPracticeSubmitRequest $request, ExamPracticeSet $set): RedirectResponse
    {
        abort_unless($set->is_published, 404);
        $set->load('questions');

        $submitted = $request->input('answers', []);
        $revealedQuestionIds = collect($request->input('revealed_questions', []))
            ->map(fn ($questionId) => (string) $questionId)
            ->unique()
            ->values()
            ->all();
        $score = 0;
        $answers = [];

        foreach ($set->questions as $question) {
            $selected = $this->normalizeSelectedAnswers($submitted[$question->id] ?? null);
            $correct = $question->correctOptionValues();
            $isCorrect = $this->answersMatch($selected, $correct);

            if ($isCorrect) {
                $score++;
            }

            $answers[] = [
                'question_id' => $question->id,
                'question' => $question->question,
                'selected' => $question->allowsMultipleAnswers() ? $selected : ($selected[0] ?? null),
                'correct' => $question->allowsMultipleAnswers() ? $correct : ($correct[0] ?? null),
                'explanation' => $question->explanation,
                'is_correct' => $isCorrect,
                'answer_revealed' => in_array((string) $question->id, $revealedQuestionIds, true),
            ];
        }

        $attempt = ExamPracticeAttempt::create([
            'exam_practice_set_id' => $set->id,
            'user_id' => $request->user()->id,
            'score' => $score,
            'total_questions' => $set->questions->count(),
            'answers' => $answers,
        ]);

        return redirect()->route('exam-practice.results.show', [$set, $attempt]);
    }

    public function result(Request $request, ExamPracticeSet $set, ExamPracticeAttempt $attempt)
    {
        abort_unless($set->is_published, 404);
        abort_unless($attempt->exam_practice_set_id === $set->id && $attempt->user_id === $request->user()->id, 404);

        return view('vue-page', [
            'title' => 'Exam Practice Result',
            'pageComponent' => 'exam-practice-result',
            'pageProps' => [
                'result' => [
                    'setTitle' => $set->title,
                    'score' => $attempt->score,
                    'total' => $attempt->total_questions,
                    'percentage' => $attempt->total_questions > 0
                        ? (int) round(($attempt->score / $attempt->total_questions) * 100)
                        : 0,
                    'answers' => $attempt->answers,
                ],
                'routes' => [
                    'index' => route('exam-practice.index'),
                    'detail' => route('exam-practice.show', $set),
                    'retry' => route('exam-practice.take', $set),
                ],
            ],
        ]);
    }

    private function normalizeSelectedAnswers(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => trim((string) $item))
                ->filter(fn ($item) => $item !== '')
                ->unique()
                ->values()
                ->all();
        }

        $normalized = trim((string) $value);

        return $normalized === '' ? [] : [$normalized];
    }

    private function answersMatch(array $selected, array $correct): bool
    {
        sort($selected);
        sort($correct);

        return $selected === $correct;
    }
}
