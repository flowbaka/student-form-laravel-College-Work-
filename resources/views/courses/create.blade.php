@extends('layouts.app')

@section('title', 'Add course')

@section('content')
    <h1>Add course</h1>
    <p><a href="{{ route('courses.index') }}">Back to courses</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        @include('courses._form', ['course' => $course, 'submitLabel' => 'Create course'])
    </form>
@endsection
