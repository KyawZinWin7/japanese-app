<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen px-3 pt-2 pb-4 text-slate-900 sm:px-4 sm:pt-3 sm:pb-6 md:px-6 md:pt-4 md:pb-12">
        @php
            $appData = [
                'component' => $pageComponent,
                'props' => array_merge($pageProps, [
                    '_shared' => [
                        'locale' => app()->getLocale(),
                    ],
                ]),
            ];
        @endphp

        <div class="mx-auto mb-3 flex w-full max-w-6xl justify-end sm:mb-4">
            <form action="{{ route('locale.update') }}" method="POST" class="inline-flex items-center gap-1 rounded-2xl border border-white/70 bg-white/90 p-1 shadow-sm backdrop-blur">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                <span class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ __('frontend.locale.label') }}</span>
                <button type="submit" name="locale" value="en" class="rounded-xl px-3 py-2 text-sm font-semibold transition {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">{{ __('frontend.locale.english') }}</button>
                <button type="submit" name="locale" value="my" class="rounded-xl px-3 py-2 text-sm font-semibold transition {{ app()->getLocale() === 'my' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">{{ __('frontend.locale.myanmar') }}</button>
            </form>
        </div>

        @auth
            <header class="app-nav-shell">
                <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('study.home') }}" class="app-brand">
                    <img src="{{ asset('images/kmm.png') }}" alt="KMM JAPANESE logo" class="app-brand-logo">
                    <span class="app-brand-text">
                        <span class="app-brand-name">KMM JAPANESE</span>
                        <span class="app-brand-subtitle">Japanese learning platform</span>
                    </span>
                </a>

                <nav class="app-nav-links" aria-label="Primary">
                    <a href="{{ route('study.home') }}" class="app-nav-link">{{ __('frontend.nav.study') }}</a>
                    <a href="{{ route('levels.index') }}" class="app-nav-link">{{ __('frontend.nav.levels') }}</a>
                    <a href="{{ route('lessons.index') }}" class="app-nav-link">{{ __('frontend.nav.lessons') }}</a>
                    <a href="{{ route('vocabulary.index') }}" class="app-nav-link">{{ __('frontend.nav.vocabulary') }}</a>
                    <a href="{{ route('kanji.index') }}" class="app-nav-link">{{ __('frontend.nav.kanji') }}</a>
                    <a href="{{ route('flashcards.index') }}" class="app-nav-link">{{ __('frontend.nav.flashcards') }}</a>
                </nav>

                <div class="app-nav-actions">
                    <a href="{{ route('study.home') }}" class="app-btn-secondary lg:hidden">{{ __('frontend.nav.study') }}</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="app-btn-secondary">{{ __('frontend.nav.logout') }}</button>
                    </form>
                </div>

                <div class="app-mobile-menu">
                    <button type="button" class="app-mobile-menu-button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-nav-panel" data-mobile-menu-toggle>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <div id="mobile-nav-panel" class="app-mobile-menu-panel" data-mobile-menu-panel hidden>
                        <nav class="app-mobile-menu-links" aria-label="Mobile Primary">
                            <a href="{{ route('study.home') }}" class="app-mobile-menu-link">{{ __('frontend.nav.study') }}</a>
                            <a href="{{ route('levels.index') }}" class="app-mobile-menu-link">{{ __('frontend.nav.levels') }}</a>
                            <a href="{{ route('lessons.index') }}" class="app-mobile-menu-link">{{ __('frontend.nav.lessons') }}</a>
                            <a href="{{ route('vocabulary.index') }}" class="app-mobile-menu-link">{{ __('frontend.nav.vocabulary') }}</a>
                            <a href="{{ route('kanji.index') }}" class="app-mobile-menu-link">{{ __('frontend.nav.kanji') }}</a>
                            <a href="{{ route('flashcards.index') }}" class="app-mobile-menu-link">{{ __('frontend.nav.flashcards') }}</a>
                        </nav>

                        <div class="app-mobile-menu-footer">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="app-btn-secondary app-mobile-menu-logout">{{ __('frontend.nav.logout') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
        @endauth
        <div id="app"></div>
        <script>
            window.__APP_LOCALE__ = @json(app()->getLocale());
        </script>
        <script id="app-data" type="application/json">@json($appData)</script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggle = document.querySelector('[data-mobile-menu-toggle]');
                const panel = document.querySelector('[data-mobile-menu-panel]');

                if (!toggle || !panel) {
                    return;
                }

                const closeMenu = () => {
                    panel.hidden = true;
                    toggle.setAttribute('aria-expanded', 'false');
                };

                const openMenu = () => {
                    panel.hidden = false;
                    toggle.setAttribute('aria-expanded', 'true');
                };

                toggle.addEventListener('click', () => {
                    if (panel.hidden) {
                        openMenu();
                    } else {
                        closeMenu();
                    }
                });

                document.addEventListener('click', (event) => {
                    if (!panel.hidden && !event.target.closest('.app-mobile-menu')) {
                        closeMenu();
                    }
                });

                panel.querySelectorAll('a, button').forEach((element) => {
                    element.addEventListener('click', closeMenu);
                });
            });
        </script>
    </body>
</html>