<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::firstOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Example Student', 'phone' => '9800000000', 'address' => null, 'date_of_birth' => null],
        );
    }
}
