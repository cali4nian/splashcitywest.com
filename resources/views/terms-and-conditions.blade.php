<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Terms and Conditions for the Charles Ross Jr. website.">
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <title>Terms and Conditions | {{ config('app.name', 'Charlie Ross') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f4efe6] text-[#0d2a4a] antialiased">
        <main class="mx-auto w-full max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="rounded-4xl border border-white/60 bg-white/80 p-6 shadow-[0_24px_80px_rgba(18,24,38,0.08)] backdrop-blur sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#f26a0a]">Legal</p>
                        <h1 class="mt-2 text-3xl font-black text-[#0b2340] sm:text-4xl">Terms and Conditions</h1>
                    </div>
                    <a href="{{ route('home') }}" class="rounded-full border border-[#0d2a4a]/20 bg-white px-4 py-2 text-sm font-semibold text-[#0d2a4a] transition hover:border-[#f26a0a]/40 hover:text-[#f26a0a]">
                        Back to Home
                    </a>
                </div>

                <p class="mt-5 text-sm text-[#475569]">Effective Date: {{ now()->format('F j, Y') }}</p>

                <div class="mt-6 space-y-6 text-sm leading-7 text-[#334155]">
                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">1. Acceptance of Terms</h2>
                        <p class="mt-2">
                            By accessing or using this website, you acknowledge and agree to be bound by these Terms and Conditions,
                            all applicable laws, and any additional policies incorporated by reference. If you do not agree, you must
                            discontinue use of the website immediately.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">2. Permitted Use</h2>
                        <p class="mt-2">
                            You may use this website solely for lawful, non-fraudulent, and non-commercially abusive purposes. You agree
                            not to interfere with platform integrity, attempt unauthorized access, transmit malicious code, or engage in
                            conduct that may disrupt website functionality or user safety.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">3. Intellectual Property</h2>
                        <p class="mt-2">
                            Unless otherwise stated, all website content, including text, graphics, branding, layouts, and media assets,
                            is owned by or licensed to Charles Ross Jr. and protected by applicable intellectual property laws. No content
                            may be reproduced, republished, or distributed without prior written authorization.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">4. Third-Party Links and Donations</h2>
                        <p class="mt-2">
                            This website may contain links to third-party services, including payment processors. Access to those services
                            is at your own risk, and third-party terms, privacy policies, and transaction rules apply. We disclaim
                            responsibility for external platform availability, content, or transactional outcomes.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">5. Disclaimer of Warranties</h2>
                        <p class="mt-2">
                            The website is provided on an "as is" and "as available" basis without warranties of any kind, express or
                            implied, including but not limited to merchantability, fitness for a particular purpose, title, and
                            non-infringement. We do not warrant uninterrupted access, error-free operation, or complete security.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">6. Limitation of Liability</h2>
                        <p class="mt-2">
                            To the maximum extent permitted by law, Charles Ross Jr. and affiliated parties shall not be liable for any
                            indirect, incidental, special, consequential, or punitive damages, including data loss, loss of profits,
                            interruption of operations, or reputational harm arising from use of or inability to use this website.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">7. Indemnification</h2>
                        <p class="mt-2">
                            You agree to defend, indemnify, and hold harmless Charles Ross Jr., staff, and representatives from claims,
                            liabilities, costs, and expenses (including reasonable attorneys' fees) arising out of your violation of these
                            terms, misuse of the website, or infringement of any third-party rights.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">8. Governing Law and Venue</h2>
                        <p class="mt-2">
                            These terms shall be governed by and construed in accordance with applicable state and federal laws. Any
                            disputes arising from these terms or website use shall be resolved in a court of competent jurisdiction in
                            the applicable venue unless otherwise required by law.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">9. Modifications to Terms</h2>
                        <p class="mt-2">
                            We reserve the right to modify these Terms and Conditions at any time. Revisions become effective upon
                            posting. Continued use of the website after updates are posted constitutes your acceptance of the revised terms.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-lg font-bold text-[#0b2340]">10. Contact Information</h2>
                        <p class="mt-2">
                            Notices or legal inquiries related to these Terms and Conditions may be delivered through the contact
                            information below.
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
