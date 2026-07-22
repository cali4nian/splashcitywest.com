<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Charlie Ross') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-100 text-slate-900">
        <main class="relative flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(15,23,42,0.08),transparent_36%),radial-gradient(circle_at_bottom_right,rgba(249,115,22,0.15),transparent_30%),linear-gradient(180deg,#f8fafc_0%,#f1f5f9_100%)]"></div>

            <section class="relative w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="{{ config('app.name', 'Charlie Ross') }} logo"
                    class="mx-auto h-16 w-16 rounded-2xl bg-white p-2 shadow-sm ring-1 ring-slate-200"
                >
                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Welcome</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">{{ config('app.name', 'Charlie Ross') }}</h1>
                <p class="mt-3 text-sm text-slate-600">This page is now fully branded with your project identity.</p>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Public Site</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Login</a>
                        @endauth
                    @endif
                </div>
            </section>
        </main>
    </body>
</html>
