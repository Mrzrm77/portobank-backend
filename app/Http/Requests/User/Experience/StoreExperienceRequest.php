<?php

namespace App\Http\Requests\User\Experience;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location'=> 'required|string|max:255',
            'start_date'=> 'required|date',
            'end_date'=> 'nullable|date',
            'is_current'=>'boolean',
            'description'=> 'required|max:255'
        ];
    }
}
