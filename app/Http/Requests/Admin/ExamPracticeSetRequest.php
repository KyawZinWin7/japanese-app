<?php

namespace App\Http\Requests\Admin;

use App\Models\ExamPracticeSet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ExamPracticeSetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $setId = $this->route('set')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('exam_practice_sets', 'slug')->ignore($setId),
            ],
            'description' => ['nullable', 'string'],
            'exam_code' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.id' => ['nullable', 'integer'],
            'questions.*.question' => ['required', 'string'],
            'questions.*.options' => ['required', 'array', 'size:4'],
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
                    ->values()
                    ->all();

                return [
                    'id' => isset($question['id']) && $question['id'] !== '' ? (int) $question['id'] : null,
                    'question' => trim((string) ($question['question'] ?? '')),
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
            'exam_code' => trim((string) $this->input('exam_code', '')) ?: null,
            'is_published' => $this->boolean('is_published'),
            'questions' => $questions,
        ]);
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                foreach ($this->input('questions', []) as $index => $question) {
                    if (! in_array($question['correct_answer'] ?? '', $question['options'] ?? [], true)) {
                        $validator->errors()->add("questions.{$index}.correct_answer", 'The correct answer must match one of the listed options.');
                    }
                }

                $set = $this->route('set');

                if (! $set instanceof ExamPracticeSet) {
                    return;
                }

                $existingIds = $set->questions()->pluck('id')->all();

                foreach ($this->input('questions', []) as $index => $question) {
                    $questionId = $question['id'] ?? null;

                    if ($questionId !== null && ! in_array($questionId, $existingIds, true)) {
                        $validator->errors()->add("questions.{$index}.id", 'The selected question is invalid for this exam practice set.');
                    }
                }
            },
        ];
    }
}
