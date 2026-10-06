@extends('layouts.app')

@section('title', $student->name)

@section('content')
    <h1>{{ $student->name }}</h1>
    <p><a href="{{ route('students.index') }}">Back to students</a></p>

    <dl>
        <dt>Email</dt>
        <dd>{{ $student->email }}</dd>
        <dt>Phone</dt>
        <dd>{{ $student->phone }}</dd>
        <dt>Address</dt>
        <dd>{{ $student->address ?? 'Not provided' }}</dd>
        <dt>Date of birth</dt>
        <dd>{{ $student->formatted_date_of_birth }}</dd>
        <dt>Created at</dt>
        <dd>{{ $student->created_at->format('j M Y, H:i') }}</dd>
        <dt>Updated at</dt>
        <dd>{{ $student->updated_at->format('j M Y, H:i') }}</dd>
    </dl>

    <a href="{{ route('students.edit', $student) }}">Edit student</a>
    @include('partials.delete-form', ['action' => route('students.destroy', $student), 'confirmation' => 'Delete this student?', 'label' => 'Delete student ' . $student->name])
@endsection
