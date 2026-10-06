@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-2 text-xs font-semibold tracking-widest text-blue-600 uppercase dark:text-blue-400">Course catalogue</p>
            <h1 class="text-3xl font-semibold tracking-tight">Courses <span class="ml-2 text-xl font-normal text-slate-400">{{ $courses->total() }}</span></h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Manage course details, fees, and availability.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="button-primary">+ Add course</a>
    </div>
    <div class="panel overflow-hidden">
        @if ($courses->isEmpty())
            <div class="px-6 py-16 text-center">
                <h2 class="text-lg font-semibold">No courses yet</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Add your first course to get started.</p>
                <a href="{{ route('courses.create') }}" class="button-primary mt-6">Add course</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <caption class="sr-only">Course details and actions</caption>
                    <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/50">
                        <tr>
                            <th scope="col" class="table-heading">Course</th>
                            <th scope="col" class="table-heading">Duration</th>
                            <th scope="col" class="table-heading">Fee</th>
                            <th scope="col" class="table-heading">Difficulty</th>
                            <th scope="col" class="table-heading">Status</th>
                            <th scope="col" class="table-heading">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($courses as $course)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="table-cell font-medium"><a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $course->name }}</a></td>
                                <td class="table-cell">{{ $course->duration }} {{ $course->duration === 1 ? 'week' : 'weeks' }}</td>
                                <td class="table-cell">{{ $course->formatted_fee }}</td>
                                <td class="table-cell">{{ $course->difficulty }}</td>
                                <td class="table-cell">{{ $course->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center gap-3 whitespace-nowrap">
                                        <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline dark:text-blue-400">View</a>
                                        <a href="{{ route('courses.edit', $course) }}" class="text-slate-600 hover:underline dark:text-slate-300">Edit</a>
                                        @include('partials.delete-form', ['action' => route('courses.destroy', $course), 'confirmation' => 'Delete this course? This cannot be undone.', 'label' => 'Delete course ' . $course->name])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800">{{ $courses->links() }}</div>
        @endif
    </div>
@endsection
