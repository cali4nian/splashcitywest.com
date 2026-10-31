<x-app-layout>
    <x-slot name="header">
        <div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-cyan-700">Administration</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">Landing Page Settings</h2>
                <p class="mt-2 text-sm text-slate-600">Edit homepage content with clear, grouped controls.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-3xl border border-slate-200/90 bg-white/95 p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-cyan-700">Welcome back, {{ Auth::user()->name }}.</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900">Manage Landing Page Content</h3>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                This page controls the editable sections displayed on the public homepage, including settings, programs,
                events, social links, stories, donation links, and staff cards.
            </p>
        </div>

        <section id="updates" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24" data-collapsible-section="updates">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="updates"
                aria-expanded="false"
                aria-controls="landing-section-updates"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Manage Updates</h4>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Add, edit, and remove unified updates for programs, current events, and success stories.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="landing-section-updates" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.updates.store') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_update_category" :value="__('Update Category')" />
                    <select id="new_update_category" name="category" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>
                        <option value="">Select category</option>
                        @foreach (\App\Models\Update::categoryOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('category')" />
                </div>

                <div>
                    <x-input-label for="new_update_title" :value="__('Title')" />
                    <x-text-input id="new_update_title" name="title" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div>
                    <x-input-label for="new_update_subtitle" :value="__('Subtitle (Optional)')" />
                    <x-text-input id="new_update_subtitle" name="subtitle" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_update_description" :value="__('Description')" />
                    <textarea id="new_update_description" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="new_update_image" :value="__('Update Image (Optional)')" />
                    <input id="new_update_image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="mt-2 text-xs text-slate-500">If no image is uploaded, a fallback image will be shown on the homepage.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Update</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($updates as $update)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.updates.update', $update) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'update_category_' . $update->id" :value="__('Update Category')" />
                                <select id="update_category_{{ $update->id }}" name="category" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>
                                    @foreach (\App\Models\Update::categoryOptions() as $value => $label)
                                        <option value="{{ $value }}" @selected($update->category === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label :for="'update_title_' . $update->id" :value="__('Title')" />
                                <x-text-input :id="'update_title_' . $update->id" name="title" type="text" class="mt-1 block w-full" :value="$update->title" required />
                            </div>

                            <div>
                                <x-input-label :for="'update_subtitle_' . $update->id" :value="__('Subtitle (Optional)')" />
                                <x-text-input :id="'update_subtitle_' . $update->id" name="subtitle" type="text" class="mt-1 block w-full" :value="$update->subtitle" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'update_description_' . $update->id" :value="__('Description')" />
                                <textarea id="update_description_{{ $update->id }}" name="description" rows="3" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>{{ $update->description }}</textarea>
                            </div>

                            <div class="col-span-full">
                                <x-input-label :for="'update_image_' . $update->id" :value="__('Update Image (Optional)')" />
                                <input id="update_image_{{ $update->id }}" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                                @if ($update->image_path)
                                    <p class="mt-2 text-xs text-slate-500">Current image: {{ $update->image_path }}</p>
                                @else
                                    <p class="mt-2 text-xs text-slate-500">No image uploaded. Fallback image is currently used.</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Update</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.updates.destroy', $update) }}" class="mt-3" onsubmit="return confirm('Delete this update? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No updates yet. Add your first update using the form above.
                    </p>
                @endforelse
            </div>
            </div>
        </section>

        <section id="highlight-links" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24" data-collapsible-section="highlight-links">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="highlight-links"
                aria-expanded="false"
                aria-controls="landing-section-highlight-links"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Manage Highlights URL Links</h4>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Upload highlight URL links, then edit or delete them as needed.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="landing-section-highlight-links" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.highlight-links.store') }}" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_highlight_title" :value="__('Title')" />
                    <x-text-input id="new_highlight_title" name="title" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="sm:col-span-2 lg:col-span-2">
                    <x-input-label for="new_highlight_url" :value="__('Highlight URL')" />
                    <x-text-input id="new_highlight_url" name="url" type="url" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Highlight Link</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($highlightLinks as $highlightLink)
                    <article class="rounded-xl border border-slate-200 p-4">
                        <form method="POST" action="{{ route('admin.highlight-links.update', $highlightLink) }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :for="'highlight_title_' . $highlightLink->id" :value="__('Title')" />
                                <x-text-input :id="'highlight_title_' . $highlightLink->id" name="title" type="text" class="mt-1 block w-full" :value="$highlightLink->title" required />
                            </div>

                            <div class="sm:col-span-2 lg:col-span-2">
                                <x-input-label :for="'highlight_url_' . $highlightLink->id" :value="__('Highlight URL')" />
                                <x-text-input :id="'highlight_url_' . $highlightLink->id" name="url" type="url" class="mt-1 block w-full" :value="$highlightLink->url" required />
                            </div>

                            <div class="flex items-center gap-3 col-span-full">
                                <x-primary-button>Save Highlight Link</x-primary-button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.highlight-links.destroy', $highlightLink) }}" class="mt-3" onsubmit="return confirm('Delete this highlight link? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No highlight links yet. Add your first highlight link using the form above.
                    </p>
                @endforelse
            </div>
            </div>
        </section>

        <section id="social-links" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24" data-collapsible-section="social-links">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="social-links"
                aria-expanded="false"
                aria-controls="landing-section-social-links"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Manage Social Media Links</h4>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Add, edit, and remove social links shown in the public contact section.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="landing-section-social-links" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.social-links.store') }}" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
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
            </div>
        </section>

        <section id="donation-links" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24" data-collapsible-section="donation-links">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="donation-links"
                aria-expanded="false"
                aria-controls="landing-section-donation-links"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Manage Donation Links</h4>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Add, edit, and remove donation links shown in the Support the Programs section.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="landing-section-donation-links" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.donation-links.store') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
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
            </div>
        </section>

        <section id="staff" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm scroll-mt-24" data-collapsible-section="staff">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="staff"
                aria-expanded="false"
                aria-controls="landing-section-staff"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Manage Staff</h4>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Add, edit, and remove staff cards shown after the Support the Programs section.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="landing-section-staff" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
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
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const storageKey = 'landing-settings-section-state';
            const defaultState = {
                'settings': false,
                'programs': false,
                'social-links': false,
                'events': false,
                'success-stories': false,
                'donation-links': false,
                'staff': false,
            };

            let sectionState = { ...defaultState };

            try {
                const savedState = JSON.parse(localStorage.getItem(storageKey) || '{}');

                if (savedState && typeof savedState === 'object') {
                    sectionState = { ...sectionState, ...savedState };
                }
            } catch (error) {
                sectionState = { ...defaultState };
            }

            const applyState = (sectionKey, isOpen) => {
                const toggle = document.querySelector(`[data-collapse-toggle="${sectionKey}"]`);
                const wrapper = document.querySelector(`[data-collapsible-section="${sectionKey}"]`);

                if (!toggle || !wrapper) {
                    return;
                }

                const content = wrapper.querySelector('[data-collapse-content]');
                const label = wrapper.querySelector('[data-collapse-label]');

                if (!content || !label) {
                    return;
                }

                content.classList.toggle('hidden', !isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                label.textContent = isOpen ? 'Hide' : 'Show';
            };

            document.querySelectorAll('[data-collapse-toggle]').forEach((toggle) => {
                const sectionKey = toggle.getAttribute('data-collapse-toggle');

                if (!sectionKey) {
                    return;
                }

                applyState(sectionKey, sectionState[sectionKey] === true);

                toggle.addEventListener('click', () => {
                    const current = sectionState[sectionKey] === true;
                    const nextState = !current;

                    sectionState[sectionKey] = nextState;
                    applyState(sectionKey, nextState);
                    localStorage.setItem(storageKey, JSON.stringify(sectionState));
                });
            });
        });
    </script>
</x-app-layout>
