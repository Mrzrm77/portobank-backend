<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'username'=>['sometimes', 'unique:profiles,username,' . auth()->user()->profile->id],
            'full_name'=>['sometimes', 'max:255'],
            'bio'=>['nullable','max:1000'],
            'avatar_url'=>'nullable',
            'location'=>['nullable','max:255'],
            'profession'=>['nullable','max:255'],
            'is_active'=>'boolean',
            'is_public'=>'boolean'
        ];
    }
}
