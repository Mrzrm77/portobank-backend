<?php

namespace App\Http\Requests\User\PortfolioItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadPortfolioItemCoverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cover' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ];
    }
}
