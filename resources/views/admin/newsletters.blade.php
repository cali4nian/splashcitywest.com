<x-app-layout>
    <x-slot name="header">
        <div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-cyan-700">Administration</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">Newsletter Management</h2>
                <p class="mt-2 text-sm text-slate-600">Import, organize, and send campaigns from one workspace.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-3xl border border-slate-200/90 bg-white/95 p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-cyan-700">Manage newsletter subscribers in one place.</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900">Contacts and Imports</h3>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                Add contacts manually or bulk-import from CSV, TXT, XLSX, XLS, and JSON files. Existing emails are updated automatically.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-collapsible-section="import-contacts">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="import-contacts"
                aria-expanded="false"
                aria-controls="newsletter-section-import-contacts"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Import Contacts</h4>
                    <p class="mt-2 text-sm text-slate-600">Upload a contact file to create or update newsletter contacts in bulk.</p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="newsletter-section-import-contacts" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.newsletters.import') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div class="col-span-full">
                    <x-input-label for="contacts_file" :value="__('Import Contacts File')" />
                    <input id="contacts_file" name="contacts_file" type="file" accept=".csv,.txt,.xlsx,.xls,.json" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" required />
                    <x-input-error class="mt-2" :messages="$errors->get('contacts_file')" />
                    <p class="mt-2 text-xs text-slate-500">Supported formats: CSV, TXT, XLSX, XLS, JSON.</p>
                </div>

                <div class="col-span-full">
                    <x-primary-button>Import Contacts</x-primary-button>
                </div>
            </form>
            </div>
        </section>

        <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-collapsible-section="add-contact">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="add-contact"
                aria-expanded="false"
                aria-controls="newsletter-section-add-contact"
            >
                <h4 class="text-lg font-semibold text-slate-900">Add Contact</h4>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="newsletter-section-add-contact" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.newsletters.store') }}" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                @csrf

                <div>
                    <x-input-label for="new_newsletter_name" :value="__('Contact Name')" />
                    <x-text-input id="new_newsletter_name" name="newsletter_name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('newsletter_name')" />
                </div>

                <div>
                    <x-input-label for="new_newsletter_email" :value="__('Contact Email')" />
                    <x-text-input id="new_newsletter_email" name="newsletter_email" type="email" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('newsletter_email')" />
                </div>

                <div class="col-span-full">
                    <x-primary-button>Add Contact</x-primary-button>
                </div>
            </form>
            </div>
        </section>

        <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-collapsible-section="send-mass-email">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="send-mass-email"
                aria-expanded="false"
                aria-controls="newsletter-section-send-mass-email"
            >
                <span>
                    <h4 class="text-lg font-semibold text-slate-900">Send Mass Email</h4>
                    <p class="mt-2 text-sm text-slate-600">
                        Send one message to all saved newsletter contacts with a shared title, body content, and optional attachments.
                    </p>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="newsletter-section-send-mass-email" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.newsletters.send') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2">
                @csrf

                <div>
                    <x-input-label for="campaign_template" :value="__('Campaign Type')" />
                    <select id="campaign_template" name="campaign_template" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>
                        <option value="informational" @selected(old('campaign_template', 'informational') === 'informational')>Informational Newsletter</option>
                        <option value="fundraising" @selected(old('campaign_template') === 'fundraising')>Fundraising Campaign</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_template')" />
                </div>

                <div>
                    <x-input-label for="campaign_title" :value="__('Email Title / Subject')" />
                    <x-text-input id="campaign_title" name="campaign_title" type="text" class="mt-1 block w-full" :value="old('campaign_title')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_title')" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="campaign_body" :value="__('Email Body')" />
                    <textarea id="campaign_body" name="campaign_body" rows="8" class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500" required>{{ old('campaign_body') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_body')" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="campaign_embedded_image" :value="__('Embedded Image (Optional, In Email Body)')" />
                    <input id="campaign_embedded_image" name="campaign_embedded_image" type="file" accept="image/jpeg,image/png,image/gif,image/webp,image/bmp,image/avif" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_embedded_image')" />
                    <p class="mt-2 text-xs text-slate-500">This image is embedded directly in the email body (not sent as an attachment). Images over 5 MB are auto-shrunk before send. Total email payload (body + embedded image + attachments) must still stay under your SMTP provider limit.</p>
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="campaign_attachments" :value="__('Attachments (Optional)')" />
                    <input id="campaign_attachments" name="campaign_attachments[]" type="file" multiple class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500" />
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_attachments')" />
                    <x-input-error class="mt-2" :messages="$errors->get('campaign_attachments.*')" />
                    <p class="mt-2 text-xs text-slate-500">Accepted files include PDF, CSV, images (JPG, PNG, GIF, WEBP, HEIC, HEIF, AVIF, BMP), and Office docs (max 10 MB each, up to 8 files). Keep total campaign payload under your SMTP provider message-size cap.</p>
                </div>

                <div class="sm:col-span-2">
                    <x-primary-button>Send To All Contacts</x-primary-button>
                </div>
            </form>
            </div>
        </section>

        <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-collapsible-section="saved-contacts">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 text-left"
                data-collapse-toggle="saved-contacts"
                aria-expanded="false"
                aria-controls="newsletter-section-saved-contacts"
            >
                <span class="flex items-center gap-3">
                    <h4 class="text-lg font-semibold text-slate-900">Saved Contacts</h4>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">
                        {{ $newsletterContacts->total() }} contacts
                    </span>
                </span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-600" data-collapse-label>
                    Show
                </span>
            </button>

            <div id="newsletter-section-saved-contacts" class="mt-5 hidden" data-collapse-content>
            <form method="POST" action="{{ route('admin.newsletters.test-deliverability') }}" class="mb-5 flex flex-wrap items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4" onsubmit="return confirm('Run non-sending deliverability checks for all newsletter emails in the database and remove failing contacts?');">
                @csrf

                <x-primary-button>Check All Emails In Database (No Send)</x-primary-button>
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-amber-900">
                    {{ $newsletterContacts->total() }} total contacts
                </span>
                <p class="text-xs text-amber-800">
                    This does not send emails. It checks each saved contact for active inbox deliverability (including SMTP mailbox checks) and removes entries that fail.
                </p>
            </form>

            <form method="POST" action="{{ route('admin.newsletters.destroy-all') }}" class="grid gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 sm:grid-cols-[1fr_auto] sm:items-end" onsubmit="return confirm('Delete ALL newsletter contacts? This action cannot be undone.');">
                @csrf

                <div>
                    <x-input-label for="admin_password" :value="__('Admin Password (Required to Delete All)')" />
                    <x-text-input id="admin_password" name="admin_password" type="password" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('admin_password')" />
                </div>

                <div>
                    <x-danger-button>Delete All Contacts</x-danger-button>
                </div>
            </form>

            <form method="GET" action="{{ route('admin.newsletters') }}" class="mt-5 grid gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:grid-cols-[1fr_auto_auto] sm:items-end">
                <div>
                    <x-input-label for="search" :value="__('Search Contacts')" />
                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="$search" placeholder="Search by name or email" />
                </div>

                <div>
                    <x-primary-button>Search</x-primary-button>
                </div>

                <div>
                    @if ($search !== '')
                        <a href="{{ route('admin.newsletters') }}" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:text-slate-900">
                            Clear
                        </a>
                    @endif
                </div>
            </form>

            <p class="mt-3 text-xs text-slate-500">
                Showing {{ $newsletterContacts->count() }} of {{ $newsletterContacts->total() }} contacts.
            </p>

            <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200">
                @if ($newsletterContacts->isEmpty())
                    <p class="bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        No newsletter contacts yet. Add your first contact or import a file.
                    </p>
                @else
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left font-semibold uppercase tracking-[0.08em] text-slate-600">Name</th>
                                <th scope="col" class="px-4 py-3 text-left font-semibold uppercase tracking-[0.08em] text-slate-600">Email</th>
                                <th scope="col" class="px-4 py-3 text-left font-semibold uppercase tracking-[0.08em] text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($newsletterContacts as $newsletterContact)
                                <tr>
                                    <td class="px-4 py-3 align-top">
                                        <input
                                            id="newsletter_name_{{ $newsletterContact->id }}"
                                            name="newsletter_name"
                                            type="text"
                                            form="update_newsletter_{{ $newsletterContact->id }}"
                                            value="{{ $newsletterContact->name }}"
                                            class="block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                                            required
                                        />
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <input
                                            id="newsletter_email_{{ $newsletterContact->id }}"
                                            name="newsletter_email"
                                            type="email"
                                            form="update_newsletter_{{ $newsletterContact->id }}"
                                            value="{{ $newsletterContact->email }}"
                                            class="block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                                            required
                                        />
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <form id="update_newsletter_{{ $newsletterContact->id }}" method="POST" action="{{ route('admin.newsletters.update', $newsletterContact) }}">
                                                @csrf
                                                @method('PUT')
                                                <x-primary-button>Save</x-primary-button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.newsletters.destroy', $newsletterContact) }}" onsubmit="return confirm('Delete this newsletter contact? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Delete</x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                        {{ $newsletterContacts->links() }}
                    </div>
                @endif
            </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const storageKey = 'newsletter-section-state';
            const defaultState = {
                'import-contacts': false,
                'add-contact': false,
                'send-mass-email': false,
                'saved-contacts': false,
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
