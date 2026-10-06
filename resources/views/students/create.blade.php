@extends('layouts.app')

@section('title', 'Add student')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('students.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">&larr; Back to students</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight">Add student</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Add a student’s contact details. Address and date of birth are optional.</p>
        <div class="panel mt-8 p-6 sm:p-8">
            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">Fields marked <span class="text-red-500">*</span> are required.</p>
            <form method="POST" action="{{ route('students.store') }}">
                @csrf
                @include('students._form', ['student' => $student, 'submitLabel' => 'Create student'])
            </form>
        </div>
    </div>
@endsection
