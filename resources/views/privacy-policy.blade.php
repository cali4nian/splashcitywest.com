<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Privacy Policy for the Charles Ross Jr. website.">
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <title>Privacy Policy | {{ config('app.name', 'Charlie Ross') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f4efe6] text-[#0d2a4a] antialiased">
        <main class="mx-auto w-full max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="rounded-4xl border border-white/60 bg-white/80 p-6 shadow-[0_24px_80px_rgba(18,24,38,0.08)] backdrop-blur sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#f26a0a]">Legal</p>
                        <h1 class="mt-2 text-3xl font-black text-[#0b2340] sm:text-4xl">Privacy Policy</h1>
                    </div>
                    <a href="{{ route('home') }}" class="rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]">
                        Back to Home
                    </a>
                </div>

                <p class="mt-5 text-sm text-[#475569]">Effective Date: {{ now()->format('F j, Y') }}</p>

                <div class="mt-6 space-y-6 text-sm leading-7 text-[#334155]">
                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">1. Scope of This Policy</h2>
                        <p class="mt-2">
                            This Privacy Policy describes how Charles Ross Jr. and affiliated program operations ("we," "our," or "us")
                            collect, use, disclose, and safeguard personal information when you access or interact with this website,
                            including related landing pages, donation resources, communications forms, and publicly posted content.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">2. Information We Collect</h2>
                        <p class="mt-2">We may collect the following categories of information:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            <li>Contact information, including name, email address, and phone number you voluntarily provide.</li>
                            <li>Transaction-related metadata when you use third-party donation processors linked from this website.</li>
                            <li>Technical information such as IP address, browser type, device identifiers, and usage logs.</li>
                            <li>Communications content you submit through inquiries, outreach, or staff correspondence.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">3. Lawful Basis and Use of Data</h2>
                        <p class="mt-2">
                            We process personal data for legitimate interests, performance of requested services, compliance obligations,
                            and, where applicable, user consent. Typical uses include responding to inquiries, administering programs,
                            improving website operations, monitoring abuse, and maintaining organizational records.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">4. Third-Party Services and Donation Providers</h2>
                        <p class="mt-2">
                            Donation links may direct users to third-party payment platforms (for example, PayPal, Cash App, or Stripe).
                            We do not control third-party privacy practices and are not responsible for external policies, security controls,
                            or processing activities performed outside this website. Users should review each provider's legal terms and
                            privacy disclosures before submitting payment information.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">5. Data Retention and Security</h2>
                        <p class="mt-2">
                            We retain personal information only as long as reasonably necessary for operational, legal, or administrative
                            purposes. Reasonable technical and organizational safeguards are implemented to reduce unauthorized access,
                            disclosure, alteration, or destruction; however, no networked system can be guaranteed fully secure.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">6. Cookies and Analytics</h2>
                        <p class="mt-2">
                            This website may use cookies or similar technologies to maintain session integrity, improve usability,
                            and evaluate aggregated traffic patterns. You may adjust browser settings to reject cookies, but certain
                            website features may not function as intended.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">7. User Rights</h2>
                        <p class="mt-2">
                            Subject to applicable law, you may request access, correction, deletion, or restriction of personal data,
                            and may object to certain processing activities. Requests may be submitted using the contact information
                            made available through the website.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">8. Children's Information</h2>
                        <p class="mt-2">
                            This website is intended for a general audience and does not knowingly collect personal information from
                            children in violation of applicable law. If you believe information was submitted improperly, please contact us
                            so the matter can be reviewed and addressed.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">9. Policy Updates</h2>
                        <p class="mt-2">
                            We may revise this Privacy Policy from time to time. Material updates will be reflected by the effective date
                            shown above, and continued use of the website after changes are posted constitutes acknowledgment of the
                            revised policy.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">10. Contact Information</h2>
                        <p class="mt-2">
                            Questions, requests, or notices related to this Privacy Policy may be submitted using the following contact
                            channels.
                        </p>
                        <div class="mt-3 rounded-2xl border border-[#0d2a4a]/10 bg-white/70 p-4">
                            <p>
                                Phone:
                                <a href="{{ $phoneHref }}" class="font-semibold text-[#0d2a4a] hover:text-[#f26a0a]">{{ $contactPhone }}</a>
                            </p>
                            <p class="mt-1">
                                Email:
                                <a href="{{ $emailHref }}" class="font-semibold text-[#0d2a4a] hover:text-[#f26a0a]">{{ $contactEmail }}</a>
                            </p>
                        </div>
                    </section>
                </div>

                <footer class="mt-8 border-t border-[#0d2a4a]/10 pt-4 text-sm text-[#475569]">
                    <p>&copy; {{ now()->year }} Charles Ross Jr. All rights reserved.</p>
                </footer>
            </section>
        </main>
    </body>
</html>
