@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <h1>Courses</h1>
    <p><a href="{{ route('courses.create') }}">Add course</a></p>

    @if ($courses->isEmpty())
        <p>No courses yet</p>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Fee</th>
                        <th scope="col">Difficulty</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->duration }} {{ $course->duration === 1 ? 'week' : 'weeks' }}</td>
                            <td>{{ $course->formatted_fee }}</td>
                            <td>{{ $course->difficulty }}</td>
                            <td>{{ $course->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course) }}">View</a>
                                <a href="{{ route('courses.edit', $course) }}">Edit</a>
                                @include('partials.delete-form', ['action' => route('courses.destroy', $course), 'confirmation' => 'Delete this course?', 'label' => 'Delete course ' . $course->name])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('partials.pagination', ['records' => $courses])
    @endif
@endsection
