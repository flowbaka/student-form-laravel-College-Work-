<?php

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/** @return array<string, mixed> */
function coursePayload(array $overrides = []): array
{
    return array_replace([
        'name' => 'Web Development',
        'description' => 'Learn how to build web applications.',
        'duration' => 8,
        'fee' => '1250.50',
        'difficulty' => 'Easy',
        'is_active' => '1',
    ], $overrides);
}

test('courses list shows an empty state', function () {
    $this->get(route('courses.index'))->assertSee('No courses found.');
});

test('courses list displays all saved courses', function () {
    $courses = Course::factory()->count(11)->sequence(fn ($sequence): array => [
        'name' => 'Course '.$sequence->index,
    ])->create();

    $this->get(route('courses.index'))
        ->assertSee($courses->first()->name)
        ->assertSee($courses->last()->name)
        ->assertViewIs('course.list')
        ->assertViewHas('courses', fn (Collection $records): bool => $records->count() === 11);
});

test('course creation form submits to the store route with csrf protection', function () {
    $this->get(route('courses.create'))
        ->assertSee('action="'.route('courses.store').'"', false)
        ->assertSee('name="_token"', false)
        ->assertSee('Create Course');
});

test('valid courses save with typed duration fee status and timestamps', function (string $difficulty) {
    $response = $this->post(route('courses.store'), coursePayload(['difficulty' => $difficulty, 'id' => 999]));

    $course = Course::query()->sole();
    $response->assertRedirectToRoute('courses.index')->assertSessionHas('success');
    $this->assertDatabaseHas('courses', [
        'name' => 'Web Development', 'description' => 'Learn how to build web applications.',
        'duration' => 8, 'fee' => '1250.50', 'difficulty' => $difficulty, 'is_active' => 1,
    ]);
    expect($course->id)->not->toBe(999);
    expect($course->duration)->toBe(8);
    expect($course->fee)->toBe('1250.50');
    expect($course->is_active)->toBeTrue();
    expect($course->created_at)->not->toBeNull();
    expect($course->updated_at)->not->toBeNull();
})->with(['Easy', 'Medium', 'Hard']);

test('courses can be created inactive when the checkbox is unchecked or absent', function (array $data) {
    $this->post(route('courses.store'), $data)->assertSessionHasNoErrors();

    expect(Course::query()->sole()->is_active)->toBeFalse();
})->with([
    'unchecked checkbox' => [coursePayload(['is_active' => '0'])],
    'absent checkbox' => [array_diff_key(coursePayload(), ['is_active' => true])],
]);

test('missing required course fields show validation messages without saving', function () {
    $this->from(route('courses.create'))->post(route('courses.store'), [])
        ->assertRedirectToRoute('courses.create')
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'duration' => 'The duration in weeks field is required.',
            'fee' => 'The fee field is required.',
            'difficulty' => 'The difficulty field is required.',
        ]);

    $this->assertDatabaseCount('courses', 0);
    $this->withCookie(config('session.cookie'), session()->getId())->get(route('courses.create'))->assertSee('The fee field is required.');
});

test('invalid course fields are rejected without saving', function (string $field, mixed $value, string $message) {
    $this->post(route('courses.store'), coursePayload([$field => $value]))
        ->assertSessionHasErrors([$field => $message]);

    $this->assertDatabaseCount('courses', 0);
})->with([
    'name must be text' => ['name', ['invalid'], 'The name field must be a string.'],
    'name length' => ['name', str_repeat('a', 256), 'The name field must not be greater than 255 characters.'],
    'description must be text' => ['description', ['invalid'], 'The description field must be a string.'],
    'description length' => ['description', str_repeat('a', 10001), 'The description field must not be greater than 10000 characters.'],
    'duration must be whole weeks' => ['duration', 1.5, 'The duration in weeks field must be an integer.'],
    'duration must be positive' => ['duration', 0, 'The duration in weeks field must be at least 1.'],
    'duration must fit the database' => ['duration', 65536, 'The duration in weeks field must not be greater than 65535.'],
    'fee must be numeric' => ['fee', 'invalid', 'The fee field must be a number.'],
    'fee cannot be negative' => ['fee', '-0.01', 'The fee field must be at least 0.'],
    'fee must fit the database' => ['fee', '100000000.00', 'The fee field must not be greater than 99999999.99.'],
    'fee cannot be silently rounded' => ['fee', '10.123', 'The fee field must have 0-2 decimal places.'],
    'difficulty must be allowed' => ['difficulty', 'Expert', 'The selected difficulty is invalid.'],
    'active status must be boolean' => ['is_active', 'invalid', 'The active status field must be true or false.'],
]);

test('course details show every field including formatted fees', function () {
    $course = Course::factory()->inactive()->create(coursePayload(['is_active' => false]));

    $this->get(route('courses.show', $course))
        ->assertSee('Web Development')->assertSee('Learn how to build web applications.')
        ->assertSee('8 weeks')->assertSee('1,250.50')->assertSee('Easy')->assertSee('Inactive');
});

test('course edit form contains saved values and the update method', function () {
    $course = Course::factory()->create(coursePayload());

    $this->get(route('courses.edit', $course))
        ->assertSee('action="'.route('courses.update', $course).'"', false)
        ->assertSee('value="PUT"', false)
        ->assertSee('value="1250.50"', false)
        ->assertSee('Learn how to build web applications.');
});

test('course updates persist all changed fields and deactivate the course', function () {
    $course = Course::factory()->create(coursePayload());

    $this->put(route('courses.update', $course), coursePayload([
        'name' => 'Advanced Laravel', 'description' => 'Build robust Laravel applications.',
        'duration' => 12, 'fee' => '2500.00', 'difficulty' => 'Hard', 'is_active' => '0',
    ]))->assertRedirectToRoute('courses.show', $course)->assertSessionHasNoErrors();

    $this->assertDatabaseHas('courses', [
        'id' => $course->id, 'name' => 'Advanced Laravel', 'description' => 'Build robust Laravel applications.',
        'duration' => 12, 'fee' => '2500.00', 'difficulty' => 'Hard', 'is_active' => 0,
    ]);
});

test('invalid course updates leave the saved record unchanged', function () {
    $course = Course::factory()->create(coursePayload());

    $this->put(route('courses.update', $course), coursePayload(['name' => 'Changed', 'fee' => '-1']))
        ->assertSessionHasErrors(['fee' => 'The fee field must be at least 0.']);

    $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'Web Development', 'fee' => '1250.50']);
});

test('course deletion removes the record and redirects to the list', function () {
    $course = Course::factory()->create();

    $this->delete(route('courses.destroy', $course))
        ->assertRedirectToRoute('courses.index')->assertSessionHas('success');

    $this->assertModelMissing($course);
});

test('missing courses produce 404 responses through model binding', function (string $action, string $method) {
    $this->{$method}(route('courses.'.$action, 999999), coursePayload())->assertNotFound();
})->with([
    'details' => ['show', 'get'],
    'editing' => ['edit', 'get'],
    'updating' => ['update', 'put'],
    'deleting' => ['destroy', 'delete'],
]);

test('course free text is escaped in details and forms', function () {
    $unsafe = '<script>alert("xss")</script>';
    $course = Course::factory()->create(['name' => $unsafe, 'description' => $unsafe]);

    foreach (['show', 'edit', 'index'] as $action) {
        $parameters = $action === 'index' ? [] : [$course];
        $this->get(route('courses.'.$action, $parameters))
            ->assertSee('&lt;script&gt;', false)->assertDontSee($unsafe, false);
    }
});

test('course writes without a csrf token are refused', function () {
    $this->app['env'] = 'local';

    $this->post(route('courses.store'), coursePayload())->assertStatus(419);

    $this->assertDatabaseCount('courses', 0);
});

test('courses can be created without a description', function (array $data) {
    $this->post(route('courses.store'), $data)
        ->assertRedirectToRoute('courses.index')->assertSessionHasNoErrors();

    $this->assertDatabaseHas('courses', ['name' => 'Web Development', 'description' => null]);
})->with([
    'blank description' => [coursePayload(['description' => ''])],
    'null description' => [coursePayload(['description' => null])],
    'missing description' => [array_diff_key(coursePayload(), ['description' => true])],
]);

test('course descriptions can be cleared during an update', function () {
    $course = Course::factory()->create(coursePayload());

    $this->put(route('courses.update', $course), coursePayload(['description' => '']))
        ->assertRedirectToRoute('courses.show', $course)->assertSessionHasNoErrors();

    $this->assertDatabaseHas('courses', ['id' => $course->id, 'description' => null]);
});
