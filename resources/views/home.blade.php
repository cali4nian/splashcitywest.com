<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Splash City West | Fresno AAU Basketball | Coach Charlie Ross</title>

        <meta
            name="description"
            content="Splash City West is a premier AAU basketball program in Fresno, California, led by Head Coach Charlie Ross. Developing student-athletes through elite training, competitive tournaments, and a commitment to excellence."
        >

        <meta
            name="keywords"
            content="Splash City West, Fresno AAU basketball, AAU basketball Fresno, Charlie Ross, Coach Charlie Ross, youth basketball Fresno, California AAU basketball, basketball training Fresno, travel basketball Fresno, Roosevelt High School basketball"
        >

        <meta name="author" content="Splash City West">
        <meta name="robots" content="index, follow">
        <meta name="theme-color" content="#0057B8">

        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="Splash City West | Fresno AAU Basketball">
        <meta
            property="og:description"
            content="Elite AAU basketball program in Fresno, CA, led by Head Coach Charlie Ross. Building champions on and off the court."
        >
        <meta property="og:site_name" content="Splash City West">
        <meta property="og:locale" content="en_US">
        <meta property="og:url" content="https://www.splashcitywest.com">
        <meta property="og:image" content="https://www.splashcitywest.com/images/social-preview.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Splash City West | Fresno AAU Basketball">
        <meta
            name="twitter:description"
            content="Premier AAU basketball program in Fresno, California, led by Head Coach Charlie Ross."
        >
        <meta name="twitter:image" content="https://www.splashcitywest.com/images/social-preview.jpg">

        <!-- Canonical -->
        <link rel="canonical" href="https://www.splashcitywest.com">

        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

        <title>{{ config('app.name', 'Charlie Ross') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f4efe6] text-[#0d2a4a] antialiased">
        @php
            $contactInfo = [
                [
                    'label' => 'Phone',
                    'value' => $contactPhone,
                    'href' => $phoneHref,
                ],
                [
                    'label' => 'Email',
                    'value' => $contactEmail,
                    'href' => $emailHref,
                ],
            ];
        @endphp

        <div class="relative">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(249,115,22,0.22),transparent_34%),radial-gradient(circle_at_top_right,rgba(31,111,235,0.18),transparent_28%),linear-gradient(180deg,#f7f1e7_0%,#efe6d8_54%,#f4efe6_100%)]"></div>
            <div class="absolute left-1/2 -top-40 h-96 w-96 -translate-x-1/2 rounded-full bg-[#0d2a4a]/10 blur-3xl"></div>

            <main class="relative flex flex-col w-full min-h-screen px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <header class="flex items-center justify-between rounded-4xl border border-white/50 bg-white/70 px-5 py-4 shadow-[0_24px_80px_rgba(18,24,38,0.08)] backdrop-blur md:px-7">
                    <div class="flex items-center gap-3">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="{{ config('app.name', 'Charlie Ross') }} logo"
                            class="object-contain w-10 h-10 shrink-0 rounded-xl sm:h-11 sm:w-11"
                        >

                        <div>
                        <p class="hidden text-xs font-semibold uppercase tracking-[0.35em] text-[#f26a0a] sm:block">Head coach</p>
                        <h1 class="text-base font-semibold text-[#0d2a4a] sm:mt-1 sm:text-xl">{{ config('app.name', 'Charlie Ross') }}</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="hidden rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#0d2a4a]/40 hover:text-[#1f2a44] md:inline-flex">
                                    Admin Panel
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hidden rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#0d2a4a]/40 hover:text-[#1f2a44] md:inline-flex">
                                    Login
                                </a>
                            @endauth
                        @endif

                        <a href="#donate" class="rounded-full bg-[#0d2a4a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1f2a44]">
                            <span class="hidden sm:inline">Donate now</span>
                            <span class="sm:hidden">Donate</span>
                        </a>
                    </div>
                </header>

                <nav x-data="{ open: false }" class="sticky top-0 z-40 mt-4 rounded-3xl border border-white/70 bg-white/85 px-3 py-3 shadow-[0_20px_50px_rgba(18,24,38,0.08)] backdrop-blur">
                    <!-- Mobile/tablet: hamburger row -->
                    <div class="flex items-center justify-between lg:hidden">
                        {{-- <span class="px-1 text-sm font-semibold text-[#0d2a4a]">Charlie Ross</span> --}}
                        <button
                            @click="open = !open"
                            :aria-expanded="open"
                            aria-label="Toggle navigation menu"
                            class="rounded-full border border-[#0d2a4a]/20 p-2 text-[#0d2a4a] transition hover:bg-white"
                        >
                            <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Mobile: dropdown grid -->
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="grid grid-cols-2 gap-1 mt-2 lg:hidden"
                        @click="open = false"
                    >
                        <a href="#hero" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Overview</a>
                        <a href="#gallery" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Gallery</a>
                        <a href="#contact" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Contact</a>
                        <a href="#programs" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Programs</a>
                        <a href="#events" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Events</a>
                        <a href="#success-stories" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Stories</a>
                        <a href="#donate" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Donate</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Admin</a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex rounded-full border border-transparent px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Login</a>
                            @endauth
                        @endif
                    </div>

                    <!-- Desktop: horizontal scroll nav -->
                    <div class="hidden overflow-x-auto lg:block">
                        <ul class="flex min-w-max items-center gap-2 text-sm font-semibold text-[#0d2a4a]">
                        <li><a href="#hero" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Overview</a></li>
                        <li><a href="#gallery" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Gallery</a></li>
                        <li><a href="#contact" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Contact</a></li>
                        <li><a href="#programs" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Programs</a></li>
                        <li><a href="#events" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Events</a></li>
                        <li><a href="#success-stories" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Success Stories</a></li>
                        <li><a href="#donate" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Donate</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ route('admin.dashboard') }}" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Admin</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="inline-flex rounded-full border border-transparent px-4 py-2 transition hover:border-[#f26a0a]/30 hover:bg-white hover:text-[#f26a0a]">Login</a></li>
                            @endauth
                        @endif
                        </ul>
                    </div>
                </nav>

                <section id="hero" class="grid flex-1 items-center gap-8 py-8 lg:grid-cols-[1.2fr_0.8fr] lg:py-14">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#0d2a4a]/10 bg-white/75 px-4 py-2 text-sm font-medium text-[#334155] shadow-sm backdrop-blur">
                            <span class="h-2 w-2 rounded-full bg-[#f26a0a]"></span>
                            Live updates for players, families, and community supporters
                        </div>

                        <div class="max-w-3xl space-y-6">
                            <p class="text-sm font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Splash City West AAU + Roosevelt High School</p>
                            <h2 class="text-4xl font-black tracking-tight text-[#0b2340] sm:text-5xl lg:text-7xl">
                                One coach.
                                <span class="block text-[#f26a0a]">{{ $programsRepresented }} programs.</span>
                                One clear standard.
                            </h2>
                            <p class="max-w-2xl text-base leading-7 text-[#334155] sm:text-lg">
                                Coach Charles Ross leads with an academics-first mindset, high standards, and daily accountability. This site keeps families and athletes informed while reinforcing life skills that transfer to adulthood through basketball, discipline, and consistent growth.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="#programs" class="rounded-full border border-[#0d2a4a]/10 bg-white px-5 py-3 text-sm font-semibold text-[#0d2a4a] shadow-sm transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]">
                                Explore programs
                            </a>
                            <a href="#donate" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#0d2a4a] shadow-lg shadow-[#f26a0a]/25 transition hover:brightness-105">
                                Support the team
                            </a>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-[0_16px_50px_rgba(18,24,38,0.08)] backdrop-blur">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#64748b]">Focus</p>
                                <p class="mt-3 text-2xl font-black text-[#0d2a4a]">Development</p>
                                <p class="mt-2 text-sm leading-6 text-[#475569]">Skills, discipline, and game-ready confidence.</p>
                            </div>
                            <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-[0_16px_50px_rgba(18,24,38,0.08)] backdrop-blur">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#64748b]">Community</p>
                                <p class="mt-3 text-2xl font-black text-[#0d2a4a]">Support</p>
                                <p class="mt-2 text-sm leading-6 text-[#475569]">Families can contribute through trusted payment options.</p>
                            </div>
                            <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-[0_16px_50px_rgba(18,24,38,0.08)] backdrop-blur">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#64748b]">Identity</p>
                                <p class="mt-3 text-2xl font-black text-[#0d2a4a]">Basketball</p>
                                <p class="mt-2 text-sm leading-6 text-[#475569]">A bold, court-inspired site built to feel energetic and direct.</p>
                            </div>
                        </div>
                    </div>

                    <aside class="relative">
                        <div class="absolute inset-x-6 top-6 h-full rounded-[2.5rem] bg-[#0d2a4a]/10 blur-2xl"></div>
                        <div class="relative overflow-hidden rounded-4xl border border-white/70 bg-[#0d2a4a] p-6 text-white shadow-[0_28px_90px_rgba(18,24,38,0.3)] sm:p-8">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.35),transparent_32%),radial-gradient(circle_at_bottom_left,rgba(31,111,235,0.22),transparent_28%)]"></div>
                            <div class="relative space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-white/70">Program overview</p>
                                        <h3 class="mt-2 text-2xl font-black">Built for families, players, and supporters</h3>
                                    </div>
                                    <div class="px-4 py-3 text-right border rounded-2xl border-white/10 bg-white/10">
                                        <p class="text-xs uppercase tracking-[0.28em] text-white/60">Live</p>
                                        <p class="mt-1 text-sm font-semibold">Donation links ready</p>
                                    </div>
                                </div>

                                <div class="grid gap-4">
                                    @foreach ($featuredPrograms as $featuredProgram)
                                        <article class="p-5 border rounded-3xl border-white/10 bg-white/8">
                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#f4b400]">{{ $featuredProgram['name'] }}</p>
                                            <p class="mt-3 text-lg font-semibold">{{ $featuredProgram['subtitle'] ?: 'Player development and team culture.' }}</p>
                                            <p class="mt-3 text-sm leading-6 text-white/75">{{ $featuredProgram['description'] }}</p>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                </section>

                <section id="gallery" class="pb-6 space-y-5">
                    <div class="flex items-end justify-between gap-4 pb-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Images</p>
                            <h3 class="mt-2 text-2xl font-black text-[#0b2340] sm:text-3xl">Coach and program gallery</h3>
                        </div>
                        <p class="hidden max-w-xl text-sm leading-6 text-[#475569] md:block">
                            A quick visual look at the coach and both programs.
                        </p>
                    </div>

                    <article class="overflow-hidden rounded-4xl border border-white/70 bg-white/85 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur lg:flex lg:min-h-88">
                        <div class="bg-[#e2e8f0] lg:w-[38%] lg:shrink-0">
                            <img
                                src="{{ $headCoach['image'] }}"
                                alt="{{ $headCoach['title'] }} profile"
                                class="object-cover w-full h-full"
                            >
                        </div>
                        <div class="flex flex-col justify-center flex-1 p-6 sm:p-8 lg:p-10">
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[#f26a0a]">{{ $headCoach['title'] }}</p>
                            <h4 class="mt-3 text-3xl font-black text-[#0b2340] sm:text-4xl">Head Coach Charles Ross</h4>
                            <p class="mt-4 max-w-3xl text-base leading-7 text-[#475569] sm:text-lg">
                                Coach Charles Ross leads Splash City West and Roosevelt High School with a clear mission: build complete student-athletes. His approach emphasizes academics first, daily accountability, and the life skills players need to succeed beyond basketball.
                            </p>
                            <p class="mt-4 max-w-3xl text-sm leading-6 text-[#64748b]">
                                The standard is simple: improve 1% every day through discipline, teamwork, and consistent effort on and off the court.
                            </p>
                        </div>
                    </article>

                    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($programCards as $card)
                            <article class="overflow-hidden rounded-4xl border border-white/70 bg-white/85 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur">
                                <div class="aspect-4/5 bg-[#e2e8f0]">
                                    <img
                                        src="{{ $card['image'] }}"
                                        alt="{{ $card['title'] }} program image"
                                        class="object-cover w-full h-full"
                                    >
                                </div>
                                <div class="p-5">
                                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[#f26a0a]">{{ $card['title'] }}</p>
                                    <p class="mt-2 text-sm leading-6 text-[#475569]">{{ $card['subtitle'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="contact" class="grid gap-6 pb-6 lg:grid-cols-[0.95fr_1.05fr]">
                    <article class="rounded-4xl border border-white/70 bg-white/85 p-7 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Contact</p>
                        <h3 class="mt-3 text-3xl font-black text-[#0b2340]">Connect with Coach Ross</h3>
                        <p class="mt-4 text-base leading-7 text-[#475569]">
                            For program questions, scheduling, or support opportunities, contact Coach Charles Ross directly.
                        </p>

                        <div class="mt-6 space-y-3">
                            @foreach ($contactInfo as $item)
                                <a href="{{ $item['href'] }}" class="flex items-center justify-between rounded-2xl border border-[#e2e8f0] bg-[#f8fafc] px-4 py-4 transition hover:border-[#f26a0a]/30 hover:bg-white">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#64748b]">{{ $item['label'] }}</p>
                                        <p class="mt-1 text-base font-semibold text-[#0b2340]">{{ $item['value'] }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-[#f26a0a]">Reach out</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 rounded-3xl bg-[#0d2a4a] p-5 text-white">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/65">Social media</p>
                            <div class="grid gap-3 mt-4 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                                @foreach ($socialLinks as $social)
                                    <a href="{{ $social['href'] }}" target="_blank" rel="noreferrer" class="px-4 py-4 transition border rounded-2xl border-white/10 bg-white/8 hover:bg-white/12">
                                        <p class="text-sm font-semibold text-white">{{ $social['label'] }}</p>
                                        <p class="mt-1 text-sm text-white/70">{{ $social['value'] }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <article class="relative overflow-hidden rounded-4xl border border-white/85 bg-linear-to-br from-[#061a33] via-[#102a4d] to-[#071b34] p-7 text-white ring-1 ring-[#f4b400]/35 shadow-[0_28px_85px_rgba(7,18,34,0.42)]">
                        <div class="absolute inset-0 bg-black pointer-events-none"></div>
                        <div class="relative z-10">
                        <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#f4b400]">Commitments</p>
                        <h3 class="mt-3 text-3xl font-black">Kids committed to colleges</h3>
                        <p class="max-w-2xl mt-4 text-base leading-7 text-white/90">
                            This section tracks athlete college commitments and program reach, showing families and supporters the long-term impact of our coaching and development.
                        </p>

                        <div class="grid gap-5 mt-8 sm:grid-cols-2">
                            <div class="p-6 border rounded-3xl border-white/30 bg-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)] backdrop-blur-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-white/85">Committed athletes</p>
                                <p class="mt-3 text-5xl font-black text-[#f4b400] drop-shadow-[0_4px_12px_rgba(0,0,0,0.35)]">{{ $collegeCommitments }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/85">Current number of players committed to college programs.</p>
                            </div>

                            <div class="p-6 border rounded-3xl border-white/30 bg-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)] backdrop-blur-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-white/85">Programs represented</p>
                                <p class="mt-3 text-5xl font-black text-[#86efac] drop-shadow-[0_4px_12px_rgba(0,0,0,0.35)]">{{ $programsRepresented }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/85">Current number of programs represented by the coaching platform.</p>
                            </div>
                        </div>
                        </div>
                    </article>
                </section>

                <section id="programs" class="grid gap-6 pb-6 lg:grid-cols-2">
                    @foreach ($programs as $program)
                        <article class="rounded-4xl border border-white/70 bg-white/85 p-7 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur">
                            <div class="mb-5 overflow-hidden rounded-3xl border border-white/70 bg-[#e2e8f0]">
                                <img
                                    src="{{ $program['image_url'] }}"
                                    alt="{{ $program['name'] }} program image"
                                    class="object-cover w-full h-52"
                                >
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#f26a0a]">{{ $program['subtitle'] ?: 'Program' }}</p>
                            <h3 class="mt-3 text-3xl font-black text-[#0b2340]">{{ $program['name'] }}</h3>
                            <p class="mt-4 text-base leading-7 text-[#475569]">{{ $program['description'] }}</p>
                        </article>
                    @endforeach
                </section>

                <section id="events" class="pb-6">
                    <div class="rounded-4xl border border-white/70 bg-white/85 p-7 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Current events</p>
                                <h3 class="mt-3 text-3xl font-black text-[#0b2340] sm:text-4xl">What is happening now</h3>
                                <p class="mt-3 max-w-2xl text-base leading-7 text-[#475569]">
                                    Keep families and supporters up to date with the next important dates, quick results, and program momentum.
                                </p>
                            </div>

                            <a href="#" class="inline-flex items-center justify-center rounded-full border border-[#0d2a4a]/15 bg-[#f8fafc] px-5 py-3 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]">
                                View all events
                            </a>
                        </div>

                        <div class="mt-7 grid gap-5 lg:grid-cols-[1.1fr_0.9fr]">
                            <article class="rounded-3xl border border-[#e2e8f0] bg-[#f8fafc] p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#64748b]">Upcoming</p>
                                <div class="mt-4 space-y-3">
                                    @foreach ($upcomingEvents as $event)
                                        <button
                                            type="button"
                                            class="w-full rounded-2xl border border-white bg-white px-4 py-4 text-left transition hover:border-[#f26a0a]/35"
                                            data-event-open
                                            data-event-date="{{ $event['date'] }}"
                                            data-event-title="{{ $event['title'] }}"
                                            data-event-details="{{ $event['details'] }}"
                                            data-event-image="{{ $event['image_url'] }}"
                                        >
                                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f26a0a]">{{ $event['date'] }}</p>
                                            <p class="mt-2 text-base font-semibold text-[#0b2340]">{{ $event['title'] }}</p>
                                            <p class="mt-1 text-sm leading-6 text-[#475569]">{{ $event['details'] }}</p>
                                            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#0d2a4a]/65">Click to view image</p>
                                        </button>
                                    @endforeach
                                </div>
                            </article>

                            <article class="rounded-3xl border border-[#0d2a4a]/10 bg-[#0d2a4a] p-5 text-white">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-white/65">Recent highlights</p>
                                <div class="mt-4 space-y-3">
                                    @foreach ($recentHighlights as $highlight)
                                        <div class="px-4 py-4 border rounded-2xl border-white/10 bg-white/8">
                                            <p class="text-sm leading-6 text-white/85">{{ $highlight }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="success-stories" class="pb-6">
                    <div class="rounded-4xl border border-white/70 bg-white/85 p-7 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur sm:p-8">
                        <div class="max-w-3xl">
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Success stories</p>
                            <h3 class="mt-3 text-3xl font-black text-[#0b2340] sm:text-4xl">Growth that shows on and off the court</h3>
                            <p class="mt-3 text-base leading-7 text-[#475569]">
                                Real progress from athletes in the program, from leadership habits to college opportunities.
                            </p>
                        </div>

                        <div class="mt-7" data-success-carousel>
                            <div class="relative min-h-60">
                                @foreach ($successStories as $story)
                                    <article class="success-story-slide rounded-3xl border border-[#e2e8f0] bg-[#f8fafc] p-5 sm:p-7 {{ $loop->first ? '' : 'hidden' }}" data-success-slide>
                                        <div class="grid gap-5 sm:grid-cols-[0.35fr_0.65fr] sm:items-start">
                                            <div class="overflow-hidden rounded-2xl border border-[#e2e8f0] bg-white p-2">
                                                <div class="flex h-52 items-center justify-center rounded-xl bg-[#eef2f7] sm:h-56">
                                                    <img src="{{ $story['image_url'] }}" alt="{{ $story['name'] }} story image" class="h-full w-full object-contain">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#f26a0a]">{{ $story['name'] }}</p>
                                                <h4 class="mt-3 text-2xl font-black text-[#0b2340] sm:text-3xl">{{ $story['title'] }}</h4>
                                                <p class="mt-3 max-w-3xl text-base leading-7 text-[#475569]">{{ $story['description'] }}</p>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between gap-4 mt-5">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]" data-success-prev>
                                        Previous
                                    </button>
                                    <button type="button" class="rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]" data-success-next>
                                        Next
                                    </button>
                                </div>

                                <div class="flex items-center gap-2" aria-label="Story indicators">
                                    @foreach ($successStories as $story)
                                        <button
                                            type="button"
                                            class="h-2.5 w-2.5 rounded-full transition {{ $loop->first ? 'bg-[#f26a0a]' : 'bg-[#cbd5e1]' }}"
                                            data-success-dot
                                            data-success-index="{{ $loop->index }}"
                                            aria-label="Go to story {{ $loop->iteration }}"
                                        ></button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="pointer-events-none fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1324]/70 p-4" data-event-modal>
                    <div class="w-full max-w-2xl overflow-hidden bg-white border shadow-2xl pointer-events-auto rounded-3xl border-white/20" role="dialog" aria-modal="true" aria-labelledby="event-modal-title">
                        <div class="relative bg-[#0d2a4a] p-5 text-white">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/70" data-event-modal-date></p>
                            <h4 id="event-modal-title" class="mt-2 text-2xl font-black" data-event-modal-title></h4>
                            <button type="button" class="absolute right-4 top-4 rounded-full border border-white/30 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-white/15" data-event-modal-close>Close</button>
                        </div>
                        <img src="" alt="Event image" class="object-cover w-full h-48 sm:h-72" data-event-modal-image>
                        <div class="p-5">
                            <p class="text-sm leading-6 text-[#475569]" data-event-modal-details></p>
                        </div>
                    </div>
                </div>

                <section id="donate" class="pb-8">
                    <div class="rounded-4xl border border-white/70 bg-[#0d2a4a] px-6 py-8 text-white shadow-[0_24px_90px_rgba(18,24,38,0.28)] sm:px-8 sm:py-10">
                        <div class="max-w-3xl">
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#f4b400]">Support the programs</p>
                            <h3 class="mt-3 text-3xl font-black sm:text-4xl">Support the team through our donation options.</h3>
                            <p class="max-w-2xl mt-4 text-base leading-7 text-white/75">
                                Donation methods and QR codes are managed in the admin landing settings.
                            </p>
                        </div>

                        <div class="grid gap-4 mt-8 sm:grid-cols-2 lg:grid-cols-3">
                            @forelse ($donations as $donation)
                                <div class="p-5 border rounded-3xl border-white/10 bg-white/8">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-white/65">{{ $donation['name'] }}</p>
                                            <p class="mt-2 text-lg font-semibold">{{ $donation['label'] }}</p>
                                        </div>
                                        <span class="h-12 w-12 rounded-2xl bg-linear-to-br {{ $donation['accent'] }}"></span>
                                    </div>

                                    @if (!empty($donation['qr_code_image_url']))
                                        <div class="p-3 mt-4 border rounded-2xl border-white/15 bg-white/10">
                                            <img src="{{ $donation['qr_code_image_url'] }}" alt="{{ $donation['name'] }} QR code" class="object-contain p-1 mx-auto bg-white h-36 w-36 rounded-xl" loading="lazy">
                                        </div>
                                    @endif

                                    <a
                                        @if ($donation['url'])
                                            href="{{ $donation['url'] }}" target="_blank" rel="noreferrer"
                                        @else
                                            href="#"
                                        @endif
                                        class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-white px-4 py-3 text-sm font-semibold text-[#0d2a4a] transition hover:bg-[#f4f4f5]"
                                    >
                                        {{ $donation['url'] ? 'Open ' . $donation['name'] : 'Add ' . $donation['name'] . ' link in admin settings' }}
                                    </a>
                                </div>
                            @empty
                                <div class="p-5 border rounded-3xl border-white/15 bg-white/8 lg:col-span-3">
                                    <p class="text-sm font-semibold text-white">No donation links have been configured yet.</p>
                                    <p class="mt-2 text-sm text-white/70">Add donation methods in the admin landing settings to show them here.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="staff" class="pb-8">
                    <div class="rounded-4xl border border-white/70 bg-white/85 p-7 shadow-[0_20px_60px_rgba(18,24,38,0.08)] backdrop-blur sm:p-8">
                        <div class="max-w-3xl">
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-[#2f7d32]">Staff</p>
                            <h3 class="mt-3 text-3xl font-black text-[#0b2340] sm:text-4xl">Meet the staff</h3>
                            <p class="mt-3 text-base leading-7 text-[#475569]">
                                Connect with the coaching and program staff supporting athlete development.
                            </p>
                        </div>

                        <div class="grid gap-5 mt-7 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($staffMembers as $member)
                                <article class="overflow-hidden rounded-3xl border border-[#e2e8f0] bg-white">
                                    <div class="h-56 bg-[#e2e8f0]">
                                        <img src="{{ $member['image_url'] }}" alt="{{ $member['name'] }} profile image" class="object-cover w-full h-full">
                                    </div>
                                    <div class="p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#f26a0a]">{{ $member['position'] }}</p>
                                        <h4 class="mt-2 text-xl font-black text-[#0b2340]">{{ $member['name'] }}</h4>
                                        <a href="mailto:{{ $member['email'] }}" class="mt-3 inline-flex text-sm font-semibold text-[#0d2a4a] hover:text-[#f26a0a]">{{ $member['email'] }}</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>

                <footer class="flex flex-col gap-4 border-t border-[#0d2a4a]/10 py-5 text-sm text-[#475569] sm:flex-row sm:items-center sm:justify-between">
                    <p>&copy; {{ now()->year }} Charles Ross Jr. All rights reserved.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('privacy-policy') }}" class="font-semibold text-[#0d2a4a] transition hover:text-[#f26a0a]">Privacy Policy</a>
                        <a href="{{ route('terms-and-conditions') }}" class="font-semibold text-[#0d2a4a] transition hover:text-[#f26a0a]">Terms &amp; Conditions</a>
                    </div>
                </footer>
                
            </main>
        </div>
    </body>
</html>