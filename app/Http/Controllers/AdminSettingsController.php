<?php

namespace App\Http\Controllers;

use App\Models\DonationLink;
use App\Models\HighlightLink;
use App\Models\NewsletterContact;
use App\Models\SiteSetting;
use App\Models\StaffMember;
use App\Models\SocialLink;
use App\Models\Update;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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
            'updates' => $updates,
            'socialLinks' => $socialLinks,
            'donationLinks' => $donationLinks,
            'staffMembers' => $staffMembers,
        ] = $this->buildAdminData();

        return view('admin.dashboard', compact('settings', 'updates', 'socialLinks', 'donationLinks', 'staffMembers'));
    }

    public function settings(): View
    {
        [
            'settings' => $settings,
            'updates' => $updates,
            'highlightLinks' => $highlightLinks,
            'socialLinks' => $socialLinks,
            'donationLinks' => $donationLinks,
            'staffMembers' => $staffMembers,
        ] = $this->buildAdminData();

        return view('admin.settings', compact('settings', 'updates', 'highlightLinks', 'socialLinks', 'donationLinks', 'staffMembers'));
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

        $updates = Schema::hasTable('updates')
            ? Update::query()->orderBy('sort_order')->orderBy('id')->get()
            : collect();

        if (Schema::hasTable('updates') && $updates->isEmpty()) {
            Update::query()->create([
                'category' => Update::CATEGORY_PROGRAM,
                'title' => 'Splash City West',
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
                'sort_order' => 0,
            ]);

            Update::query()->create([
                'category' => Update::CATEGORY_PROGRAM,
                'title' => 'Roosevelt High School',
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
                'sort_order' => 1,
            ]);

            Update::query()->create([
                'category' => Update::CATEGORY_EVENT,
                'title' => 'Splash City West Open Gym',
                'subtitle' => 'Jul 18, 2026',
                'description' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
                'sort_order' => 2,
            ]);

            Update::query()->create([
                'category' => Update::CATEGORY_EVENT,
                'title' => 'Parent and Player Meeting',
                'subtitle' => 'Jul 25, 2026',
                'description' => 'Team expectations, travel plans, and fundraiser goals at 5:30 PM',
                'sort_order' => 3,
            ]);

            Update::query()->create([
                'category' => Update::CATEGORY_SUCCESS_STORY,
                'title' => 'Earned a college roster spot',
                'subtitle' => 'Jalen M.',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
                'sort_order' => 4,
            ]);

            $updates = Update::query()->orderBy('sort_order')->orderBy('id')->get();
        }

        $socialLinks = Schema::hasTable('social_links')
            ? SocialLink::query()->orderBy('id')->get()
            : collect();

        $highlightLinks = Schema::hasTable('highlight_links')
            ? HighlightLink::query()->orderBy('id')->get()
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

        return compact('settings', 'updates', 'highlightLinks', 'socialLinks', 'donationLinks', 'staffMembers', 'newsletterContacts');
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

    public function storeUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys(Update::categoryOptions()))],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('updates', 'public');
        }

        $validated['sort_order'] = (int) (Update::query()->max('sort_order') ?? -1) + 1;

        Update::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Update created successfully.');
    }

    public function updateUpdate(Request $request, Update $update): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys(Update::categoryOptions()))],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($update->image_path && Storage::disk('public')->exists($update->image_path)) {
                Storage::disk('public')->delete($update->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('updates', 'public');
        }

        $update->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Update updated successfully.');
    }

    public function destroyUpdate(Update $update): RedirectResponse
    {
        if ($update->image_path && Storage::disk('public')->exists($update->image_path)) {
            Storage::disk('public')->delete($update->image_path);
        }

        $update->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Update deleted successfully.');
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

    public function storeHighlightLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        HighlightLink::query()->create($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Highlight link created successfully.');
    }

    public function updateHighlightLink(Request $request, HighlightLink $highlightLink): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $highlightLink->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Highlight link updated successfully.');
    }

    public function destroyHighlightLink(HighlightLink $highlightLink): RedirectResponse
    {
        $highlightLink->delete();

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Highlight link deleted successfully.');
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
                'campaign_embedded_image' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,bmp,avif'],
                'campaign_attachments' => ['nullable', 'array', 'max:8'],
                'campaign_attachments.*' => [
                    'file',
                    'max:10240',
                    'mimes:pdf,txt,csv,jpg,jpeg,png,gif,webp,bmp,avif,heic,heif,doc,docx,xls,xlsx,ppt,pptx,zip',
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

            $embeddedImageUpload = $request->file('campaign_embedded_image');
            $embeddedImage = null;

            if ($embeddedImageUpload instanceof UploadedFile) {
                $embeddedImageData = (string) file_get_contents($embeddedImageUpload->getRealPath());
                $embeddedImageMime = $embeddedImageUpload->getMimeType() ?: 'application/octet-stream';

                if ($embeddedImageData !== '') {
                    $embeddedImageAutoShrinkThresholdBytes = 5 * 1024 * 1024;

                    if (strlen($embeddedImageData) > $embeddedImageAutoShrinkThresholdBytes) {
                        $shrunkenImage = $this->shrinkImageBinaryToMaxBytes($embeddedImageData, $embeddedImageAutoShrinkThresholdBytes);

                        if ($shrunkenImage !== null) {
                            $embeddedImageData = $shrunkenImage['data'];
                            $embeddedImageMime = $shrunkenImage['mime'];
                        }
                    }

                    $embeddedImage = [
                        'name' => $embeddedImageUpload->getClientOriginalName() ?: 'newsletter-image',
                        'mime' => $embeddedImageMime,
                        'data' => $embeddedImageData,
                    ];
                }
            }

            $maxMessageBytes = max(1_000_000, (int) config('mail.newsletter_max_message_bytes', 4_800_000));
            $estimatedPayloadBytes = $this->estimateNewsletterPayloadBytes(
                (string) $validated['campaign_title'],
                (string) $validated['campaign_body'],
                $attachments,
                $embeddedImage
            );

            if ($estimatedPayloadBytes > $maxMessageBytes) {
                $maxMessageMb = round($maxMessageBytes / 1024 / 1024, 2);
                $payloadMb = round($estimatedPayloadBytes / 1024 / 1024, 2);

                return redirect()
                    ->route('admin.newsletters')
                    ->with('status', "Email campaign not sent. Estimated payload size {$payloadMb} MB exceeds SMTP/provider limit of {$maxMessageMb} MB. Reduce embedded image or attachments and try again.");
            }

            $sent = 0;
            $failed = 0;
            $networkFailures = 0;
            $senderConfigurationFailures = 0;
            $messageSizeFailures = 0;
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
                        'embeddedImage' => $embeddedImage,
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
                    $isMessageSizeFailure = $this->isMailMessageSizeFailure($exception);

                    if ($isSenderConfigurationFailure) {
                        $senderConfigurationFailures++;
                        $stoppedForSenderConfiguration = true;
                    } elseif ($isMessageSizeFailure) {
                        $messageSizeFailures++;
                    } else {
                        $networkFailures++;
                    }

                    if ($isSenderConfigurationFailure || $isMessageSizeFailure) {
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

            if ($networkFailures > 0) {
                $statusMessage .= " {$networkFailures} failed sends were kept due to network/connectivity issues.";
            }

            if ($messageSizeFailures > 0) {
                $statusMessage .= ' Sending stopped because the SMTP provider rejected the message size. Reduce embedded image or attachments.';
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

            $statusMessage = 'Email campaign could not be sent due to a server issue.';

            if ($this->isMailSenderConfigurationFailure($exception)) {
                $statusMessage = 'Email campaign could not be sent because SMTP sender authentication failed. Verify MAIL_USERNAME, MAIL_PASSWORD, and MAIL_FROM_ADDRESS.';
            } elseif ($this->isMailMessageSizeFailure($exception)) {
                $statusMessage = 'Email campaign could not be sent because the SMTP provider rejected the message size. Reduce embedded image or attachments and try again.';
            } elseif ($this->isNetworkConnectivityFailure($exception)) {
                $statusMessage = 'Email campaign could not be sent due to SMTP/network connectivity issues. Check MAIL_HOST, MAIL_PORT, firewall, and internet access.';
            } else {
                $exceptionMessage = trim((string) $exception->getMessage());

                if ($exceptionMessage !== '') {
                    $statusMessage .= ' Error: ' . $exceptionMessage;
                }
            }

            return redirect()
                ->route('admin.newsletters')
                ->with('status', $statusMessage);
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

    public function testNewsletterContactDeliverability(Request $request): RedirectResponse
    {
        $batchSize = max(25, min(1000, (int) config('mail.newsletter_deliverability_batch_size', 300)));
        $maxRuntimeSeconds = max(5, min(120, (int) config('mail.newsletter_deliverability_max_runtime_seconds', 20)));
        $runTtlMinutes = max(10, min(1440, (int) config('mail.newsletter_deliverability_run_ttl_minutes', 180)));
        $startTime = microtime(true);

        $continueRun = $request->boolean('continue_run');
        $runToken = trim((string) $request->input('run_token', ''));

        if ($continueRun && $runToken === '') {
            return redirect()
                ->route('admin.newsletters')
                ->with('status', 'Deliverability run token is missing. Start a new Email Test run.');
        }

        if (! $continueRun) {
            $totalContacts = NewsletterContact::query()->count();

            if ($totalContacts === 0) {
                return redirect()
                    ->route('admin.newsletters')
                    ->with('status', 'No newsletter contacts found to test.');
            }

            $runToken = bin2hex(random_bytes(16));

            $state = [
                'total' => $totalContacts,
                'checked' => 0,
                'removed' => 0,
                'inconclusive' => 0,
                'removed_samples' => [],
                'last_id' => 0,
            ];
        } else {
            $state = Cache::get($this->newsletterDeliverabilityRunCacheKey($runToken));

            if (! is_array($state)) {
                return redirect()
                    ->route('admin.newsletters')
                    ->with('status', 'Previous deliverability run expired. Start Email Test again.');
            }
        }

        $contacts = NewsletterContact::query()
            ->where('id', '>', (int) $state['last_id'])
            ->orderBy('id')
            ->limit($batchSize)
            ->get(['id', 'email']);

        if ($contacts->isEmpty()) {
            Cache::forget($this->newsletterDeliverabilityRunCacheKey($runToken));

            $statusMessage = "Deliverability test completed. Checked {$state['checked']} contacts.";

            if ((int) $state['removed'] === 0) {
                $statusMessage .= ' No contacts were removed.';
            } else {
                $statusMessage .= " Removed {$state['removed']} contacts that failed validation checks.";

                if (count($state['removed_samples']) > 0) {
                    $statusMessage .= ' Sample removals: ' . implode('; ', $state['removed_samples']) . '.';
                }
            }

            if ((int) $state['inconclusive'] > 0) {
                $statusMessage .= " {$state['inconclusive']} contacts returned inconclusive SMTP checks and were kept.";
            }

            return redirect()
                ->route('admin.newsletters')
                ->with('status', $statusMessage);
        }

        $stoppedEarly = false;

        foreach ($contacts as $contact) {
            if ((microtime(true) - $startTime) >= $maxRuntimeSeconds) {
                $stoppedEarly = true;
                break;
            }

            $state['checked']++;
            $state['last_id'] = (int) $contact->id;
            $inconclusive = false;
            $failureReason = $this->getNewsletterDeliverabilityFailureReason((string) $contact->email, $inconclusive);

            if ($inconclusive) {
                $state['inconclusive']++;
            }

            if ($failureReason === null) {
                continue;
            }

            $contact->delete();
            $state['removed']++;

            if (count($state['removed_samples']) < 5) {
                $state['removed_samples'][] = $contact->email . ' (' . $failureReason . ')';
            }
        }

        $remainingExists = NewsletterContact::query()->where('id', '>', (int) $state['last_id'])->exists();

        if ($remainingExists) {
            Cache::put($this->newsletterDeliverabilityRunCacheKey($runToken), $state, now()->addMinutes($runTtlMinutes));

            $remainingCount = max(0, (int) $state['total'] - (int) $state['checked']);
            $statusMessage = "Deliverability batch running. Checked {$state['checked']} of {$state['total']} contacts.";
            $statusMessage .= " Removed {$state['removed']}.";

            if ((int) $state['inconclusive'] > 0) {
                $statusMessage .= " Inconclusive kept: {$state['inconclusive']}.";
            }

            if ($stoppedEarly) {
                $statusMessage .= ' Paused by runtime guard to avoid gateway timeout.';
            }

            $statusMessage .= " {$remainingCount} contacts remaining. Continuing automatically...";

            return redirect()
                ->route('admin.newsletters')
                ->with('status', $statusMessage)
                ->with('deliverability_auto_continue', true)
                ->with('deliverability_run_token', $runToken);
        }

        Cache::forget($this->newsletterDeliverabilityRunCacheKey($runToken));

        $statusMessage = "Deliverability test completed. Checked {$state['checked']} contacts.";

        if ((int) $state['removed'] === 0) {
            $statusMessage .= ' No contacts were removed.';
        } else {
            $statusMessage .= " Removed {$state['removed']} contacts that failed validation checks.";

            if (count($state['removed_samples']) > 0) {
                $statusMessage .= ' Sample removals: ' . implode('; ', $state['removed_samples']) . '.';
            }
        }

        if ((int) $state['inconclusive'] > 0) {
            $statusMessage .= " {$state['inconclusive']} contacts returned inconclusive SMTP checks and were kept.";
        }

        return redirect()
            ->route('admin.newsletters')
            ->with('status', $statusMessage);
    }

    private function newsletterDeliverabilityRunCacheKey(string $runToken): string
    {
        return 'newsletter-deliverability-run:' . $runToken;
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

    private function getNewsletterDeliverabilityFailureReason(string $email, bool &$inconclusive = false): ?string
    {
        $inconclusive = false;
        $normalizedEmail = strtolower(trim($email));

        if (! filter_var($normalizedEmail, FILTER_VALIDATE_EMAIL)) {
            return 'invalid email format';
        }

        [$localPart, $domain] = array_pad(explode('@', $normalizedEmail, 2), 2, '');

        if ($localPart === '' || $domain === '' || ! str_contains($domain, '.')) {
            return 'invalid email domain';
        }

        if ($this->isRoleBasedAddress($localPart)) {
            return 'role-based address';
        }

        if ($this->isDisposableEmailDomain($domain)) {
            return 'disposable email domain';
        }

        if (! $this->hasDeliverableDnsRecords($domain)) {
            return 'domain has no MX/A/AAAA DNS records';
        }

        $activeInboxStatus = $this->checkActiveInboxStatus($normalizedEmail, $domain);

        if ($activeInboxStatus === 'inactive') {
            return 'inactive inbox';
        }

        if ($activeInboxStatus === 'unknown') {
            $inconclusive = true;
        }

        return null;
    }

    private function checkActiveInboxStatus(string $email, string $domain): string
    {
        $activeInboxCheckEnabled = (bool) config('mail.newsletter_active_inbox_check', true);

        if (! $activeInboxCheckEnabled) {
            return 'unknown';
        }

        $mxHosts = [];
        $mxWeights = [];

        if (function_exists('getmxrr')) {
            @getmxrr($domain, $mxHosts, $mxWeights);
        }

        if (count($mxHosts) === 0) {
            return 'unknown';
        }

        $hostEntries = [];

        foreach ($mxHosts as $index => $mxHost) {
            $hostEntries[] = [
                'host' => (string) $mxHost,
                'weight' => (int) ($mxWeights[$index] ?? 0),
            ];
        }

        usort($hostEntries, static fn (array $a, array $b): int => $a['weight'] <=> $b['weight']);

        $timeoutSeconds = max(3, min(15, (int) config('mail.newsletter_smtp_probe_timeout_seconds', 6)));
        $heloHost = (string) (parse_url((string) config('app.url', ''), PHP_URL_HOST) ?: 'localhost');
        $mailFrom = (string) config('mail.from.address', 'mailer@localhost.localdomain');

        if (! filter_var($mailFrom, FILTER_VALIDATE_EMAIL)) {
            $mailFrom = 'mailer@localhost.localdomain';
        }

        $hadUnknown = false;
        $maxHostsToProbe = 3;

        foreach (array_slice($hostEntries, 0, $maxHostsToProbe) as $entry) {
            $probeResult = $this->probeSmtpRecipient($entry['host'], $email, $heloHost, $mailFrom, $timeoutSeconds);

            if ($probeResult === 'active') {
                return 'active';
            }

            if ($probeResult === 'inactive') {
                return 'inactive';
            }

            $hadUnknown = true;
        }

        return $hadUnknown ? 'unknown' : 'active';
    }

    private function probeSmtpRecipient(string $mxHost, string $recipientEmail, string $heloHost, string $mailFrom, int $timeoutSeconds): string
    {
        $socket = @stream_socket_client(
            'tcp://' . $mxHost . ':25',
            $errorNumber,
            $errorMessage,
            $timeoutSeconds,
            STREAM_CLIENT_CONNECT
        );

        if (! is_resource($socket)) {
            return 'unknown';
        }

        stream_set_timeout($socket, $timeoutSeconds);

        try {
            $greetingCode = $this->readSmtpResponseCode($socket);

            if ($greetingCode !== 220) {
                return 'unknown';
            }

            $ehloCode = $this->sendSmtpCommand($socket, 'EHLO ' . $heloHost);

            if ($ehloCode !== 250) {
                $heloCode = $this->sendSmtpCommand($socket, 'HELO ' . $heloHost);

                if ($heloCode !== 250) {
                    return 'unknown';
                }
            }

            $mailCode = $this->sendSmtpCommand($socket, 'MAIL FROM:<' . $mailFrom . '>');

            if (! in_array($mailCode, [250, 251], true)) {
                return 'unknown';
            }

            $rcptCode = $this->sendSmtpCommand($socket, 'RCPT TO:<' . $recipientEmail . '>');

            if (in_array($rcptCode, [250, 251], true)) {
                return 'active';
            }

            if (in_array($rcptCode, [550, 551, 552, 553, 554], true)) {
                return 'inactive';
            }

            return 'unknown';
        } finally {
            @fwrite($socket, "QUIT\r\n");
            @fclose($socket);
        }
    }

    private function sendSmtpCommand($socket, string $command): ?int
    {
        $written = @fwrite($socket, $command . "\r\n");

        if ($written === false) {
            return null;
        }

        return $this->readSmtpResponseCode($socket);
    }

    private function readSmtpResponseCode($socket): ?int
    {
        $lastCode = null;

        for ($i = 0; $i < 30; $i++) {
            $line = @fgets($socket, 512);

            if ($line === false) {
                $meta = stream_get_meta_data($socket);

                if (($meta['timed_out'] ?? false) === true) {
                    return null;
                }

                return $lastCode;
            }

            if (preg_match('/^(\d{3})([\-\s])/', $line, $matches) !== 1) {
                continue;
            }

            $lastCode = (int) $matches[1];

            if ($matches[2] === ' ') {
                return $lastCode;
            }
        }

        return $lastCode;
    }

    private function isRoleBasedAddress(string $localPart): bool
    {
        $rolePrefixes = [
            'admin',
            'support',
            'contact',
            'info',
            'sales',
            'billing',
            'help',
            'team',
            'hello',
            'noreply',
            'no-reply',
            'mailer-daemon',
            'postmaster',
            'abuse',
            'security',
            'webmaster',
        ];

        return in_array(strtolower($localPart), $rolePrefixes, true);
    }

    private function isDisposableEmailDomain(string $domain): bool
    {
        $disposableDomains = [
            'mailinator.com',
            'tempmail.com',
            '10minutemail.com',
            'guerrillamail.com',
            'yopmail.com',
            'trashmail.com',
            'dispostable.com',
            'fakeinbox.com',
            'mintemail.com',
            'throwawaymail.com',
        ];

        $normalizedDomain = strtolower($domain);

        return in_array($normalizedDomain, $disposableDomains, true);
    }

    private function hasDeliverableDnsRecords(string $domain): bool
    {
        $normalizedDomain = strtolower(trim($domain));

        if ($normalizedDomain === '') {
            return false;
        }

        if (function_exists('checkdnsrr') && checkdnsrr($normalizedDomain, 'MX')) {
            return true;
        }

        if (function_exists('getmxrr')) {
            $hosts = [];

            if (getmxrr($normalizedDomain, $hosts) && count($hosts) > 0) {
                return true;
            }
        }

        if (function_exists('checkdnsrr')) {
            if (checkdnsrr($normalizedDomain, 'A') || checkdnsrr($normalizedDomain, 'AAAA')) {
                return true;
            }
        }

        if (function_exists('dns_get_record')) {
            $aRecords = @dns_get_record($normalizedDomain, DNS_A);
            $aaaaRecords = @dns_get_record($normalizedDomain, DNS_AAAA);

            if ((is_array($aRecords) && count($aRecords) > 0) || (is_array($aaaaRecords) && count($aaaaRecords) > 0)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Estimate MIME payload size before SMTP send to avoid provider hard limits.
     *
     * @param array<int, array{name:string,mime:string,data:string}> $attachments
     * @param array{name:string,mime:string,data:string}|null $embeddedImage
     */
    private function estimateNewsletterPayloadBytes(string $title, string $body, array $attachments, ?array $embeddedImage): int
    {
        $bytes = strlen($title) + strlen($body);

        foreach ($attachments as $attachment) {
            $bytes += strlen((string) ($attachment['data'] ?? ''));
        }

        if (is_array($embeddedImage)) {
            $bytes += strlen((string) ($embeddedImage['data'] ?? ''));
        }

        $bytes = (int) ceil($bytes * 1.37);

        return $bytes + 50_000;
    }

    /**
     * Shrink image binary to a target size using GD by converting/resampling to JPEG.
     *
     * @return array{data:string,mime:string}|null
     */
    private function shrinkImageBinaryToMaxBytes(string $binary, int $maxBytes): ?array
    {
        if ($binary === '' || $maxBytes <= 0) {
            return null;
        }

        if (! function_exists('imagecreatefromstring') || ! function_exists('imagejpeg')) {
            return null;
        }

        $sourceImage = @imagecreatefromstring($binary);

        if ($sourceImage === false) {
            return null;
        }

        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        if ($width < 1 || $height < 1) {
            imagedestroy($sourceImage);

            return null;
        }

        $scale = 1.0;
        $quality = 85;
        $bestData = null;

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $targetWidth = max(1, (int) floor($width * $scale));
            $targetHeight = max(1, (int) floor($height * $scale));

            $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

            if ($canvas === false) {
                break;
            }

            // Flatten to white background to preserve readability for transparent PNG/GIF uploads.
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $white);

            imagecopyresampled(
                $canvas,
                $sourceImage,
                0,
                0,
                0,
                0,
                $targetWidth,
                $targetHeight,
                $width,
                $height
            );

            ob_start();
            imagejpeg($canvas, null, $quality);
            $candidate = (string) ob_get_clean();

            imagedestroy($canvas);

            if ($candidate === '') {
                continue;
            }

            if ($bestData === null || strlen($candidate) < strlen($bestData)) {
                $bestData = $candidate;
            }

            if (strlen($candidate) <= $maxBytes) {
                imagedestroy($sourceImage);

                return [
                    'data' => $candidate,
                    'mime' => 'image/jpeg',
                ];
            }

            if ($quality > 45) {
                $quality -= 10;
            } else {
                $scale *= 0.82;
            }
        }

        imagedestroy($sourceImage);

        if ($bestData !== null) {
            return [
                'data' => $bestData,
                'mime' => 'image/jpeg',
            ];
        }

        return null;
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

    private function isMailMessageSizeFailure(Throwable $exception): bool
    {
        $sizeFailureKeywords = [
            'message exceeded max message size',
            'message size exceeds fixed maximum message size',
            '552 5.7.0',
            '552 5.3.4',
            'maximum message size',
            'message too large',
        ];

        $current = $exception;

        while ($current instanceof Throwable) {
            $message = strtolower($current->getMessage());

            foreach ($sizeFailureKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return true;
                }
            }

            $current = $current->getPrevious();
        }

        return false;
    }
}
