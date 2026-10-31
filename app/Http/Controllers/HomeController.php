<?php

namespace App\Http\Controllers;

use App\Models\DonationLink;
use App\Models\HighlightLink;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\StaffMember;
use App\Models\Update;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $updates = Update::publicUpdates();

        $programs = array_values(array_filter($updates, static function (array $update): bool {
            return $update['category'] === Update::CATEGORY_PROGRAM;
        }));

        $settings = SiteSetting::values(
            ['contact_phone', 'contact_email', 'college_commitments', 'programs_represented'],
            [
                'contact_phone' => '323 383 3758',
                'contact_email' => 'charles.ross@fresnounified.org',
                'college_commitments' => 10,
                'programs_represented' => count($programs),
            ]
        );

        $contactPhone = $settings['contact_phone'];
        $contactEmail = $settings['contact_email'];
        $collegeCommitments = (int) $settings['college_commitments'];
        $programsRepresented = (int) ($settings['programs_represented'] ?? count($programs));

        $phoneDigits = preg_replace('/\D+/', '', $contactPhone);
        $phoneHref = $phoneDigits !== '' ? 'tel:+' . $phoneDigits : '#';
        $emailHref = $contactEmail !== '' ? 'mailto:' . $contactEmail : '#';

        $mediaCards = [
            [
                'title' => 'Head Coach',
                'subtitle' => 'Head coach profile image.',
                'image' => asset('images/coachRoss1.png'),
            ],
            [
                'title' => 'Splash City West',
                'subtitle' => 'Splash City West program image.',
                'image' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'title' => 'Roosevelt High School',
                'subtitle' => 'Roosevelt High School program image.',
                'image' => asset('images/coachRoss1.png'),
            ],
        ];

        $programCards = array_map(static function (array $program): array {
            return [
                'title' => $program['title'],
                'subtitle' => $program['subtitle'] ?: 'Program image.',
                'image' => $program['image_url'],
            ];
        }, $programs);

        return view('home', [
            'donations' => DonationLink::publicLinks(),
            'mediaCards' => $mediaCards,
            'headCoach' => $mediaCards[0],
            'programs' => $programs,
            'programCards' => $programCards,
            'featuredPrograms' => array_slice($programs, 0, 2),
            'updates' => $updates,
            'highlightLinks' => HighlightLink::publicLinks(),
            'contactPhone' => $contactPhone,
            'contactEmail' => $contactEmail,
            'collegeCommitments' => $collegeCommitments,
            'programsRepresented' => $programsRepresented,
            'phoneHref' => $phoneHref,
            'emailHref' => $emailHref,
            'contactInfo' => [
                ['label' => 'Phone', 'value' => $contactPhone, 'href' => $phoneHref],
                ['label' => 'Email', 'value' => $contactEmail, 'href' => $emailHref],
            ],
            'socialLinks' => SocialLink::publicLinks(),
            'staffMembers' => StaffMember::publicMembers(),
        ]);
    }
}
