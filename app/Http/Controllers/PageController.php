<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class PageController extends Controller
{
    private function contactData(): array
    {
        $settings = SiteSetting::values(
            ['contact_phone', 'contact_email'],
            [
                'contact_phone' => '323 383 3758',
                'contact_email' => 'charles.ross@fresnounified.org',
            ]
        );

        $contactPhone = $settings['contact_phone'];
        $contactEmail = $settings['contact_email'];
        $phoneDigits = preg_replace('/\D+/', '', $contactPhone);

        return [
            'contactPhone' => $contactPhone,
            'contactEmail' => $contactEmail,
            'phoneHref' => $phoneDigits !== '' ? 'tel:+' . $phoneDigits : '#',
            'emailHref' => $contactEmail !== '' ? 'mailto:' . $contactEmail : '#',
        ];
    }

    public function privacyPolicy(): View
    {
        return view('privacy-policy', $this->contactData());
    }

    public function termsAndConditions(): View
    {
        return view('terms-and-conditions', $this->contactData());
    }
}
