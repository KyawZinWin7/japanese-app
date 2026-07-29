<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamPracticeSetRequest;
use App\Models\ExamPracticeQuestion;
use App\Models\ExamPracticeSet;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamPracticeController extends Controller
{
    public function index()
    {
        $paginator = ExamPracticeSet::query()
            ->orderBy('title')
            ->paginate(10);

        return view('vue-page', [
            'title' => 'Manage Exam Practice',
            'pageComponent' => 'admin-exam-practice',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'layout' => AdminLayoutData::make(
                    'Manage Exam Practice',
                    'Create and organize one-question-at-a-time exam practice sets.',
                    'exam-practice',
                ),
                'items' => collect($paginator->items())->map(fn (ExamPracticeSet $set) => [
                    'title' => $set->title,
                    'slug' => $set->slug,
                    'exam_code' => $set->exam_code,
                    'question_count' => $set->question_count,
                    'is_published' => $set->is_published,
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
                    'publicIndex' => route('exam-practice.index'),
                    'index' => route('admin.exam-practice.index'),
                    'create' => route('admin.exam-practice.create'),
                    'editBase' => url('/admin/exam-practice'),
                ],
                'status' => session('status'),
            ],
        ]);
    }

    public function create()
    {
        return $this->formPage(
            new ExamPracticeSet(['is_published' => true]),
            'create',
            route('admin.exam-practice.store'),
        );
    }

    public function store(ExamPracticeSetRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $set = ExamPracticeSet::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'exam_code' => $validated['exam_code'] ?? null,
                'question_count' => count($validated['questions']),
                'is_published' => $validated['is_published'] ?? false,
            ]);

            $this->syncQuestions($set, $validated['questions']);
        });

        return redirect()->route('admin.exam-practice.index')->with('status', 'Exam practice set created successfully.');
    }

    public function edit(ExamPracticeSet $set)
    {
        $set->load(['questions' => fn ($query) => $query->orderBy('sort_order')]);

        return $this->formPage($set, 'edit', route('admin.exam-practice.update', $set));
    }

    public function update(ExamPracticeSetRequest $request, ExamPracticeSet $set): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($set, $validated) {
            $set->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'exam_code' => $validated['exam_code'] ?? null,
                'question_count' => count($validated['questions']),
                'is_published' => $validated['is_published'] ?? false,
            ]);

            $this->syncQuestions($set, $validated['questions']);
        });

        return redirect()->route('admin.exam-practice.index')->with('status', 'Exam practice set updated successfully.');
    }

    public function destroy(ExamPracticeSet $set): RedirectResponse
    {
        $set->delete();

        return redirect()->route('admin.exam-practice.index')->with('status', 'Exam practice set deleted successfully.');
    }

    protected function formPage(ExamPracticeSet $set, string $mode, string $action)
    {
        $questions = old('questions', $set->relationLoaded('questions')
            ? $set->questions->map(fn (ExamPracticeQuestion $question) => [
                'id' => $question->id,
                'question' => $question->question,
                'options' => $question->options ?? [],
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'sort_order' => $question->sort_order,
            ])->values()->all()
            : [[
                'id' => null,
                'question' => '',
                'options' => ['', '', '', ''],
                'correct_answer' => '',
                'explanation' => '',
                'sort_order' => 1,
            ]]);

        $normalizedQuestions = collect($questions)->map(function (array $question, int $index) {
            return [
                'id' => $question['id'] ?? null,
                'question' => $question['question'] ?? '',
                'options' => collect($question['options'] ?? [])->pad(4, '')->take(4)->values()->all(),
                'correct_answer' => $question['correct_answer'] ?? '',
                'explanation' => $question['explanation'] ?? '',
                'sort_order' => $question['sort_order'] ?? ($index + 1),
            ];
        })->values()->all();

        return view('vue-page', [
            'title' => $mode === 'create' ? 'Create Exam Practice Set' : 'Edit Exam Practice Set',
            'pageComponent' => 'admin-exam-practice-form',
            'pageProps' => [
                'mode' => $mode,
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'layout' => AdminLayoutData::make(
                    $mode === 'create' ? 'Create Exam Practice Set' : 'Edit Exam Practice Set',
                    'Build a separate exam practice question set without affecting existing quizzes.',
                    'exam-practice',
                ),
                'existingSets' => ExamPracticeSet::query()
                    ->orderBy('title')
                    ->get(['id', 'slug'])
                    ->map(fn (ExamPracticeSet $item) => [
                        'id' => $item->id,
                        'slug' => $item->slug,
                    ])
                    ->values()
                    ->all(),
                'set' => [
                    'id' => $set->id,
                    'title' => old('title', $set->title ?? ''),
                    'slug' => old('slug', $set->slug ?? ''),
                    'description' => old('description', $set->description ?? ''),
                    'exam_code' => old('exam_code', $set->exam_code ?? ''),
                    'is_published' => old('is_published', $set->is_published ?? true),
                    'questions' => $normalizedQuestions,
                ],
                'routes' => [
                    'action' => $action,
                    'index' => route('admin.exam-practice.index'),
                ],
                'method' => $mode === 'edit' ? 'PUT' : 'POST',
            ],
        ]);
    }

    protected function syncQuestions(ExamPracticeSet $set, array $questions): void
    {
        $keptIds = [];

        foreach ($questions as $index => $questionData) {
            $question = isset($questionData['id'])
                ? $set->questions()->whereKey($questionData['id'])->first()
                : null;

            if (! $question) {
                $question = new ExamPracticeQuestion();
                $question->exam_practice_set_id = $set->id;
            }

            $question->fill([
                'question' => $questionData['question'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'] ?? null,
                'sort_order' => $questionData['sort_order'] ?: ($index + 1),
            ]);
            $question->save();

            $keptIds[] = $question->id;
        }

        $set->questions()->whereNotIn('id', $keptIds)->delete();
    }
}
