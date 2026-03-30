<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Access Denied</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 px-4 py-8 text-slate-900 md:px-6 md:py-12">
        <main class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center">
            <section class="w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.35)] backdrop-blur">
                <div class="grid gap-8 px-6 py-8 md:px-10 md:py-10 lg:grid-cols-[1.1fr,0.9fr]">
                    <div>
                        <p class="app-eyebrow">403 Error</p>
                        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl">You do not have access.</h1>
                        <p class="mt-5 text-[16px] leading-8 text-slate-600">
                            This page is not available for your current account or permission level.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <a href="{{ $homeUrl }}" class="app-btn-accent">Go Home</a>
                            <a href="{{ route('home') }}" class="app-link">Open Main Page</a>
                        </div>
                    </div>

                    <aside class="rounded-[2rem] bg-[linear-gradient(160deg,_#0f172a,_#1e293b_45%,_#e2e8f0)] p-6 text-white md:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">KMM JAPANESE</p>
                        <h2 class="mt-4 text-2xl font-semibold">Access is restricted here.</h2>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-100">Possible reason</p>
                                <p class="mt-2 text-sm leading-7 text-slate-100/90">This route may be for admins only, or the resource may not be available to your account.</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-100">Next step</p>
                                <p class="mt-2 text-sm leading-7 text-slate-100/90">Return to your study home and continue from a page that is available to you.</p>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </main>
    </body>
</html>
