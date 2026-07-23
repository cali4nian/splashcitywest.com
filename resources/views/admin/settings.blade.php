<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Administration</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Landing Page Settings</h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900"
                >
                    Back to Dashboard
                </a>
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900"
                >
                    View Public Site
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-medium text-slate-600">Welcome back, {{ Auth::user()->name }}.</p>
            <h3 class="mt-2 text-3xl font-semibold text-slate-900">Manage Landing Page Content</h3>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                This page controls the editable sections displayed on the public homepage, including settings, programs,
                events, social links, stories, donation links, and staff cards.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Online</p>
                <p class="mt-2 text-sm text-slate-600">Site and authentication system are active.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Account</p>
                <p class="mt-3 truncate text-lg font-semibold text-slate-900">{{ Auth::user()->email }}</p>
                <p class="mt-2 text-sm text-slate-600">Signed in as the current admin user.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Security</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Protected</p>
                <p class="mt-2 text-sm text-slate-600">Admin routes require login before access.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Ready</p>
                <p class="mt-2 text-sm text-slate-600">Edit profile, review pages, and publish updates.</p>
            </section>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h4 class="text-lg font-semibold text-slate-900">Quick Links</h4>
                <ul class="mt-4 space-y-3 text-sm text-slate-700">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Go to Dashboard Overview
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Edit Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Open Public Homepage
                        </a>
                    </li>
                    <li>
                        <a href="#settings" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Contact and Commitment Settings
                        </a>
                    </li>
                    <li>
                        <a href="#programs" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Programs
                        </a>
                    </li>
                    <li>
                        <a href="#social-links" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Social Media Links
                        </a>
                    </li>
                    <li>
                        <a href="#events" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Current Events
                        </a>
                    </li>
                    <li>
                        <a href="#success-stories" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Success Stories
                        </a>
                    </li>
                    <li>
                        <a href="#donation-links" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Donation Links
                        </a>
                    </li>
                    <li>
                        <a href="#staff" class="inline-flex items-center font-medium text-slate-900 hover:text-slate-600">
                            Manage Staff
                        </a>
                    </li>
                </ul>
            </section>

            <section id="settings" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
                <h4 class="text-lg font-semibold text-slate-900">Public Contact and Commitment Settings</h4>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Update what appears on the public homepage contact section and commitments counter.
                </p>

                @if (session('status'))
                    <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="contact_phone" :value="__('Contact Phone')" />
                        <x-text-input
                            id="contact_phone"
                            name="contact_phone"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('contact_phone', $settings['contact_phone'])"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('contact_phone')" />
                    </div>

                    <div>
                        <x-input-label for="contact_email" :value="__('Contact Email')" />
                        <x-text-input
                            id="contact_email"
                            name="contact_email"
                            type="email"
                            class="mt-1 block w-full"
                            :value="old('contact_email', $settings['contact_email'])"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('contact_email')" />
                    </div>

                    <div>
                        <x-input-label for="college_commitments" :value="__('Kids Committed to Colleges')" />
                        <x-text-input
                            id="college_commitments"
                            name="college_commitments"
                            type="number"
                            min="0"
                            class="mt-1 block w-full"
                            :value="old('college_commitments', $settings['college_commitments'])"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('college_commitments')" />
                    </div>

                    <div>
                        <x-input-label for="programs_represented" :value="__('Programs Represented')" />
                        <x-text-input
                            id="programs_represented"
                            name="programs_represented"
                            type="number"
                            min="0"
                            class="mt-1 block w-full"
                            :value="old('programs_represented', $settings['programs_represented'])"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('programs_represented')" />
                    </div>

                    <div>
                        <x-primary-button>Save Settings</x-primary-button>
                    </div>
                </form>
            </section>
        </div>

        <section id="programs" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Programs</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove program cards shown on the public homepage.
            </p>

            <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_program_name" :value="__('Program Name')" />
                    <x-text-input id="new_program_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="new_program_subtitle" :value="__('Subtitle (Optional)')" />
                    <x-text-input id="new_program_subtitle" name="subtitle" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_program_description" :value="__('Description')" />
                    <textarea id="new_program_description" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_program_image" :value="__('Program Image (Optional)')" />
                    <input id="new_program_image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="mt-2 text-xs text-slate-500">If no image is uploaded, a default fallback image will be shown on the homepage.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Program</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($programs as $program)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.programs.update', $program) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'program_name_' . $program->id" :value="__('Program Name')" />
                                <x-text-input :id="'program_name_' . $program->id" name="name" type="text" class="mt-1 block w-full" :value="$program->name" required />
                            </div>

                            <div>
                                <x-input-label :for="'program_subtitle_' . $program->id" :value="__('Subtitle (Optional)')" />
                                <x-text-input :id="'program_subtitle_' . $program->id" name="subtitle" type="text" class="mt-1 block w-full" :value="$program->subtitle" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'program_description_' . $program->id" :value="__('Description')" />
                                <textarea id="program_description_{{ $program->id }}" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>{{ $program->description }}</textarea>
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'program_image_' . $program->id" :value="__('Program Image (Optional)')" />
                                <input id="program_image_{{ $program->id }}" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($program->image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current image: {{ $program->image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No image uploaded. Fallback image is currently used.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Program</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" class="mt-3" onsubmit="return confirm('Delete this program? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No programs yet. Add your first program using the form above.
                    </p>
                @endforelse
            </div>
        </section>

        <section id="social-links" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Social Media Links</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove social links shown in the public contact section.
            </p>

            <form method="POST" action="{{ route('admin.social-links.store') }}" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_social_platform" :value="__('Platform')" />
                    <x-text-input id="new_social_platform" name="platform" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('platform')" />
                </div>

                <div>
                    <x-input-label for="new_social_handle" :value="__('Handle (Optional)')" />
                    <x-text-input id="new_social_handle" name="handle" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('handle')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_social_url" :value="__('URL')" />
                    <x-text-input id="new_social_url" name="url" type="url" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Social Link</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($socialLinks as $socialLink)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.social-links.update', $socialLink) }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'social_platform_' . $socialLink->id" :value="__('Platform')" />
                                <x-text-input :id="'social_platform_' . $socialLink->id" name="platform" type="text" class="mt-1 block w-full" :value="$socialLink->platform" required />
                            </div>

                            <div>
                                <x-input-label :for="'social_handle_' . $socialLink->id" :value="__('Handle (Optional)')" />
                                <x-text-input :id="'social_handle_' . $socialLink->id" name="handle" type="text" class="mt-1 block w-full" :value="$socialLink->handle" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'social_url_' . $socialLink->id" :value="__('URL')" />
                                <x-text-input :id="'social_url_' . $socialLink->id" name="url" type="url" class="mt-1 block w-full" :value="$socialLink->url" required />
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Social Link</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.social-links.destroy', $socialLink) }}" class="mt-3" onsubmit="return confirm('Delete this social link? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No social links yet. Add your first social link using the form above.
                    </p>
                @endforelse
            </div>
        </section>

        <section id="events" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Current Events</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove events shown in the public Current Events section.
            </p>

            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_event_date" :value="__('Event Date')" />
                    <x-text-input id="new_event_date" name="event_date" type="text" class="mt-1 block w-full" placeholder="Jul 18, 2026" required />
                    <x-input-error class="mt-2" :messages="$errors->get('event_date')" />
                </div>

                <div>
                    <x-input-label for="new_event_title" :value="__('Title')" />
                    <x-text-input id="new_event_title" name="title" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_event_details" :value="__('Details')" />
                    <textarea id="new_event_details" name="details" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('details')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_event_image" :value="__('Event Image (Optional)')" />
                    <input id="new_event_image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="mt-2 text-xs text-slate-500">If no image is uploaded, a fallback image will be shown in the event popup.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Event</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($events as $event)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'event_date_' . $event->id" :value="__('Event Date')" />
                                <x-text-input :id="'event_date_' . $event->id" name="event_date" type="text" class="mt-1 block w-full" :value="$event->event_date" required />
                            </div>

                            <div>
                                <x-input-label :for="'event_title_' . $event->id" :value="__('Title')" />
                                <x-text-input :id="'event_title_' . $event->id" name="title" type="text" class="mt-1 block w-full" :value="$event->title" required />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'event_details_' . $event->id" :value="__('Details')" />
                                <textarea id="event_details_{{ $event->id }}" name="details" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>{{ $event->details }}</textarea>
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'event_image_' . $event->id" :value="__('Event Image (Optional)')" />
                                <input id="event_image_{{ $event->id }}" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($event->image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current image: {{ $event->image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No image uploaded. Fallback image is currently used.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Event</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="mt-3" onsubmit="return confirm('Delete this event? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No events yet. Add your first event using the form above.
                    </p>
                @endforelse
            </div>
        </section>

        <section id="success-stories" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Success Stories</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove success stories shown in the public Success Stories section.
            </p>

            <form method="POST" action="{{ route('admin.success-stories.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_story_name" :value="__('Name')" />
                    <x-text-input id="new_story_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="new_story_title" :value="__('Title')" />
                    <x-text-input id="new_story_title" name="title" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_story_description" :value="__('Description')" />
                    <textarea id="new_story_description" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_story_image" :value="__('Image (Optional)')" />
                    <input id="new_story_image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="mt-2 text-xs text-slate-500">If no image is uploaded, a fallback image is shown on the homepage.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Success Story</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($successStories as $successStory)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.success-stories.update', $successStory) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'story_name_' . $successStory->id" :value="__('Name')" />
                                <x-text-input :id="'story_name_' . $successStory->id" name="name" type="text" class="mt-1 block w-full" :value="$successStory->name" required />
                            </div>

                            <div>
                                <x-input-label :for="'story_title_' . $successStory->id" :value="__('Title')" />
                                <x-text-input :id="'story_title_' . $successStory->id" name="title" type="text" class="mt-1 block w-full" :value="$successStory->title" required />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'story_description_' . $successStory->id" :value="__('Description')" />
                                <textarea id="story_description_{{ $successStory->id }}" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>{{ $successStory->description }}</textarea>
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'story_image_' . $successStory->id" :value="__('Image (Optional)')" />
                                <input id="story_image_{{ $successStory->id }}" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($successStory->image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current image: {{ $successStory->image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No image uploaded. Fallback image is currently used.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Success Story</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.success-stories.destroy', $successStory) }}" class="mt-3" onsubmit="return confirm('Delete this success story? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No success stories yet. Add your first story using the form above.
                    </p>
                @endforelse
            </div>
        </section>

        <section id="donation-links" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Donation Links</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove donation links shown in the Support the Programs section.
            </p>

            <form method="POST" action="{{ route('admin.donation-links.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_donation_name" :value="__('Name')" />
                    <x-text-input id="new_donation_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="new_donation_label" :value="__('Label')" />
                    <x-text-input id="new_donation_label" name="label" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('label')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_donation_url" :value="__('URL (Optional)')" />
                    <x-text-input id="new_donation_url" name="url" type="url" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_donation_qr_code_image" :value="__('QR Code Image (Optional)')" />
                    <input id="new_donation_qr_code_image" name="qr_code_image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('qr_code_image')" />
                    <p class="mt-2 text-xs text-slate-500">Upload a QR image so supporters can scan directly from the donation card.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Donation Link</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($donationLinks as $donationLink)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.donation-links.update', $donationLink) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'donation_name_' . $donationLink->id" :value="__('Name')" />
                                <x-text-input :id="'donation_name_' . $donationLink->id" name="name" type="text" class="mt-1 block w-full" :value="$donationLink->name" required />
                            </div>

                            <div>
                                <x-input-label :for="'donation_label_' . $donationLink->id" :value="__('Label')" />
                                <x-text-input :id="'donation_label_' . $donationLink->id" name="label" type="text" class="mt-1 block w-full" :value="$donationLink->label" required />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'donation_url_' . $donationLink->id" :value="__('URL (Optional)')" />
                                <x-text-input :id="'donation_url_' . $donationLink->id" name="url" type="url" class="mt-1 block w-full" :value="$donationLink->url" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'donation_qr_code_image_' . $donationLink->id" :value="__('QR Code Image (Optional)')" />
                                <input id="donation_qr_code_image_{{ $donationLink->id }}" name="qr_code_image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($donationLink->qr_code_image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current QR image: {{ $donationLink->qr_code_image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No QR image uploaded.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Donation Link</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.donation-links.destroy', $donationLink) }}" class="mt-3" onsubmit="return confirm('Delete this donation link? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No donation links yet. Add your first donation link using the form above.
                    </p>
                @endforelse
            </div>
        </section>

        <section id="staff" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24">
            <h4 class="text-lg font-semibold text-slate-900">Manage Staff</h4>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Add, edit, and remove staff cards shown after the Support the Programs section.
            </p>

            <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_staff_name" :value="__('Name')" />
                    <x-text-input id="new_staff_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="new_staff_position" :value="__('Position')" />
                    <x-text-input id="new_staff_position" name="position" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('position')" />
                </div>

                <div>
                    <x-input-label for="new_staff_email" :value="__('Email')" />
                    <x-text-input id="new_staff_email" name="email" type="email" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_staff_image" :value="__('Image (Optional)')" />
                    <input id="new_staff_image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="mt-2 text-xs text-slate-500">If no image is uploaded, a fallback image is shown on the homepage.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Staff Member</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($staffMembers as $staffMember)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.staff.update', $staffMember) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'staff_name_' . $staffMember->id" :value="__('Name')" />
                                <x-text-input :id="'staff_name_' . $staffMember->id" name="name" type="text" class="mt-1 block w-full" :value="$staffMember->name" required />
                            </div>

                            <div>
                                <x-input-label :for="'staff_position_' . $staffMember->id" :value="__('Position')" />
                                <x-text-input :id="'staff_position_' . $staffMember->id" name="position" type="text" class="mt-1 block w-full" :value="$staffMember->position" required />
                            </div>

                            <div>
                                <x-input-label :for="'staff_email_' . $staffMember->id" :value="__('Email')" />
                                <x-text-input :id="'staff_email_' . $staffMember->id" name="email" type="email" class="mt-1 block w-full" :value="$staffMember->email" required />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'staff_image_' . $staffMember->id" :value="__('Image (Optional)')" />
                                <input id="staff_image_{{ $staffMember->id }}" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($staffMember->image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current image: {{ $staffMember->image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No image uploaded. Fallback image is currently used.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Staff Member</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.staff.destroy', $staffMember) }}" class="mt-3" onsubmit="return confirm('Delete this staff member? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No staff members yet. Add your first staff member using the form above.
                    </p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
