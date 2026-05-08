<?php

namespace App\Http\Requests\User\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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

            'title' => [

                'required',

                'max:255'

            ],

            'type' => [

                'required',

                'in:project,artwork,research,etc'

            ],

            'description' => [

                'nullable'

            ],

            'cover_image_url' => [

                'nullable'

            ],

            'project_link' => [

                'nullable',

                'url'

            ],

            'start_date' => [

                'nullable',

                'date'

            ],

            'end_date' => [

                'nullable',

                'date'

            ]
        ];
    }
}
