@if (session('success'))
    <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
        {{ session('success') }}
    </div>
@endif
