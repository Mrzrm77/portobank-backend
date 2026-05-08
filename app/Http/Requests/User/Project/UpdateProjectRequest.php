<?php

namespace App\Http\Requests\User\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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

                'sometimes',

                'max:255'

            ],

            'type' => [

                'sometimes',

                'in:project,artwork,research,etc'

            ],

            'description' => [

                'sometimes',

                'nullable'

            ],

            'cover_image_url' => [

                'sometimes',

                'nullable'

            ],

            'project_link' => [

                'sometimes',

                'nullable',

                'url'

            ],

            'start_date' => [

                'sometimes',

                'nullable',

                'date'

            ],

            'end_date' => [

                'sometimes',

                'nullable',

                'date'

            ]

        ];
    }
}
