<?php

namespace App\Http\Controllers;

use App\Models\DonationLink;
use App\Models\NewsletterContact;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\SiteEvent;
use App\Models\StaffMember;
use App\Models\SuccessStory;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Shuchkin\SimpleXLS;
use Shuchkin\SimpleXLSX;
use Throwable;

class AdminSettingsController extends Controller
{
    public function dashboard(): View
    {
        [
            'settings' => $settings,
            'programs' => $programs,
            'socialLinks' => $socialLinks,
            'events' => $events,
            'successStories' => $successStories,
            'donationLinks' => $donationLinks,
            'staffMembers' => $staffMembers,
        ] = $this->buildAdminData();

        return view('admin.dashboard', compact('settings', 'programs', 'socialLinks', 'events', 'successStories', 'donationLinks', 'staffMembers'));
    }

    public function settings(): View
    {
        [
            'settings' => $settings,
            'programs' => $programs,
            'socialLinks' => $socialLinks,
            'events' => $events,
            'successStories' => $successStories,
            'donationLinks' => $donationLinks,
            'staffMembers' => $staffMembers,
        ] = $this->buildAdminData();

        return view('admin.settings', compact('settings', 'programs', 'socialLinks', 'events', 'successStories', 'donationLinks', 'staffMembers'));
    }

    public function newsletters(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $newsletterContacts = Schema::hasTable('newsletter_contacts')
            ? NewsletterContact::query()
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($innerQuery) use ($search): void {
                        $innerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(100)
                ->withQueryString()
            : NewsletterContact::query()->whereRaw('1 = 0')->paginate(100);

        return view('admin.newsletters', compact('newsletterContacts', 'search'));
    }

    private function buildAdminData(): array
    {
        $rawSettings = SiteSetting::values(
            ['contact_phone', 'contact_email', 'college_commitments', 'programs_represented'],
            [
                'contact_phone' => '323 383 3758',
                'contact_email' => 'charles.ross@fresnounified.org',
                'college_commitments' => 10,
                'programs_represented' => 2,
            ]
        );

        $settings = [
            'contact_phone' => $rawSettings['contact_phone'],
            'contact_email' => $rawSettings['contact_email'],
            'college_commitments' => (int) $rawSettings['college_commitments'],
            'programs_represented' => (int) $rawSettings['programs_represented'],
        ];

        $programs = Schema::hasTable('programs')
            ? Program::query()->orderBy('name')->get()
            : collect();

        if (Schema::hasTable('programs') && $programs->isEmpty()) {
            Program::query()->create([
                'name' => 'Splash City West',
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
            ]);

            Program::query()->create([
                'name' => 'Roosevelt High School',
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
            ]);

            $programs = Program::query()->orderBy('name')->get();
        }

        $socialLinks = Schema::hasTable('social_links')
            ? SocialLink::query()->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('social_links') && $socialLinks->isEmpty()) {
            SocialLink::query()->create([
                'platform' => 'Instagram',
                'handle' => '@splash_city_west',
                'url' => 'https://www.instagram.com/splash_city_west/',
            ]);

            SocialLink::query()->create([
                'platform' => 'Instagram',
                'handle' => '@charles559209f',
                'url' => 'https://www.instagram.com/charles559209f/',
            ]);

            $socialLinks = SocialLink::query()->orderBy('id')->get();
        }

        $events = Schema::hasTable('site_events')
            ? SiteEvent::query()->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('site_events') && $events->isEmpty()) {
            SiteEvent::query()->create([
                'event_date' => 'Jul 18, 2026',
                'title' => 'Splash City West Open Gym',
                'details' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
            ]);

            SiteEvent::query()->create([
                'event_date' => 'Jul 25, 2026',
                'title' => 'Parent and Player Meeting',
                'details' => 'Team expectations, travel plans, and fundraiser goals at 5:30 PM',
            ]);

            SiteEvent::query()->create([
                'event_date' => 'Aug 2, 2026',
                'title' => 'Roosevelt Skills Session',
                'details' => 'Ball handling, shooting reps, and defensive stations at 9:00 AM',
            ]);

            $events = SiteEvent::query()->orderBy('id')->get();
        }

        $successStories = Schema::hasTable('success_stories')
            ? SuccessStory::query()->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('success_stories') && $successStories->isEmpty()) {
            SuccessStory::query()->create([
                'name' => 'Jalen M.',
                'title' => 'Earned a college roster spot',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
            ]);

            SuccessStory::query()->create([
                'name' => 'Marcus T.',
                'title' => 'Team captain leadership growth',
                'description' => 'Led summer workouts and helped raise attendance standards for younger players.',
            ]);

            SuccessStory::query()->create([
                'name' => 'Isaiah R.',
                'title' => 'All-tournament recognition',
                'description' => 'Turned defensive effort into impact plays and became a trusted closer in games.',
            ]);

            $successStories = SuccessStory::query()->orderBy('id')->get();
        }

        $donationLinks = Schema::hasTable('donation_links')
            ? DonationLink::query()->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('donation_links') && $donationLinks->isEmpty()) {
            DonationLink::query()->create([
                'name' => 'PayPal',
                'label' => 'Fast, familiar support',
                'url' => null,
            ]);

            DonationLink::query()->create([
                'name' => 'Cash App',
                'label' => 'Simple cash donations',
                'url' => null,
            ]);

            DonationLink::query()->create([
                'name' => 'Stripe',
                'label' => 'Credit card checkout',
                'url' => null,
            ]);

            $donationLinks = DonationLink::query()->orderBy('id')->get();
        }

        $staffMembers = Schema::hasTable('staff_members')
            ? StaffMember::query()->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('staff_members') && $staffMembers->isEmpty()) {
            StaffMember::query()->create([
                'name' => 'Charles Ross',
                'position' => 'Head Coach',
                'email' => 'charles.ross@fresnounified.org',
            ]);

            $staffMembers = StaffMember::query()->orderBy('id')->get();
        }

        $newsletterContacts = Schema::hasTable('newsletter_contacts')
            ? NewsletterContact::query()->orderByDesc('created_at')->get()
            : collect();

        return compact('settings', 'programs', 'socialLinks', 'events', 'successStories', 'donationLinks', 'staffMembers', 'newsletterContacts');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email', 'max:255'],
            'college_commitments' => ['required', 'integer', 'min:0'],
            'programs_represented' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => (string) $value],
            );
        }

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Admin settings updated successfully.');
    }

    public function storeProgram(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'subtitle' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('programs', 'public');
        }

        Program::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Program created successfully.');
    }

    public function updateProgram(Request $request, Program $program): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'subtitle' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                Storage::disk('public')->delete($program->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Program updated successfully.');
    }

    public function destroyProgram(Program $program): RedirectResponse
    {
        if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
            Storage::disk('public')->delete($program->image_path);
        }

        $program->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Program deleted successfully.');
    }

    public function storeSocialLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:100'],
            'handle' => ['nullable', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        SocialLink::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Social link created successfully.');
    }

    public function updateSocialLink(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:100'],
            'handle' => ['nullable', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $socialLink->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Social link updated successfully.');
    }

    public function destroySocialLink(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Social link deleted successfully.');
    }

    public function storeEvent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_date' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        SiteEvent::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Event created successfully.');
    }

    public function updateEvent(Request $request, SiteEvent $event): RedirectResponse
    {
        $validated = $request->validate([
            'event_date' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
                Storage::disk('public')->delete($event->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Event updated successfully.');
    }

    public function destroyEvent(SiteEvent $event): RedirectResponse
    {
        if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Event deleted successfully.');
    }

    public function storeSuccessStory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1500'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('success-stories', 'public');
        }

        SuccessStory::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Success story created successfully.');
    }

    public function updateSuccessStory(Request $request, SuccessStory $successStory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1500'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($successStory->image_path && Storage::disk('public')->exists($successStory->image_path)) {
                Storage::disk('public')->delete($successStory->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('success-stories', 'public');
        }

        $successStory->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Success story updated successfully.');
    }

    public function destroySuccessStory(SuccessStory $successStory): RedirectResponse
    {
        if ($successStory->image_path && Storage::disk('public')->exists($successStory->image_path)) {
            Storage::disk('public')->delete($successStory->image_path);
        }

        $successStory->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Success story deleted successfully.');
    }

    public function storeDonationLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:2048'],
            'qr_code_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('qr_code_image')) {
            $validated['qr_code_image_path'] = $request->file('qr_code_image')->store('donation-qr-codes', 'public');
        }

        DonationLink::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Donation link created successfully.');
    }

    public function updateDonationLink(Request $request, DonationLink $donationLink): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:2048'],
            'qr_code_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('qr_code_image')) {
            if ($donationLink->qr_code_image_path && Storage::disk('public')->exists($donationLink->qr_code_image_path)) {
                Storage::disk('public')->delete($donationLink->qr_code_image_path);
            }

            $validated['qr_code_image_path'] = $request->file('qr_code_image')->store('donation-qr-codes', 'public');
        }

        $donationLink->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Donation link updated successfully.');
    }

    public function destroyDonationLink(DonationLink $donationLink): RedirectResponse
    {
        if ($donationLink->qr_code_image_path && Storage::disk('public')->exists($donationLink->qr_code_image_path)) {
            Storage::disk('public')->delete($donationLink->qr_code_image_path);
        }

        $donationLink->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Donation link deleted successfully.');
    }

    public function storeStaffMember(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'position' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('staff', 'public');
        }

        StaffMember::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Staff member created successfully.');
    }

    public function updateStaffMember(Request $request, StaffMember $staffMember): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'position' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($staffMember->image_path && Storage::disk('public')->exists($staffMember->image_path)) {
                Storage::disk('public')->delete($staffMember->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('staff', 'public');
        }

        $staffMember->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Staff member updated successfully.');
    }

    public function destroyStaffMember(StaffMember $staffMember): RedirectResponse
    {
        if ($staffMember->image_path && Storage::disk('public')->exists($staffMember->image_path)) {
            Storage::disk('public')->delete($staffMember->image_path);
        }

        $staffMember->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Staff member deleted successfully.');
    }

    public function storeNewsletterContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'newsletter_name' => ['required', 'string', 'max:150'],
            'newsletter_email' => ['required', 'email', 'max:255', 'unique:newsletter_contacts,email'],
        ]);

        NewsletterContact::query()->create([
            'name' => $validated['newsletter_name'],
            'email' => strtolower($validated['newsletter_email']),
        ]);

        return redirect()
            ->route('admin.newsletters')
            ->with('status', 'Newsletter contact created successfully.');
    }

    public function sendNewsletterCampaign(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'campaign_template' => ['required', Rule::in(['informational', 'fundraising'])],
                'campaign_title' => ['required', 'string', 'max:150'],
                'campaign_body' => ['required', 'string', 'max:10000'],
                'campaign_attachments' => ['nullable', 'array', 'max:8'],
                'campaign_attachments.*' => [
                    'file',
                    'max:10240',
                    'mimes:pdf,txt,csv,jpg,jpeg,png,gif,webp,doc,docx,xls,xlsx,ppt,pptx,zip',
                ],
            ]);

            $recipients = NewsletterContact::query()->orderBy('id')->get(['id', 'name', 'email']);

            if ($recipients->isEmpty()) {
                return redirect()
                    ->route('admin.newsletters')
                    ->with('status', 'No newsletter contacts found. Add contacts before sending an email.');
            }

            $attachments = collect($request->file('campaign_attachments', []))
                ->map(static function (UploadedFile $file): array {
                    return [
                        'name' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType() ?: 'application/octet-stream',
                        'data' => (string) file_get_contents($file->getRealPath()),
                    ];
                })
                ->filter(static fn (array $attachment): bool => $attachment['data'] !== '')
                ->values()
                ->all();

            $sent = 0;
            $failed = 0;
            $deletedAfterFailure = 0;
            $networkFailures = 0;
            $senderConfigurationFailures = 0;
            $stoppedForSenderConfiguration = false;
            $recipientCount = $recipients->count();
            $delayBetweenSendsMicroseconds = max(0, min(6_000_000, (int) config('mail.newsletter_send_delay_us', 750000)));

            if (function_exists('set_time_limit')) {
                @set_time_limit(0);
            }

            foreach ($recipients->values() as $index => $recipient) {
                try {
                    Mail::send('emails.newsletter-campaign', [
                        'template' => $validated['campaign_template'],
                        'title' => $validated['campaign_title'],
                        'body' => $validated['campaign_body'],
                        'recipientName' => $recipient->name,
                    ], function ($message) use ($recipient, $validated, $attachments): void {
                        $message->to($recipient->email, $recipient->name)
                            ->subject($validated['campaign_title']);

                        foreach ($attachments as $attachment) {
                            $message->attachData($attachment['data'], $attachment['name'], [
                                'mime' => $attachment['mime'],
                            ]);
                        }
                    });

                    $sent++;
                } catch (Throwable $exception) {
                    report($exception);
                    $failed++;

                    $isSenderConfigurationFailure = $this->isMailSenderConfigurationFailure($exception);

                    if ($this->shouldDeleteNewsletterContactAfterFailure($exception)) {
                        $recipient->delete();
                        $deletedAfterFailure++;
                    } elseif ($isSenderConfigurationFailure) {
                        $senderConfigurationFailures++;
                        $stoppedForSenderConfiguration = true;
                    } else {
                        $networkFailures++;
                    }

                    if ($isSenderConfigurationFailure) {
                        // Sender/domain auth issues are global; continuing will fail for all recipients.
                        break;
                    }
                }

                if ($index < $recipientCount - 1 && $delayBetweenSendsMicroseconds > 0) {
                    // Keep pacing configurable to avoid provider throttling and request timeouts.
                    usleep($delayBetweenSendsMicroseconds);
                }
            }

            $statusMessage = "Mass email sent to {$sent} contacts.";

            if ($failed > 0) {
                $statusMessage .= " {$failed} sends failed. Check mail configuration or logs.";
            }

            if ($deletedAfterFailure > 0) {
                $statusMessage .= " Removed {$deletedAfterFailure} failed contact entries.";
            }

            if ($networkFailures > 0) {
                $statusMessage .= " {$networkFailures} failed sends were kept due to network/connectivity issues.";
            }

            if ($senderConfigurationFailures > 0) {
                $statusMessage .= ' Sending stopped because the configured sender/domain is not authorized by the mail provider.';
            }

            if ($stoppedForSenderConfiguration && $sent === 0) {
                $statusMessage .= ' Update MAIL_FROM_ADDRESS and SMTP credentials, then try again.';
            }

            return redirect()
                ->route('admin.newsletters')
                ->with('status', $statusMessage);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.newsletters')
                ->with('status', 'Email campaign could not be sent due to a server or mail configuration issue. Check logs and mail credentials.');
        }
    }

    public function updateNewsletterContact(Request $request, NewsletterContact $newsletterContact): RedirectResponse
    {
        $validated = $request->validate([
            'newsletter_name' => ['required', 'string', 'max:150'],
            'newsletter_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('newsletter_contacts', 'email')->ignore($newsletterContact->id),
            ],
        ]);

        $newsletterContact->update([
            'name' => $validated['newsletter_name'],
            'email' => strtolower($validated['newsletter_email']),
        ]);

        return redirect()
            ->route('admin.newsletters')
            ->with('status', 'Newsletter contact updated successfully.');
    }

    public function destroyNewsletterContact(NewsletterContact $newsletterContact): RedirectResponse
    {
        $newsletterContact->delete();

        return redirect()
            ->route('admin.newsletters')
            ->with('status', 'Newsletter contact deleted successfully.');
    }

    public function destroyAllNewsletterContacts(Request $request): RedirectResponse
    {
        $request->validate([
            'admin_password' => ['required', 'string', 'current_password'],
        ]);

        $deletedCount = NewsletterContact::query()->delete();

        return redirect()
            ->route('admin.newsletters')
            ->with('status', "Deleted {$deletedCount} newsletter contacts.");
    }

    public function importNewsletterContacts(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contacts_file' => ['required', 'file', 'max:10240', 'mimes:csv,txt,xlsx,xls,json'],
        ]);

        $file = $validated['contacts_file'];
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = $this->parseImportedRows($file->getRealPath(), $extension);

        [$contacts, $skippedRows] = $this->normalizeImportedContacts($rows);

        if (count($contacts) === 0) {
            return redirect()
                ->route('admin.newsletters')
                ->with('status', 'No valid contacts were found in the uploaded file.');
        }

        $created = 0;
        $updated = 0;

        foreach ($contacts as $contact) {
            $existing = NewsletterContact::query()->firstWhere('email', $contact['email']);

            if ($existing) {
                $existing->update(['name' => $contact['name']]);
                $updated++;
                continue;
            }

            NewsletterContact::query()->create($contact);
            $created++;
        }

        $statusMessage = "Imported {$created} new contacts and updated {$updated} contacts.";

        if ($skippedRows > 0) {
            $statusMessage .= " Skipped {$skippedRows} invalid rows.";
        }

        return redirect()
            ->route('admin.newsletters')
            ->with('status', $statusMessage);
    }

    private function parseImportedRows(string $filePath, string $extension): array
    {
        if ($extension === 'xlsx') {
            $xlsx = SimpleXLSX::parse($filePath);

            return $xlsx ? $xlsx->rows() : [];
        }

        if ($extension === 'xls') {
            $xls = SimpleXLS::parse($filePath);

            return $xls ? $xls->rows() : [];
        }

        if ($extension === 'json') {
            $decoded = json_decode((string) file_get_contents($filePath), true);

            return is_array($decoded) ? $decoded : [];
        }

        $rows = [];
        $handle = fopen($filePath, 'rb');

        if (! $handle) {
            return [];
        }

        $firstLine = fgets($handle);
        $delimiter = $this->detectCsvDelimiter($firstLine ?: '');
        rewind($handle);

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    private function normalizeImportedContacts(array $rows): array
    {
        $contacts = [];
        $seenEmails = [];
        $skippedRows = 0;
        $headerIndexes = null;

        foreach ($rows as $index => $row) {
            if (! is_array($row)) {
                $skippedRows++;
                continue;
            }

            $name = '';
            $email = '';

            if ($this->isAssocArray($row)) {
                $name = trim((string) ($row['name'] ?? $row['full_name'] ?? $row['first_name'] ?? ''));
                $email = trim((string) ($row['email'] ?? $row['email_address'] ?? ''));
            } else {
                $rowValues = array_map(static fn ($value): string => trim((string) $value), array_values($row));

                if ($index === 0) {
                    $headerIndexes = $this->detectHeaderIndexes($rowValues);

                    if ($headerIndexes !== null) {
                        continue;
                    }
                }

                if ($headerIndexes !== null) {
                    $name = $rowValues[$headerIndexes['name']] ?? '';
                    $email = $rowValues[$headerIndexes['email']] ?? '';
                } else {
                    $name = $rowValues[0] ?? '';
                    $email = $rowValues[1] ?? '';
                }
            }

            $email = strtolower($email);

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skippedRows++;
                continue;
            }

            if ($name === '') {
                $name = ucwords(str_replace(['.', '_', '-'], ' ', strtok($email, '@') ?: 'Subscriber'));
            }

            if (isset($seenEmails[$email])) {
                continue;
            }

            $contacts[] = [
                'name' => $name,
                'email' => $email,
            ];
            $seenEmails[$email] = true;
        }

        return [$contacts, $skippedRows];
    }

    private function detectHeaderIndexes(array $row): ?array
    {
        $normalized = array_map(static fn (string $value): string => strtolower(trim($value)), $row);
        $nameIndex = array_search('name', $normalized, true);
        $emailIndex = array_search('email', $normalized, true);

        if ($nameIndex === false) {
            $nameIndex = array_search('full name', $normalized, true);
        }

        if ($emailIndex === false) {
            $emailIndex = array_search('email address', $normalized, true);
        }

        if ($nameIndex === false || $emailIndex === false) {
            return null;
        }

        return [
            'name' => $nameIndex,
            'email' => $emailIndex,
        ];
    }

    private function detectCsvDelimiter(string $sampleLine): string
    {
        $delimiters = [',', ';', "\t", '|'];
        $bestDelimiter = ',';
        $bestCount = -1;

        foreach ($delimiters as $delimiter) {
            $count = substr_count($sampleLine, $delimiter);

            if ($count > $bestCount) {
                $bestCount = $count;
                $bestDelimiter = $delimiter;
            }
        }

        return $bestDelimiter;
    }

    private function isAssocArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    private function shouldDeleteNewsletterContactAfterFailure(Throwable $exception): bool
    {
        if ($this->isNetworkConnectivityFailure($exception)) {
            return false;
        }

        if ($this->isMailSenderConfigurationFailure($exception)) {
            return false;
        }

        return true;
    }

    private function isNetworkConnectivityFailure(Throwable $exception): bool
    {
        $networkKeywords = [
            'connection timed out',
            'timed out',
            'network is unreachable',
            'could not resolve host',
            'name or service not known',
            'temporary failure in name resolution',
            'failed to connect',
            'connection refused',
            'connection reset',
            'broken pipe',
            'operation timed out',
            'php_network_getaddresses',
        ];

        $current = $exception;

        while ($current instanceof Throwable) {
            $message = strtolower($current->getMessage());

            foreach ($networkKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return true;
                }
            }

            $current = $current->getPrevious();
        }

        return false;
    }

    private function isMailSenderConfigurationFailure(Throwable $exception): bool
    {
        $senderConfigKeywords = [
            'sending from domain',
            'sender address rejected',
            'mail from address rejected',
            'must be authenticated',
            'authentication required',
            'authentication failed',
            'invalid login',
            'relay access denied',
            'not allowed to send from',
            '5.7.1',
        ];

        $current = $exception;

        while ($current instanceof Throwable) {
            $message = strtolower($current->getMessage());

            foreach ($senderConfigKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return true;
                }
            }

            $current = $current->getPrevious();
        }

        return false;
    }
}
