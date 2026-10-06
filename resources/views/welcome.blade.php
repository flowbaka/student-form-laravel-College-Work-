@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="py-8 sm:py-16">
        <p class="text-xs font-semibold tracking-widest text-blue-600 uppercase dark:text-blue-400">Workshop Manager</p>
        <h1 class="mt-4 max-w-2xl text-4xl leading-tight font-semibold tracking-tight sm:text-5xl">Your workshop, organized.</h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-500 dark:text-slate-400">Keep student information and course details together in one simple workspace.</p>
        <div class="mt-10 grid gap-6 sm:grid-cols-2">
            <a href="{{ route('students.index') }}" class="panel p-8 transition hover:border-blue-400">
                <span class="text-xs font-semibold tracking-widest text-blue-600 uppercase dark:text-blue-400">Directory</span>
                <h2 class="mt-3 text-2xl font-semibold">Students</h2>
                <p class="mt-3 text-slate-500 dark:text-slate-400">Create profiles, view contact details, and keep student records up to date.</p>
                <span class="mt-6 inline-block font-medium text-blue-600 dark:text-blue-400">Manage students &rarr;</span>
            </a>
            <a href="{{ route('courses.index') }}" class="panel p-8 transition hover:border-blue-400">
                <span class="text-xs font-semibold tracking-widest text-blue-600 uppercase dark:text-blue-400">Catalogue</span>
                <h2 class="mt-3 text-2xl font-semibold">Courses</h2>
                <p class="mt-3 text-slate-500 dark:text-slate-400">Manage course descriptions, duration, fees, difficulty, and availability.</p>
                <span class="mt-6 inline-block font-medium text-blue-600 dark:text-blue-400">Manage courses &rarr;</span>
            </a>
        </div>
    </div>
@endsection
