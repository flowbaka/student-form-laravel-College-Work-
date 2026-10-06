@extends('layouts.app')

@section('title', 'Edit course')

@section('content')
    <h1>Edit course</h1>
    <p><a href="{{ route('courses.index') }}">Back to courses</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('courses.update', $course) }}">
        @csrf
        @method('PUT')
        @include('courses._form', ['course' => $course, 'submitLabel' => 'Save changes'])
    </form>
@endsection
