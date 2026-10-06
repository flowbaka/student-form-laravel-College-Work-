<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/** @return array<string, mixed> */
function studentPayload(array $overrides = []): array
{
    return array_replace([
        'name' => 'Asha Sharma',
        'email' => 'asha@example.com',
        'phone' => '+977 9800000000',
        'address' => 'Kathmandu',
        'date_of_birth' => '2000-04-12',
    ], $overrides);
}

test('students list shows an empty state', function () {
    $this->get(route('students.index'))->assertSee('No students yet');
});

test('students list paginates newest records first', function () {
    $students = Student::factory()->count(11)->create(['created_at' => '2026-01-01 10:00:00']);

    $this->get(route('students.index'))
        ->assertSee($students->last()->email)
        ->assertDontSee($students->first()->email)
        ->assertViewHas('students', fn ($page): bool => $page->total() === 11 && $page->count() === 10);

    $this->get(route('students.index', ['page' => 2]))->assertSee($students->first()->email);
});

test('student creation form submits to the store route with csrf protection', function () {
    $this->get(route('students.create'))
        ->assertSee('action="'.route('students.store').'"', false)
        ->assertSee('name="_token"', false)
        ->assertSee('Create student');
});

test('valid student data is saved with a date cast and timestamps', function () {
    $response = $this->post(route('students.store'), studentPayload(['email' => 'ASHA@example.com', 'id' => 999]));

    $student = Student::query()->sole();
    $response->assertRedirectToRoute('students.show', $student)->assertSessionHas('success');
    $this->assertDatabaseHas('students', ['name' => 'Asha Sharma', 'email' => 'asha@example.com', 'phone' => '+977 9800000000']);
    expect($student->id)->not->toBe(999);
    expect($student->date_of_birth->format('Y-m-d'))->toBe('2000-04-12');
    expect($student->created_at)->not->toBeNull();
    expect($student->updated_at)->not->toBeNull();
});

test('blank optional student fields are stored as null', function () {
    $response = $this->post(route('students.store'), studentPayload(['address' => '', 'date_of_birth' => '']));

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('students', ['email' => 'asha@example.com', 'address' => null, 'date_of_birth' => null]);
});

test('missing required student fields show validation messages without saving', function () {
    $this->from(route('students.create'))->post(route('students.store'), [])
        ->assertRedirectToRoute('students.create')
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'phone' => 'The phone field is required.',
        ]);

    $this->assertDatabaseCount('students', 0);
    $this->withCookie(config('session.cookie'), session()->getId())->get(route('students.create'))->assertSee('The email field is required.');
});

test('invalid student fields are rejected without saving', function (string $field, mixed $value, string $message) {
    $this->post(route('students.store'), studentPayload([$field => $value]))
        ->assertSessionHasErrors([$field => $message]);

    $this->assertDatabaseCount('students', 0);
})->with([
    'name must be text' => ['name', ['invalid'], 'The name field must be a string.'],
    'name length' => ['name', str_repeat('a', 256), 'The name field must not be greater than 255 characters.'],
    'email format' => ['email', 'invalid', 'The email field must be a valid email address.'],
    'email length' => ['email', str_repeat('a', 245).'@example.com', 'The email field must not be greater than 255 characters.'],
    'phone must be text' => ['phone', ['invalid'], 'The phone field must be a string.'],
    'phone length' => ['phone', str_repeat('1', 31), 'The phone field must not be greater than 30 characters.'],
    'address must be text' => ['address', ['invalid'], 'The address field must be a string.'],
    'address length' => ['address', str_repeat('a', 2001), 'The address field must not be greater than 2000 characters.'],
    'birthday format' => ['date_of_birth', '12/04/2000', 'The date of birth field must match the format Y-m-d.'],
    'birthday must be real' => ['date_of_birth', '2000-02-30', 'The date of birth field must match the format Y-m-d.'],
    'birthday cannot be future' => ['date_of_birth', '9999-01-01', 'The date of birth field must be a date before or equal to today.'],
]);

test('duplicate student emails are rejected regardless of case', function () {
    Student::factory()->create(['email' => 'asha@example.com']);

    $this->post(route('students.store'), studentPayload(['email' => 'ASHA@example.com']))
        ->assertSessionHasErrors(['email' => 'The email has already been taken.']);

    $this->assertDatabaseCount('students', 1);
});

test('student details display every field and the formatted birthday', function () {
    $student = Student::factory()->create(studentPayload());

    $this->get(route('students.show', $student))
        ->assertSee('Asha Sharma')->assertSee('asha@example.com')
        ->assertSee('+977 9800000000')->assertSee('Kathmandu')
        ->assertSee('12 Apr 2000');
});

test('student details display a fallback for optional fields', function () {
    $student = Student::factory()->withoutOptionalDetails()->create();

    $this->get(route('students.show', $student))->assertSee('Not provided');
});

test('student edit form contains saved values and the update method', function () {
    $student = Student::factory()->create(studentPayload());

    $this->get(route('students.edit', $student))
        ->assertSee('action="'.route('students.update', $student).'"', false)
        ->assertSee('value="PUT"', false)
        ->assertSee('value="2000-04-12"', false)
        ->assertSee('asha@example.com');
});

test('student updates permit keeping the same email and clearing optional fields', function () {
    $student = Student::factory()->create(studentPayload());

    $this->put(route('students.update', $student), studentPayload([
        'name' => 'Asha Updated', 'address' => '', 'date_of_birth' => '',
    ]))->assertRedirectToRoute('students.show', $student)->assertSessionHasNoErrors();

    $this->assertDatabaseHas('students', [
        'id' => $student->id, 'name' => 'Asha Updated', 'email' => 'asha@example.com',
        'address' => null, 'date_of_birth' => null,
    ]);
});

test('student updates cannot take another students email using a forged id', function () {
    $student = Student::factory()->create(['email' => 'original@example.com']);
    $otherStudent = Student::factory()->create(['email' => 'other@example.com']);

    $this->put(route('students.update', $student), studentPayload([
        'email' => $otherStudent->email, 'id' => $otherStudent->id,
    ]))->assertSessionHasErrors(['email' => 'The email has already been taken.']);

    $this->assertDatabaseHas('students', ['id' => $student->id, 'email' => 'original@example.com']);
});

test('invalid student updates leave the saved record unchanged', function () {
    $student = Student::factory()->create(studentPayload());

    $this->put(route('students.update', $student), studentPayload(['phone' => '', 'name' => 'Changed']))
        ->assertSessionHasErrors(['phone' => 'The phone field is required.']);

    $this->assertDatabaseHas('students', ['id' => $student->id, 'name' => 'Asha Sharma']);
});

test('student deletion removes the record and redirects to the list', function () {
    $student = Student::factory()->create();

    $this->delete(route('students.destroy', $student))
        ->assertRedirectToRoute('students.index')->assertSessionHas('success');

    $this->assertModelMissing($student);
});

test('missing students produce 404 responses through model binding', function (string $action, string $method) {
    $this->{$method}(route('students.'.$action, 999999), studentPayload())->assertNotFound();
})->with([
    'details' => ['show', 'get'],
    'editing' => ['edit', 'get'],
    'updating' => ['update', 'put'],
    'deleting' => ['destroy', 'delete'],
]);

test('student free text is escaped in details and forms', function () {
    $unsafe = '<script>alert("xss")</script>';
    $student = Student::factory()->create([
        'name' => $unsafe, 'email' => $unsafe, 'phone' => $unsafe, 'address' => $unsafe,
    ]);

    foreach (['show', 'edit', 'index'] as $action) {
        $parameters = $action === 'index' ? [] : [$student];
        $this->get(route('students.'.$action, $parameters))
            ->assertSee('&lt;script&gt;', false)->assertDontSee($unsafe, false);
    }
});

test('student writes without a csrf token are refused', function () {
    $this->app['env'] = 'local';

    $this->post(route('students.store'), studentPayload())->assertStatus(419);

    $this->assertDatabaseCount('students', 0);
});
