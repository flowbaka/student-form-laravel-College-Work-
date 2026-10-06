@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
    <h1>Create Course</h1>
    <p><a href="{{ route('courses.index') }}">Back to courses</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        @include('course._form', ['course' => $course, 'submitLabel' => 'Create Course'])
    </form>
@endsection
