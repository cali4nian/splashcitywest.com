<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background:#edf2f7;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
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
@endphp
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#edf2f7;padding:28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:700px;background:#ffffff;border:1px solid #d1d9e6;border-radius:16px;overflow:hidden;box-shadow:0 10px 26px rgba(15,23,42,0.08);">
                <tr>
                    <td style="padding:0;background:{{ $accentSecondary }};">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:linear-gradient(120deg, {{ $accentSecondary }} 0%, {{ $accent }} 70%);">
                            <tr>
                                <td style="padding:26px 26px 18px 26px;color:#ffffff;">
                                    <p style="margin:0;font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;opacity:.92;">Splash City West Basketball</p>
                                    <h1 style="margin:10px 0 0 0;font-size:30px;line-height:1.15;font-weight:800;">{{ $title }}</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 26px 24px 26px;">
                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.22);border-radius:12px;">
                                        <tr>
                                            <td style="padding:12px 14px;color:#ffffff;font-size:14px;line-height:1.5;">
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
                    <td style="padding:24px 26px 12px 26px;">
                        <span style="display:inline-block;background:{{ $badgeBackground }};color:{{ $accent }};padding:6px 11px;border-radius:999px;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">
                            {{ $badgeText }}
                        </span>
                        <p style="margin:16px 0 0 0;font-size:16px;line-height:1.6;font-weight:600;">Hi {{ $recipientName ?: 'Supporter' }},</p>
                        <div style="margin-top:12px;font-size:15px;line-height:1.75;color:#1e293b;">
                            {!! nl2br(e($body)) !!}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px 26px 24px 26px;">
                        <a href="{{ config('app.url') }}" style="display:inline-block;background:{{ $accent }};color:#ffffff;text-decoration:none;padding:11px 16px;border-radius:10px;font-size:13px;font-weight:700;letter-spacing:.02em;">
                            {{ $ctaText }}
                        </a>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 26px;background:#f8fafc;border-top:1px solid #e2e8f0;">
                        <p style="margin:0 0 6px 0;font-size:12px;line-height:1.6;color:#334155;font-weight:600;">
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
