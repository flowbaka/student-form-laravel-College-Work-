<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('course.list', ['courses' => Course::all()]);
    }

    public function create(): View
    {
        return view('course.create', ['course' => new Course]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        return redirect()->route('courses.index')->with('success', "Course {$course->name} created successfully!");
    }

    public function show(Course $course): View
    {
        return view('course.detail', ['course' => $course]);
    }

    public function edit(Course $course): View
    {
        return view('course.edit', ['course' => $course]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
