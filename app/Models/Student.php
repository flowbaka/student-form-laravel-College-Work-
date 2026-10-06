<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'address', 'date_of_birth'])]
class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    /** @return Attribute<string, never> */
    protected function formattedDateOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->date_of_birth?->format('j M Y') ?? 'Not provided',
        );
    }
}
