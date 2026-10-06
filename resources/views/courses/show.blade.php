@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <a href="{{ route('courses.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">&larr; Back to courses</a>
    <div class="mb-8 mt-4 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight break-words">{{ $course->name }}</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Course details</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('courses.edit', $course) }}" class="button-primary">Edit course</a>
            @include('partials.delete-form', ['action' => route('courses.destroy', $course), 'confirmation' => 'Delete this course? This cannot be undone.', 'label' => 'Delete course ' . $course->name])
        </div>
    </div>
    <dl class="panel grid gap-8 p-6 sm:grid-cols-2 sm:p-8">
        <div class="sm:col-span-2"><dt class="detail-label">Description</dt><dd class="detail-value whitespace-pre-line">{{ $course->description }}</dd></div>
        <div><dt class="detail-label">Duration</dt><dd class="detail-value">{{ $course->duration }} {{ $course->duration === 1 ? 'week' : 'weeks' }}</dd></div>
        <div><dt class="detail-label">Fee</dt><dd class="detail-value">{{ $course->formatted_fee }}</dd></div>
        <div><dt class="detail-label">Difficulty</dt><dd class="detail-value">{{ $course->difficulty }}</dd></div>
        <div><dt class="detail-label">Status</dt><dd class="detail-value">{{ $course->is_active ? 'Active' : 'Inactive' }}</dd></div>
        <div><dt class="detail-label">Added</dt><dd class="detail-value">{{ $course->created_at->format('j M Y, H:i') }}</dd></div>
        <div><dt class="detail-label">Last updated</dt><dd class="detail-value">{{ $course->updated_at->format('j M Y, H:i') }}</dd></div>
    </dl>
@endsection
