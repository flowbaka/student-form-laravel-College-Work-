@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Student and Course Management</h1>
    <p>Use the links below to manage students and courses.</p>

    <ul>
        <li><a href="{{ route('students.index') }}">Manage students</a></li>
        <li><a href="{{ route('courses.index') }}">Manage courses</a></li>
    </ul>
@endsection
