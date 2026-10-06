<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::firstOrCreate(
            ['name' => 'Introduction to Web Development'],
            [
                'description' => 'Learn the foundations of building web applications.',
                'duration' => 6,
                'fee' => '1500.00',
                'difficulty' => 'Easy',
                'is_active' => true,
            ],
        );
    }
}
