@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <h1>{{ $course->name }}</h1>
    <p><a href="{{ route('courses.index') }}">Back to courses</a></p>

    <dl>
        <dt>Description</dt>
        <dd>{{ $course->description }}</dd>
        <dt>Duration</dt>
        <dd>{{ $course->duration }} {{ $course->duration === 1 ? 'week' : 'weeks' }}</dd>
        <dt>Fee</dt>
        <dd>{{ $course->formatted_fee }}</dd>
        <dt>Difficulty</dt>
        <dd>{{ $course->difficulty }}</dd>
        <dt>Status</dt>
        <dd>{{ $course->is_active ? 'Active' : 'Inactive' }}</dd>
        <dt>Created at</dt>
        <dd>{{ $course->created_at->format('j M Y, H:i') }}</dd>
        <dt>Updated at</dt>
        <dd>{{ $course->updated_at->format('j M Y, H:i') }}</dd>
    </dl>

    <a href="{{ route('courses.edit', $course) }}">Edit course</a>
    @include('partials.delete-form', ['action' => route('courses.destroy', $course), 'confirmation' => 'Delete this course?', 'label' => 'Delete course ' . $course->name])
@endsection
