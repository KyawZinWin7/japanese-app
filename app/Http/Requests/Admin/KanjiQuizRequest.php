<?php

namespace App\Http\Requests\Admin;

use App\Models\Kanji;
use App\Models\KanjiQuiz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class KanjiQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $quizId = $this->route('quiz')?->id;

        return [
            'jlpt_level_id' => ['required', 'exists:jlpt_levels,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kanji_quizzes', 'slug')->ignore($quizId),
            ],
            'description' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.id' => ['nullable', 'integer'],
            'questions.*.kanji_id' => ['required', 'integer', 'exists:kanji,id'],
            'questions.*.prompt' => ['required', 'string', 'max:255'],
            'questions.*.question_type' => ['required', 'string', 'max:50'],
            'questions.*.options' => ['required', 'array', 'min:2', 'max:6'],
            'questions.*.options.*' => ['required', 'string', 'max:255', 'distinct'],
            'questions.*.correct_answer' => ['required', 'string', 'max:255'],
            'questions.*.sort_order' => ['required', 'integer', 'min:1', 'max:9999'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $questions = collect($this->input('questions', []))
            ->map(function ($question, int $index) {
                $options = collect($question['options'] ?? [])
                    ->map(fn ($option) => trim((string) $option))
                    ->filter(fn ($option) => $option !== '')
                    ->values()
                    ->all();

                return [
                    'id' => isset($question['id']) && $question['id'] !== '' ? (int) $question['id'] : null,
                    'kanji_id' => isset($question['kanji_id']) && $question['kanji_id'] !== '' ? (int) $question['kanji_id'] : null,
                    'prompt' => trim((string) ($question['prompt'] ?? '')),
                    'question_type' => trim((string) ($question['question_type'] ?? 'meaning')) ?: 'meaning',
                    'options' => $options,
                    'correct_answer' => trim((string) ($question['correct_answer'] ?? '')),
                    'sort_order' => isset($question['sort_order']) && $question['sort_order'] !== ''
                        ? (int) $question['sort_order']
                        : ($index + 1),
                ];
            })
            ->values()
            ->all();

        $this->merge([
            'slug' => trim((string) $this->input('slug', '')),
            'is_published' => $this->boolean('is_published'),
            'questions' => $questions,
        ]);
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $levelId = (int) $this->input('jlpt_level_id');
                $questionIds = collect($this->input('questions', []))
                    ->pluck('kanji_id')
                    ->filter()
                    ->map(fn ($id) => (int) $id)
                    ->values();

                if ($questionIds->isEmpty()) {
                    return;
                }

                $validKanjiIds = Kanji::query()
                    ->where('jlpt_level_id', $levelId)
                    ->whereIn('id', $questionIds)
                    ->pluck('id')
                    ->all();

                foreach ($questionIds as $index => $kanjiId) {
                    if (! in_array($kanjiId, $validKanjiIds, true)) {
                        $validator->errors()->add("questions.{$index}.kanji_id", 'The selected kanji must belong to the chosen JLPT level.');
                    }
                }

                foreach ($this->input('questions', []) as $index => $question) {
                    if (! in_array($question['correct_answer'] ?? '', $question['options'] ?? [], true)) {
                        $validator->errors()->add("questions.{$index}.correct_answer", 'The correct answer must match one of the listed options.');
                    }
                }

                $quiz = $this->route('quiz');

                if ($quiz instanceof KanjiQuiz) {
                    $existingIds = $quiz->questions()->pluck('id')->all();

                    foreach ($this->input('questions', []) as $index => $question) {
                        $questionId = $question['id'] ?? null;

                        if ($questionId !== null && ! in_array($questionId, $existingIds, true)) {
                            $validator->errors()->add("questions.{$index}.id", 'The selected question is invalid for this quiz.');
                        }
                    }
                }
            },
        ];
    }
}
