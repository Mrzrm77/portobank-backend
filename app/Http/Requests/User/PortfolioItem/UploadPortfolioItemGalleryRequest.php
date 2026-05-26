<?php

namespace App\Http\Requests\User\PortfolioItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadPortfolioItemGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gallery_images' => [
                'required',
                'array',
                'min:1'
            ],
            'gallery_images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ];
    }
}
