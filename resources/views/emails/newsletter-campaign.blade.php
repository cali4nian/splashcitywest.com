<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background:#e9eef5;font-family:'Segoe UI',Arial,Helvetica,sans-serif;color:#0f172a;">
@php
    $isFundraising = $template === 'fundraising';
    $accent = $isFundraising ? '#b91c1c' : '#0b3a75';
    $accentSecondary = $isFundraising ? '#7f1d1d' : '#0f172a';
    $badgeBackground = $isFundraising ? '#fee2e2' : '#dbeafe';
    $badgeText = $isFundraising ? 'Fundraising Update' : 'Program Update';
    $leadText = $isFundraising
        ? 'Every contribution strengthens travel, training, and team development for our athletes.'
        : 'Latest updates from coaching staff, programs, and upcoming events.';
    $ctaText = $isFundraising ? 'Support The Program' : 'See Program Updates';
    $bodyParagraphs = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $body)));
@endphp
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#e9eef5;padding:30px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:720px;background:#ffffff;border:1px solid #d7deea;border-radius:18px;overflow:hidden;box-shadow:0 12px 34px rgba(15,23,42,0.1);">
                <tr>
                    <td style="padding:0;background:{{ $accentSecondary }};" bgcolor="{{ $accentSecondary }}">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:linear-gradient(120deg, {{ $accentSecondary }} 0%, {{ $accent }} 70%);" bgcolor="{{ $accentSecondary }}">
                            <tr>
                                <td style="padding:30px 30px 16px 30px;color:#ffffff;" bgcolor="{{ $accentSecondary }}">
                                    <p style="margin:0;font-size:11px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;opacity:.95;color:#ffffff !important;">Splash City West Basketball</p>
                                    <h1 style="margin:12px 0 0 0;font-size:32px;line-height:1.18;font-weight:800;letter-spacing:-0.01em;color:#ffffff !important;">
                                        <span style="color:#ffffff !important;">{{ $title }}</span>
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 30px 28px 30px;">
                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.24);border-radius:12px;">
                                        <tr>
                                            <td style="padding:12px 14px;color:#ffffff !important;font-size:14px;line-height:1.6;font-weight:500;">
                                                {{ $leadText }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:28px 30px 16px 30px;">
                        <span style="display:inline-block;background:{{ $badgeBackground }};color:{{ $accent }};padding:6px 11px;border-radius:999px;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">
                            {{ $badgeText }}
                        </span>
                        <p style="margin:18px 0 0 0;font-size:17px;line-height:1.55;font-weight:700;color:#0f172a;">Hi {{ $recipientName ?: 'Supporter' }},</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 30px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;">
                            <tr>
                                <td style="padding:18px 18px 6px 18px;">
                                    @forelse ($bodyParagraphs as $paragraph)
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:1.72;color:#1e293b;">{{ $paragraph }}</p>
                                    @empty
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:1.72;color:#1e293b;">{{ $body }}</p>
                                    @endforelse
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:22px 30px 30px 30px;">
                        <a href="{{ config('app.url') }}" style="display:inline-block;background:{{ $accent }};color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:10px;font-size:13px;font-weight:700;letter-spacing:.02em;">
                            {{ $ctaText }}
                        </a>
                        <p style="margin:14px 0 0 0;font-size:13px;line-height:1.6;color:#64748b;">
                            Thank you for staying connected with Splash City West Basketball.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 30px;background:#f1f5f9;border-top:1px solid #dbe3ee;">
                        <p style="margin:0 0 6px 0;font-size:12px;line-height:1.6;color:#334155;font-weight:700;">
                            Splash City West Basketball
                        </p>
                        <p style="margin:0;font-size:12px;line-height:1.6;color:#64748b;">
                            You are receiving this message because your contact is on our communications list.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
