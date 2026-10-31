<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-zinc-800 bg-black/95 shadow-sm backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-2 py-1 transition hover:bg-white/10">
                        <x-application-logo class="h-10 w-10 rounded-xl bg-zinc-900 p-1.5 shadow-sm ring-1 ring-zinc-700" />
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-cyan-300">Admin Console</p>
                            <p class="text-sm font-bold text-zinc-100">{{ config('app.name', 'Charlie Ross') }}</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    <x-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard') || request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.settings')" :active="request()->routeIs('admin.settings*')">
                        {{ __('Landing Settings') }}
                    </x-nav-link>

                    <x-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.newsletters')" :active="request()->routeIs('admin.newsletters*')">
                        {{ __('Newsletters') }}
                    </x-nav-link>


                    <x-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Public Site') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-xl border border-zinc-700 bg-zinc-900 px-3 py-2 text-sm font-semibold leading-4 text-zinc-100 transition hover:bg-zinc-800 hover:text-white focus:outline-none">
                            <div class="max-w-[150px] truncate">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg border border-zinc-700 bg-zinc-900 p-2 text-zinc-200 transition duration-150 ease-in-out hover:bg-zinc-800 hover:text-white focus:bg-zinc-800 focus:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-zinc-800 bg-black sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard') || request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.settings')" :active="request()->routeIs('admin.settings*')">
                {{ __('Landing Settings') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('admin.newsletters')" :active="request()->routeIs('admin.newsletters*')">
                {{ __('Newsletters') }}
            </x-responsive-nav-link>


            <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Public Site') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-zinc-800 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-semibold text-zinc-100">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-zinc-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                        <x-responsive-nav-link class="text-zinc-200 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white focus:border-zinc-600 focus:bg-zinc-800 focus:text-white" :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
