<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Workshop Manager') · Workshop Manager</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-4 focus:text-slate-900">Skip to content</a>
        @include('partials.navigation')
        <main id="main-content" class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            @include('partials.flash')
            @yield('content')
        </main>
        <footer class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-500 sm:px-6 lg:px-8 dark:text-slate-400">
            Workshop Manager · Students &amp; courses
        </footer>
    </body>
</html>
