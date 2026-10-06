<header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
    <nav aria-label="Main navigation" class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-5 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold">
            <span aria-hidden="true" class="flex size-10 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white">WM</span>
            <span>Workshop Manager</span>
        </a>
        <div class="flex gap-2">
            <a href="{{ route('students.index') }}" @if(request()->routeIs('students.*')) aria-current="page" @endif
                @class(['rounded-lg px-4 py-2 text-sm font-medium transition', 'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300' => request()->routeIs('students.*'), 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' => ! request()->routeIs('students.*')])>Students</a>
            <a href="{{ route('courses.index') }}" @if(request()->routeIs('courses.*')) aria-current="page" @endif
                @class(['rounded-lg px-4 py-2 text-sm font-medium transition', 'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300' => request()->routeIs('courses.*'), 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' => ! request()->routeIs('courses.*')])>Courses</a>
        </div>
    </nav>
</header>
