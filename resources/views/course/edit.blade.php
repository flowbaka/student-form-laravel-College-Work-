@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <h1>Edit Course</h1>
    <p><a href="{{ route('courses.index') }}">Back to courses</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('courses.update', $course) }}">
        @csrf
        @method('PUT')
        @include('course._form', ['course' => $course, 'submitLabel' => 'Update Course'])
    </form>
@endsection
