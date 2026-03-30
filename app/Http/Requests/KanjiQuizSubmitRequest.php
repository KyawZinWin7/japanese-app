<?php

namespace App\Http\Requests;

use App\Models\KanjiQuiz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class KanjiQuizSubmitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'string'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $quiz = $this->route('quiz');

            if (! $quiz instanceof KanjiQuiz) {
                return;
            }

            $questions = $quiz->questions()->get(['id', 'options']);
            $answers = $this->input('answers', []);

            foreach ($questions as $question) {
                if (! array_key_exists($question->id, $answers)) {
                    $validator->errors()->add('answers', 'Please answer every question before submitting.');
                    continue;
                }

                if (! in_array($answers[$question->id], $question->options ?? [], true)) {
                    $validator->errors()->add('answers', 'One or more selected answers are invalid.');
                }
            }
        }];
    }
}
