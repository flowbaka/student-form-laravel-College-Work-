<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'duration', 'fee', 'difficulty', 'is_active'])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    public const DIFFICULTIES = ['Easy', 'Medium', 'Hard'];

    /** @var array<string, mixed> */
    protected $attributes = ['is_active' => true];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'fee' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /** @return Attribute<string, never> */
    protected function formattedFee(): Attribute
    {
        return Attribute::make(
            get: fn (): string => number_format((float) $this->fee, 2),
        );
    }
}
