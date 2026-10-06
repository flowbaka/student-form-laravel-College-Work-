@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <h1>Edit Student</h1>
    <p><a href="{{ route('students.index') }}">Back to students</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('student._form', ['student' => $student, 'submitLabel' => 'Update Student'])
    </form>
@endsection
