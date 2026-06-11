<?php

namespace App\Http\Requests\User\Certification;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCertificationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'certificate_file' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:4096',
        ],
            'certificate_url' => 'nullable|string|max:255',
            'Description'=> 'nullable|string'
        ];
    }
}
