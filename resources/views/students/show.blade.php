@extends('layouts.app')

@section('title', $student->name)

@section('content')
    <a href="{{ route('students.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">&larr; Back to students</a>
    <div class="mb-8 mt-4 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight break-words">{{ $student->name }}</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Student profile</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('students.edit', $student) }}" class="button-primary">Edit student</a>
            @include('partials.delete-form', ['action' => route('students.destroy', $student), 'confirmation' => 'Delete this student? This cannot be undone.', 'label' => 'Delete student ' . $student->name])
        </div>
    </div>
    <dl class="panel grid gap-8 p-6 sm:grid-cols-2 sm:p-8">
        <div><dt class="detail-label">Email</dt><dd class="detail-value">{{ $student->email }}</dd></div>
        <div><dt class="detail-label">Phone</dt><dd class="detail-value">{{ $student->phone }}</dd></div>
        <div><dt class="detail-label">Date of birth</dt><dd class="detail-value">{{ $student->formatted_date_of_birth }}</dd></div>
        <div class="sm:col-span-2"><dt class="detail-label">Address</dt><dd class="detail-value whitespace-pre-line">{{ $student->address ?? 'Not provided' }}</dd></div>
        <div><dt class="detail-label">Added</dt><dd class="detail-value">{{ $student->created_at->format('j M Y, H:i') }}</dd></div>
        <div><dt class="detail-label">Last updated</dt><dd class="detail-value">{{ $student->updated_at->format('j M Y, H:i') }}</dd></div>
    </dl>
@endsection
