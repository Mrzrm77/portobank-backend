<?php

namespace App\Http\Requests\User\PortfolioItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'string', 'max:100'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'cover_url' => ['sometimes', 'nullable', 'string'],
            'external_link' => ['sometimes', 'nullable', 'url'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'gallery_images' => ['sometimes', 'nullable', 'array'],
            'gallery_images.*' => ['url'],
        ];
    }
}
