<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Charlie Ross') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-100 text-slate-900">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8 sm:px-6 lg:px-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(15,23,42,0.08),transparent_36%),radial-gradient(circle_at_bottom_right,rgba(249,115,22,0.15),transparent_30%),linear-gradient(180deg,#f8fafc_0%,#f1f5f9_100%)]"></div>

            <div class="relative w-full max-w-md">
                <div class="mb-6 text-center">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3">
                        <x-application-logo class="h-16 w-16 rounded-2xl bg-white p-2 shadow-md" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Secure Access</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">{{ config('app.name', 'Charlie Ross') }}</p>
                        </div>
                    </a>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-[0_24px_80px_rgba(15,23,42,0.08)] sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-4 text-center text-xs text-slate-500">
                    Need to return to the public site?
                    <a href="{{ route('home') }}" class="font-semibold text-slate-700 hover:text-slate-900">Go home</a>
                </p>
            </div>
        </div>
    </body>
</html>
