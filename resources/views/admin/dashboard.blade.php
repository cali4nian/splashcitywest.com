<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-cyan-700">Administration</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">Dashboard</h2>
                <p class="mt-2 text-sm text-slate-600">Review key metrics and jump directly to content management tasks.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ route('admin.newsletters') }}"
                    class="inline-flex items-center rounded-xl border border-cyan-700 bg-cyan-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800"
                >
                    Newsletter Management
                </a>
                <a
                    href="{{ route('admin.settings') }}"
                    class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    Open Landing Settings
                </a>
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    View Public Site
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-3xl border border-slate-200/90 bg-white/95 p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-cyan-700">Welcome back, {{ Auth::user()->name }}.</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900">Website Overview</h3>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                This dashboard is focused on at-a-glance stats. Use Landing Settings when you want to edit homepage content.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Programs</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $programs->count() }}</p>
                <p class="mt-2 text-sm text-slate-600">Public program cards currently published.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Events</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $events->count() }}</p>
                <p class="mt-2 text-sm text-slate-600">Current events configured for the site.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Success Stories</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $successStories->count() }}</p>
                <p class="mt-2 text-sm text-slate-600">Stories available in the homepage carousel.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Staff Members</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $staffMembers->count() }}</p>
                <p class="mt-2 text-sm text-slate-600">Staff cards shown on the public site.</p>
            </section>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h4 class="text-lg font-bold text-slate-900">Homepage Snapshot</h4>
                <dl class="mt-4 space-y-3 text-sm text-slate-700">
                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="font-medium text-slate-600">Contact Phone</dt>
                        <dd class="font-semibold text-slate-900">{{ $settings['contact_phone'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="font-medium text-slate-600">Contact Email</dt>
                        <dd class="font-semibold text-slate-900">{{ $settings['contact_email'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="font-medium text-slate-600">College Commitments</dt>
                        <dd class="font-semibold text-slate-900">{{ $settings['college_commitments'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <dt class="font-medium text-slate-600">Programs Represented</dt>
                        <dd class="font-semibold text-slate-900">{{ $settings['programs_represented'] }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h4 class="text-lg font-bold text-slate-900">Quick Links</h4>
                <ul class="mt-4 space-y-3 text-sm text-slate-700">
                    <li>
                        <a href="{{ route('admin.settings') }}" class="inline-flex items-center rounded-lg px-2 py-1 font-semibold text-slate-800 transition hover:bg-slate-100 hover:text-slate-900">
                            Manage Landing Page Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.newsletters') }}" class="inline-flex items-center rounded-lg px-2 py-1 font-semibold text-slate-800 transition hover:bg-slate-100 hover:text-slate-900">
                            Manage Newsletter Contacts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-lg px-2 py-1 font-semibold text-slate-800 transition hover:bg-slate-100 hover:text-slate-900">
                            Edit Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-lg px-2 py-1 font-semibold text-slate-800 transition hover:bg-slate-100 hover:text-slate-900">
                            Open Public Homepage
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</x-app-layout>
