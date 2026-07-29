<?php

namespace App\Http\Requests;

use App\Models\ExamPracticeSet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ExamPracticeSubmitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $set = $this->route('set');

            if (! $set instanceof ExamPracticeSet) {
                return;
            }

            $questions = $set->questions()->get();
            $answers = $this->input('answers', []);

            foreach ($questions as $question) {
                if (! array_key_exists($question->id, $answers)) {
                    $validator->errors()->add('answers', 'Please answer every question before submitting.');
                    continue;
                }

                $selected = $this->normalizeSelectedAnswers($answers[$question->id] ?? null);

                if (count($selected) !== $question->requiredAnswerCount()) {
                    $validator->errors()->add('answers', 'Please choose the required number of answers for each question before submitting.');
                    continue;
                }

                foreach ($selected as $answer) {
                    if (! in_array($answer, $question->options ?? [], true)) {
                        $validator->errors()->add('answers', 'One or more selected answers are invalid.');
                        break;
                    }
                }
            }
        }];
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
}
