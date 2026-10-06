@extends('layouts.app')

@section('title', 'Create Student')

@section('content')
    <h1>Create Student</h1>
    <p><a href="{{ route('students.index') }}">Back to students</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        @include('student._form', ['student' => $student, 'submitLabel' => 'Create Student'])
    </form>
@endsection
