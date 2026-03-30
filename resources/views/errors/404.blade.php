<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Not Found</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 px-4 py-8 text-slate-900 md:px-6 md:py-12">
        <main class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center">
            <section class="w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.35)] backdrop-blur">
                <div class="grid gap-8 px-6 py-8 md:px-10 md:py-10 lg:grid-cols-[1.1fr,0.9fr]">
                    <div>
                        <p class="app-eyebrow">404 Error</p>
                        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl">Page not found.</h1>
                        <p class="mt-5 text-[16px] leading-8 text-slate-600">
                            The page you tried to open does not exist, may have moved, or the link may be incorrect.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <a href="{{ $homeUrl }}" class="app-btn-accent">Go Home</a>
                            <a href="{{ route('home') }}" class="app-link">Open Main Page</a>
                        </div>
                    </div>

                    <aside class="rounded-[2rem] bg-[linear-gradient(160deg,_#022c22,_#065f46_45%,_#ecfeff)] p-6 text-white md:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100">KMM JAPANESE</p>
                        <h2 class="mt-4 text-2xl font-semibold">We could not find that page.</h2>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-50">Try this</p>
                                <p class="mt-2 text-sm leading-7 text-emerald-50/90">Check the URL spelling and try again.</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-50">Or continue</p>
                                <p class="mt-2 text-sm leading-7 text-emerald-50/90">Go back to the study pages and open a valid lesson, kanji, or flashcard route.</p>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </main>
    </body>
</html>
