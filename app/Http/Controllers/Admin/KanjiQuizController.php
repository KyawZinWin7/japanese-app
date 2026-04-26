<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KanjiQuizRequest;
use App\Models\JlptLevel;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizQuestion;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KanjiQuizController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->string('level')->toString();

        $query = KanjiQuiz::query()
            ->with('jlptLevel:id,name,slug')
            ->withCount('questions')
            ->orderBy('title');

        if ($selectedLevel !== '') {
            $query->whereHas('jlptLevel', fn ($builder) => $builder->where('slug', $selectedLevel));
        }

        $paginator = $query->paginate(10)->withQueryString();

        return view('vue-page', [
            'title' => 'Manage Quizzes',
            'pageComponent' => 'admin-kanji-quizzes',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'level' => $selectedLevel,
                ],
                'layout' => AdminLayoutData::make(
                    'Manage Quizzes',
                    'Create JLPT-based quizzes and keep question sets organized.',
                    'kanji-quizzes',
                ),
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'items' => collect($paginator->items())->map(fn (KanjiQuiz $quiz) => [
                    'title' => $quiz->title,
                    'slug' => $quiz->slug,
                    'question_count' => $quiz->questions_count,
                    'is_published' => $quiz->is_published,
                    'level' => [
                        'name' => $quiz->jlptLevel?->name,
                        'slug' => $quiz->jlptLevel?->slug,
                    ],
                ])->values()->all(),
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
                    'publicIndex' => route('kanji-quizzes.index'),
                    'index' => route('admin.kanji-quizzes.index'),
                    'create' => route('admin.kanji-quizzes.create'),
                    'editBase' => url('/admin/kanji-quizzes'),
                ],
                'status' => session('status'),
            ],
        ]);
    }

    public function create(Request $request)
    {
        return $this->formPage(
            new KanjiQuiz([
                'jlpt_level_id' => $this->levelIdFromSlug($request->string('level')->toString()),
                'is_published' => true,
            ]),
            'create',
            route('admin.kanji-quizzes.store'),
        );
    }

    public function store(KanjiQuizRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $quiz = KanjiQuiz::create([
                'jlpt_level_id' => $validated['jlpt_level_id'],
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'question_count' => count($validated['questions']),
                'is_published' => $validated['is_published'] ?? false,
            ]);

            $this->syncQuestions($quiz, $validated['questions']);
        });

        return redirect()->route('admin.kanji-quizzes.index')->with('status', 'Quiz created successfully.');
    }

    public function edit(KanjiQuiz $quiz)
    {
        $quiz->load(['questions' => fn ($query) => $query->orderBy('sort_order')]);

        return $this->formPage($quiz, 'edit', route('admin.kanji-quizzes.update', $quiz));
    }

    public function update(KanjiQuizRequest $request, KanjiQuiz $quiz): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($quiz, $validated) {
            $quiz->update([
                'jlpt_level_id' => $validated['jlpt_level_id'],
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'question_count' => count($validated['questions']),
                'is_published' => $validated['is_published'] ?? false,
            ]);

            $this->syncQuestions($quiz, $validated['questions']);
        });

        return redirect()->route('admin.kanji-quizzes.index')->with('status', 'Quiz updated successfully.');
    }

    public function destroy(KanjiQuiz $quiz): RedirectResponse
    {
        $quiz->delete();

        return redirect()->route('admin.kanji-quizzes.index')->with('status', 'Quiz deleted successfully.');
    }

    protected function formPage(KanjiQuiz $quiz, string $mode, string $action)
    {
        $questions = old('questions', $quiz->relationLoaded('questions')
            ? $quiz->questions->map(fn (KanjiQuizQuestion $question) => [
                'id' => $question->id,
                'quiz_type' => $question->quiz_type ?: 'kanji',
                'question' => $question->question ?: $question->prompt,
                'highlight_text' => $question->highlight_text,
                'options' => $question->options ?? [],
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'sort_order' => $question->sort_order,
            ])->values()->all()
            : [[
                'id' => null,
                'quiz_type' => 'kanji',
                'question' => '',
                'highlight_text' => '',
                'options' => ['', '', '', ''],
                'correct_answer' => '',
                'explanation' => '',
                'sort_order' => 1,
            ]]);

        $normalizedQuestions = collect($questions)->map(function (array $question, int $index) {
            $options = collect($question['options'] ?? [])
                ->pad(4, '')
                ->take(6)
                ->values()
                ->all();

            return [
                'id' => $question['id'] ?? null,
                'quiz_type' => $question['quiz_type'] ?? 'kanji',
                'question' => $question['question'] ?? '',
                'highlight_text' => $question['highlight_text'] ?? '',
                'options' => $options,
                'correct_answer' => $question['correct_answer'] ?? '',
                'explanation' => $question['explanation'] ?? '',
                'sort_order' => $question['sort_order'] ?? ($index + 1),
            ];
        })->values()->all();

        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Quiz' : 'Edit Quiz',
            'pageComponent' => 'admin-kanji-quiz-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Quiz' : 'Edit Quiz',
                    'Choose a JLPT level, add quiz questions, and publish when it is ready.',
                    'kanji-quizzes',
                ),
                'levels' => JlptLevel::query()->orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
                'existingQuizzes' => KanjiQuiz::query()
                    ->orderBy('title')
                    ->get(['id', 'slug'])
                    ->map(fn (KanjiQuiz $item) => [
                        'id' => $item->id,
                        'slug' => $item->slug,
                    ])
                    ->values()
                    ->all(),
                'quiz' => [
                    'id' => $quiz->id,
                    'jlpt_level_id' => old('jlpt_level_id', $quiz->jlpt_level_id ?? ''),
                    'title' => old('title', $quiz->title ?? ''),
                    'slug' => old('slug', $quiz->slug ?? ''),
                    'description' => old('description', $quiz->description ?? ''),
                    'is_published' => old('is_published', $quiz->is_published ?? true),
                    'questions' => $normalizedQuestions,
                ],
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.kanji-quizzes.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
            ],
        ]);
    }

    protected function syncQuestions(KanjiQuiz $quiz, array $questions): void
    {
        $keptIds = [];

        foreach ($questions as $index => $questionData) {
            $question = isset($questionData['id'])
                ? $quiz->questions()->whereKey($questionData['id'])->first()
                : null;

            if (! $question) {
                $question = new KanjiQuizQuestion();
                $question->kanji_quiz_id = $quiz->id;
            }

            $question->fill([
                'kanji_id' => null,
                'prompt' => $questionData['question'],
                'question_type' => $questionData['quiz_type'],
                'quiz_type' => $questionData['quiz_type'],
                'question' => $questionData['question'],
                'highlight_text' => $questionData['highlight_text'] ?? null,
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'] ?? null,
                'sort_order' => $questionData['sort_order'] ?: ($index + 1),
            ]);
            $question->save();

            $keptIds[] = $question->id;
        }

        $quiz->questions()->whereNotIn('id', $keptIds)->delete();
    }

    protected function levelIdFromSlug(string $slug): ?int
    {
        if ($slug === '') {
            return null;
        }

        return JlptLevel::query()->where('slug', $slug)->value('id');
    }
}
