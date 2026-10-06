<?php

use App\Models\Student;
use Carbon\Carbon;

test('student age changes on the birthday', function (string $today, int $expectedAge) {
    $this->travelTo(Carbon::parse($today));
    $student = Student::factory()->make(['date_of_birth' => '2000-04-12']);

    expect($student->age)->toBe($expectedAge);
})->with([
    'before birthday' => ['2026-04-11', 25],
    'on birthday' => ['2026-04-12', 26],
    'after birthday' => ['2026-04-13', 26],
]);

test('student age is null when the birthday is missing', function () {
    $student = Student::factory()->withoutOptionalDetails()->make();

    expect($student->age)->toBeNull();
});
