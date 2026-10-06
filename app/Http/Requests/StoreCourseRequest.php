<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->input('is_active', false)]);
    }

    /** @return array<string, array<ValidationRule|string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'difficulty' => ['required', Rule::in(Course::DIFFICULTIES)],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return ['duration' => 'duration in weeks', 'is_active' => 'active status'];
    }
}
