@extends('layouts.app')

@section('title', 'Add student')

@section('content')
    <h1>Add student</h1>
    <p><a href="{{ route('students.index') }}">Back to students</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        @include('students._form', ['student' => $student, 'submitLabel' => 'Create student'])
    </form>
@endsection
