@extends('layouts.app')

@section('title', 'Edit course')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('courses.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">&larr; Back to courses</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight">Edit course</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Update the course details and availability.</p>
        <div class="panel mt-8 p-6 sm:p-8">
            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">Fields marked <span class="text-red-500">*</span> are required.</p>
            <form method="POST" action="{{ route('courses.update', $course) }}">
                @csrf
                @method('PUT')
                @include('courses._form', ['course' => $course, 'submitLabel' => 'Save changes'])
            </form>
        </div>
    </div>
@endsection
