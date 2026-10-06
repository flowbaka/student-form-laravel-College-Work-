@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <h1>Students</h1>
    <p><a href="{{ route('students.create') }}">Create Student</a></p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>
                            <a href="{{ route('students.show', $student) }}">View</a>
                            <a href="{{ route('students.edit', $student) }}">Edit</a>
                            @include('partials.delete-form', ['action' => route('students.destroy', $student), 'confirmation' => 'Delete this student?', 'label' => 'Delete student ' . $student->name])
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No students found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
