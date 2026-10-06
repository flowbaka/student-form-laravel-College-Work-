@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-2 text-xs font-semibold tracking-widest text-blue-600 uppercase dark:text-blue-400">Student directory</p>
            <h1 class="text-3xl font-semibold tracking-tight">Students <span class="ml-2 text-xl font-normal text-slate-400">{{ $students->total() }}</span></h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Manage student profiles and contact information.</p>
        </div>
        <a href="{{ route('students.create') }}" class="button-primary">+ Add student</a>
    </div>
    <div class="panel overflow-hidden">
        @if ($students->isEmpty())
            <div class="px-6 py-16 text-center">
                <h2 class="text-lg font-semibold">No students yet</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Add your first student to get started.</p>
                <a href="{{ route('students.create') }}" class="button-primary mt-6">Add student</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <caption class="sr-only">Student details and actions</caption>
                    <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/50">
                        <tr>
                            <th scope="col" class="table-heading">Student</th>
                            <th scope="col" class="table-heading">Email</th>
                            <th scope="col" class="table-heading">Phone</th>
                            <th scope="col" class="table-heading">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($students as $student)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="table-cell font-medium"><a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $student->name }}</a></td>
                                <td class="table-cell">{{ $student->email }}</td>
                                <td class="table-cell">{{ $student->phone }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center gap-3 whitespace-nowrap">
                                        <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:underline dark:text-blue-400">View</a>
                                        <a href="{{ route('students.edit', $student) }}" class="text-slate-600 hover:underline dark:text-slate-300">Edit</a>
                                        @include('partials.delete-form', ['action' => route('students.destroy', $student), 'confirmation' => 'Delete this student? This cannot be undone.', 'label' => 'Delete student ' . $student->name])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800">{{ $students->links() }}</div>
        @endif
    </div>
@endsection
