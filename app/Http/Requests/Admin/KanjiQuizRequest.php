<?php

namespace App\Http\Requests\Admin;

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
            'questions.*.quiz_type' => ['required', 'string', 'in:kanji,grammar,vocab'],
            'questions.*.question' => ['required', 'string', 'max:255'],
            'questions.*.highlight_text' => ['nullable', 'string', 'max:255'],
            'questions.*.options' => ['required', 'array', 'min:2', 'max:6'],
            'questions.*.options.*' => ['required', 'string', 'max:255', 'distinct'],
            'questions.*.correct_answer' => ['required', 'string', 'max:255'],
            'questions.*.explanation' => ['nullable', 'string'],
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
                    'quiz_type' => trim((string) ($question['quiz_type'] ?? '')),
                    'question' => trim((string) ($question['question'] ?? '')),
                    'highlight_text' => trim((string) ($question['highlight_text'] ?? '')) ?: null,
                    'options' => $options,
                    'correct_answer' => trim((string) ($question['correct_answer'] ?? '')),
                    'explanation' => trim((string) ($question['explanation'] ?? '')) ?: null,
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
                foreach ($this->input('questions', []) as $index => $question) {
                    $highlightText = $question['highlight_text'] ?? null;

                    if ($highlightText && ! str_contains($question['question'] ?? '', $highlightText)) {
                        $validator->errors()->add("questions.{$index}.highlight_text", 'The highlight text must appear in the question.');
                    }

                    if (! in_array($question['correct_answer'] ?? '', $question['options'] ?? [], true)) {
                        $validator->errors()->add("questions.{$index}.correct_answer", 'The correct answer must match one of the listed options.');
                    }
                }

                $quiz = $this->route('quiz');

                if (! $quiz instanceof KanjiQuiz) {
                    return;
                }

                $existingIds = $quiz->questions()->pluck('id')->all();

                foreach ($this->input('questions', []) as $index => $question) {
                    $questionId = $question['id'] ?? null;

                    if ($questionId !== null && ! in_array($questionId, $existingIds, true)) {
                        $validator->errors()->add("questions.{$index}.id", 'The selected question is invalid for this quiz.');
                    }
                }
            },
        ];
    }
}
