<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Student> */
class StudentFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('98########'),
            'address' => fake()->address(),
            'date_of_birth' => fake()->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
        ];
    }

    public function withoutOptionalDetails(): static
    {
        return $this->state(fn (array $attributes): array => [
            'address' => null,
            'date_of_birth' => null,
        ]);
    }
}
