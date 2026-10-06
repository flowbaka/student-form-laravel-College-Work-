@extends('layouts.app')

@section('title', 'Edit student')

@section('content')
    <h1>Edit student</h1>
    <p><a href="{{ route('students.index') }}">Back to students</a></p>
    <p>Fields marked * are required.</p>

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('students._form', ['student' => $student, 'submitLabel' => 'Save changes'])
    </form>
@endsection
