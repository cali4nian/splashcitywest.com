<x-app-layout>
    <x-slot name="header">
        <div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-cyan-700">Administration</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">Dashboard</h2>
                <p class="mt-2 text-sm text-slate-600">Simple admin overview.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200/90 bg-white/95 p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-cyan-700">Welcome back, {{ Auth::user()->name }}.</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900">Admin Dashboard</h3>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                Use the Landing Page Settings and Newsletter Management pages to manage site content.
            </p>
        </div>
    </div>
</x-app-layout>
