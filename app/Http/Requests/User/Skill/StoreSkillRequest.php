<?php

namespace App\Http\Requests\User\Skill;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skill_name' => [
                'required',
                'string',
                'max:255'
            ],
            'category_id' => [
                'nullable',
                'integer',
                'exists:skill_categories,id'
            ]
        ];
    }
}
