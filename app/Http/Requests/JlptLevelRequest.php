<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JlptLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $levelId = $this->route('level')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('jlpt_levels', 'name')->ignore($levelId),
            ],
            'slug' => [
                'required',
                'string',
                'max:20',
                Rule::unique('jlpt_levels', 'slug')->ignore($levelId),
            ],
            'sort_order' => ['required', 'integer', 'min:1', 'max:99'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
