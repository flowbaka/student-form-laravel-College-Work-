<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'email', 'phone', 'address', 'date_of_birth'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    /** @return Attribute<int|null, never> */
    protected function age(): Attribute
    {
        return Attribute::get(fn (): ?int => $this->date_of_birth?->age);
    }

    /** @return Attribute<string, never> */
    protected function formattedDateOfBirth(): Attribute
    {
        return Attribute::get(fn (): string => $this->date_of_birth?->format('d M Y') ?? 'Not provided');
    }
}
