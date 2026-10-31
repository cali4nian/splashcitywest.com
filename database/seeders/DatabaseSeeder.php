<?php

namespace Database\Seeders;

use App\Models\DonationLink;
use App\Models\HighlightLink;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\SiteEvent;
use App\Models\StaffMember;
use App\Models\SuccessStory;
use App\Models\SocialLink;
use App\Models\Update;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'contact_phone'],
            ['value' => '323 383 3758'],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'contact_email'],
            ['value' => 'charles.ross@fresnounified.org'],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'college_commitments'],
            ['value' => '10'],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'programs_represented'],
            ['value' => '2'],
        );

        Program::query()->updateOrCreate(
            ['name' => 'Splash City West'],
            [
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
            ],
        );

        Program::query()->updateOrCreate(
            ['name' => 'Roosevelt High School'],
            [
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
            ],
        );

        SocialLink::query()->updateOrCreate(
            ['url' => 'https://www.instagram.com/splash_city_west/'],
            [
                'platform' => 'Instagram',
                'handle' => '@splash_city_west',
            ],
        );

        SocialLink::query()->updateOrCreate(
            ['url' => 'https://www.instagram.com/charles559209f/'],
            [
                'platform' => 'Instagram',
                'handle' => '@charles559209f',
            ],
        );

        SiteEvent::query()->updateOrCreate(
            ['title' => 'Splash City West Open Gym'],
            [
                'event_date' => 'Jul 18, 2026',
                'details' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
            ],
        );

        SiteEvent::query()->updateOrCreate(
            ['title' => 'Parent and Player Meeting'],
            [
                'event_date' => 'Jul 25, 2026',
                'details' => 'Team expectations, travel plans, and fundraiser goals at 5:30 PM',
            ],
        );

        SiteEvent::query()->updateOrCreate(
            ['title' => 'Roosevelt Skills Session'],
            [
                'event_date' => 'Aug 2, 2026',
                'details' => 'Ball handling, shooting reps, and defensive stations at 9:00 AM',
            ],
        );

        SuccessStory::query()->updateOrCreate(
            ['name' => 'Jalen M.'],
            [
                'title' => 'Earned a college roster spot',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
            ],
        );

        SuccessStory::query()->updateOrCreate(
            ['name' => 'Marcus T.'],
            [
                'title' => 'Team captain leadership growth',
                'description' => 'Led summer workouts and helped raise attendance standards for younger players.',
            ],
        );

        SuccessStory::query()->updateOrCreate(
            ['name' => 'Isaiah R.'],
            [
                'title' => 'All-tournament recognition',
                'description' => 'Turned defensive effort into impact plays and became a trusted closer in games.',
            ],
        );

        Update::query()->updateOrCreate(
            ['category' => Update::CATEGORY_PROGRAM, 'title' => 'Splash City West'],
            [
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
                'sort_order' => 0,
            ],
        );

        Update::query()->updateOrCreate(
            ['category' => Update::CATEGORY_PROGRAM, 'title' => 'Roosevelt High School'],
            [
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
                'sort_order' => 1,
            ],
        );

        Update::query()->updateOrCreate(
            ['category' => Update::CATEGORY_EVENT, 'title' => 'Splash City West Open Gym'],
            [
                'subtitle' => 'Jul 18, 2026',
                'description' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
                'sort_order' => 2,
            ],
        );

        Update::query()->updateOrCreate(
            ['category' => Update::CATEGORY_EVENT, 'title' => 'Parent and Player Meeting'],
            [
                'subtitle' => 'Jul 25, 2026',
                'description' => 'Team expectations, travel plans, and fundraiser goals at 5:30 PM',
                'sort_order' => 3,
            ],
        );

        Update::query()->updateOrCreate(
            ['category' => Update::CATEGORY_SUCCESS_STORY, 'title' => 'Earned a college roster spot'],
            [
                'subtitle' => 'Jalen M.',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
                'sort_order' => 4,
            ],
        );

        HighlightLink::query()->updateOrCreate(
            ['url' => 'https://www.youtube.com/watch?v=j_C7i5hVnbw'],
            ['title' => 'Splash City West Highlight Reel'],
        );

        HighlightLink::query()->updateOrCreate(
            ['url' => 'https://www.youtube.com/shorts/j_C7i5hVnbw'],
            ['title' => 'Roosevelt Skills Session'],
        );

        HighlightLink::query()->updateOrCreate(
            ['url' => 'https://youtu.be/j_C7i5hVnbw'],
            ['title' => 'Game Day Highlights'],
        );

        DonationLink::query()->updateOrCreate(
            ['name' => 'PayPal'],
            [
                'label' => 'Fast, familiar support',
                'url' => null,
            ],
        );

        DonationLink::query()->updateOrCreate(
            ['name' => 'Cash App'],
            [
                'label' => 'Simple cash donations',
                'url' => null,
            ],
        );

        DonationLink::query()->updateOrCreate(
            ['name' => 'Stripe'],
            [
                'label' => 'Credit card checkout',
                'url' => null,
            ],
        );

        StaffMember::query()->updateOrCreate(
            ['email' => 'charles.ross@fresnounified.org'],
            [
                'name' => 'Charles Ross',
                'position' => 'Head Coach',
            ],
        );
    }
}
