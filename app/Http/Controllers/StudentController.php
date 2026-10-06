<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('students.index', [
            'students' => Student::query()->orderByDesc('created_at')->orderByDesc('id')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('students.create', ['student' => new Student]);
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());

        return redirect()->route('students.show', $student)->with('success', 'Student created successfully.');
    }

    public function show(Student $student): View
    {
        return view('students.show', ['student' => $student]);
    }

    public function edit(Student $student): View
    {
        return view('students.edit', ['student' => $student]);
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
