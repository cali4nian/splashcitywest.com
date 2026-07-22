<?php

namespace App\Http\Controllers;

use App\Models\DonationLink;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\SiteEvent;
use App\Models\StaffMember;
use App\Models\SuccessStory;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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

        return compact('settings', 'programs', 'socialLinks', 'events', 'successStories', 'donationLinks', 'staffMembers');
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
}
