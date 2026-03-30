<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KanjiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kanjiId = $this->route('kanji')?->id;

        return [
            'jlpt_level_id' => ['required', 'exists:jlpt_levels,id'],
            'character' => ['required', 'string', 'max:10'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('kanji', 'slug')->ignore($kanjiId)],
            'onyomi' => ['nullable', 'string', 'max:255'],
            'kunyomi' => ['nullable', 'string', 'max:255'],
            'meaning' => ['required', 'string', 'max:255'],
            'example_sentence' => ['nullable', 'string', 'max:1000'],
            'example_translation' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
