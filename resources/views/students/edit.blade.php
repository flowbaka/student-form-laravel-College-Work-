@extends('layouts.app')

@section('title', 'Edit student')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('students.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">&larr; Back to students</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight">Edit student</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Keep this student’s contact details up to date.</p>
        <div class="panel mt-8 p-6 sm:p-8">
            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">Fields marked <span class="text-red-500">*</span> are required.</p>
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')
                @include('students._form', ['student' => $student, 'submitLabel' => 'Save changes'])
            </form>
        </div>
    </div>
@endsection
