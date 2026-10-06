<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends StoreStudentRequest
{
    /** @return array<string, array<ValidationRule|string>> */
    public function rules(): array
    {
        return array_replace(parent::rules(), [
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('students', 'email')->ignore($this->route('student')),
            ],
        ]);
    }
}
