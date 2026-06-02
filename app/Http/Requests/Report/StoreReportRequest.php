<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('report') && $this->filled('reason')) {
            $this->merge(['report' => $this->input('reason')]);
        }
    }

    public function rules(): array
    {
        return [
            'target_user_id' => ['required', 'exists:users,id'],
            'report' => ['required', 'string', 'max:2000'],
        ];
    }
}
