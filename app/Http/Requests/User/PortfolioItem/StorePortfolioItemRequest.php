<?php

namespace App\Http\Requests\User\PortfolioItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'year' => ['nullable', 'integer'],
            'cover_url' => ['nullable', 'string'],
            'external_link' => ['nullable', 'url'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['url'],
            'cover_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048']
        ];
    }
}
