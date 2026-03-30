<template>
    <main class="mx-auto w-full max-w-6xl space-y-8">
        <section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.35)] backdrop-blur">
            <div class="grid gap-8 px-6 py-6 md:px-8 lg:grid-cols-[1.15fr,0.85fr] lg:px-10 lg:py-10">
                <div class="space-y-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-700">
                            KMM JAPANESE
                        </span>
                        <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-600">
                            {{ text.webApp }}
                        </span>
                    </div>

                    <div>
                        <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl lg:text-6xl">
                            {{ text.heroTitle }}
                        </h1>
                        <p class="mt-5 max-w-2xl text-[16px] leading-8 text-slate-600 md:text-lg">
                            {{ text.heroText }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a :href="viewer.isAuthenticated ? routes.accountHome : routes.register" class="app-btn-accent">
                            {{ viewer.isAuthenticated ? text.openMyPage : common.register }}
                        </a>
                        <a :href="routes.login" class="app-btn-secondary">{{ common.login }}</a>
                        <a :href="viewer.isAuthenticated ? routes.accountHome : routes.login" class="app-link text-base">
                            {{ viewer.isAuthenticated ? text.continue : text.alreadyAccount }}
                        </a>
                    </div>

                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-slate-200/80 bg-slate-50/85 p-5">
                            <dt class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ text.levels }}</dt>
                            <dd class="mt-3 text-3xl font-semibold text-slate-950">N5-N1</dd>
                            <p class="mt-2 text-sm text-slate-600">{{ text.levelsText }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200/80 bg-slate-50/85 p-5">
                            <dt class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ text.practice }}</dt>
                            <dd class="mt-3 text-3xl font-semibold text-slate-950">Kanji</dd>
                            <p class="mt-2 text-sm text-slate-600">{{ text.practiceText }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200/80 bg-slate-50/85 p-5">
                            <dt class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ text.access }}</dt>
                            <dd class="mt-3 text-3xl font-semibold text-slate-950">{{ text.approved }}</dd>
                            <p class="mt-2 text-sm text-slate-600">{{ text.accessText }}</p>
                        </div>
                    </dl>
                </div>

                <aside class="rounded-[2rem] bg-[linear-gradient(160deg,_#022c22,_#065f46_45%,_#ecfeff)] p-6 text-white shadow-inner md:p-8">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100">{{ text.today }}</p>
                            <h2 class="mt-3 text-2xl font-semibold">{{ text.guidedTitle }}</h2>
                        </div>
                        <div class="rounded-3xl bg-white/12 px-4 py-3 text-right backdrop-blur">
                            <p class="text-xs uppercase tracking-[0.24em] text-emerald-100">{{ text.focus }}</p>
                            <p class="mt-2 text-2xl font-semibold">{{ text.learnByLevel }}</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-50">{{ text.step1 }}</p>
                            <p class="mt-3 text-base leading-8 text-emerald-50/90">{{ text.step1Text }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-50">{{ text.step2 }}</p>
                            <p class="mt-3 text-base leading-8 text-emerald-50/90">{{ text.step2Text }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-50">{{ text.step3 }}</p>
                            <p class="mt-3 text-base leading-8 text-emerald-50/90">{{ text.step3Text }}</p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <article class="content-card">
                <p class="app-badge">JLPT</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ text.levels }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.jlptText }}</p>
            </article>
            <article class="content-card">
                <p class="app-badge">{{ text.read }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.lessons }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.lessonsText }}</p>
            </article>
            <article class="content-card">
                <p class="app-badge">{{ text.words }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.vocabulary }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.vocabularyText }}</p>
            </article>
            <article class="content-card">
                <p class="app-badge">{{ text.practice }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.kanji }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.kanjiText }}</p>
            </article>
        </section>
    </main>
</template>

<script setup>
import { computed } from 'vue';
import { getLocale } from '../frontendI18n';

const props = defineProps({
    routes: { type: Object, required: true },
    viewer: { type: Object, required: true },
});

const copy = {
    en: {
        common: {
            login: 'Login',
            register: 'Register',
        },
        sectionTitles: {
            lessons: 'Lessons',
            vocabulary: 'Vocabulary',
            kanji: 'Kanji',
        },
        home: {
            webApp: 'Japanese Learning Web App',
            heroTitle: 'Learn Japanese in a clean web app with lessons, kanji, vocabulary, quizzes, and flashcards.',
            heroText: 'KMM JAPANESE gives learners a simple study flow, while admins can approve learners and control JLPT access.',
            openMyPage: 'Open My Page',
            continue: 'Continue',
            alreadyAccount: 'I already have an account',
            levels: 'Levels',
            levelsText: 'Admins can assign the correct JLPT path for each learner.',
            practice: 'Practice',
            practiceText: 'Study readings, meanings, examples, quizzes, and flashcards.',
            access: 'Access',
            approved: 'Approved',
            accessText: 'Registered learners are approved by an admin before study access starts.',
            today: 'Today With KMM',
            guidedTitle: 'A guided study flow for real learners',
            focus: 'Focus',
            learnByLevel: 'Learn by level',
            step1: '1. Register',
            step1Text: 'Create your learner account with your basic information.',
            step2: '2. Get approved',
            step2Text: 'An admin accepts your registration and assigns your JLPT levels.',
            step3: '3. Start learning',
            step3Text: 'Open your study home, lessons, vocabulary, kanji, flashcards, and quizzes.',
            jlptText: 'Each learner sees the levels the admin approved for them.',
            lessonsText: 'Open structured lesson pages with a simple reading layout.',
            vocabularyText: 'Study words, readings, meanings, and examples in one place.',
            kanjiText: 'Review kanji details, flashcards, and quizzes after approval.',
            words: 'Words',
            read: 'Read',
        },
    },
    my: {
        common: {
            login: '\u101c\u1031\u102c\u1037\u1002\u103a\u1021\u1004\u103a',
            register: '\u1005\u102c\u101b\u1004\u103a\u1038\u101e\u103d\u1004\u103a\u1038\u1019\u100a\u103a',
        },
        sectionTitles: {
            lessons: '\u101e\u1004\u103a\u1001\u1014\u103a\u1038\u1005\u102c\u1019\u103b\u102c\u1038',
            vocabulary: '\u101d\u1031\u102b\u101f\u102c\u101b\u1019\u103b\u102c\u1038',
            kanji: '\u1001\u1014\u103a\u1002\u103b\u102e',
        },
        home: {
            webApp: '\u1002\u103b\u1015\u1014\u103a\u1005\u102c \u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 Web App',
            heroTitle: '\u101e\u1004\u103a\u1001\u1014\u103a\u1038\u1005\u102c\u1019\u103b\u102c\u1038\u104a kanji\u104a \u101d\u1031\u102b\u101f\u102c\u101b\u1019\u103b\u102c\u1038\u104a quizzes \u1014\u103e\u1004\u1037\u103a flashcards \u1019\u103b\u102c\u1038\u1015\u102b\u101d\u1004\u103a\u101e\u1031\u102c \u101e\u1014\u1037\u103a\u101b\u103e\u1004\u103a\u1038\u101c\u103d\u101a\u103a\u1000\u1030\u101e\u100a\u1037\u103a web app \u1016\u103c\u1004\u1037\u103a \u1002\u103b\u1015\u1014\u103a\u1005\u102c\u101c\u1031\u1037\u101c\u102c\u1015\u102b\u104b',
            heroText: 'KMM JAPANESE \u101e\u100a\u103a learner \u1019\u103b\u102c\u1038\u1021\u1010\u103d\u1000\u103a \u101c\u103d\u101a\u103a\u1000\u1030\u101e\u1031\u102c study flow \u1000\u102d\u102f\u1015\u1031\u1038\u1015\u103c\u102e\u1038 admin \u1019\u103b\u102c\u1038\u1000 learner approval \u1014\u103e\u1004\u1037\u103a JLPT access \u1000\u102d\u102f \u1005\u102e\u1019\u1036\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            openMyPage: '\u1000\u103b\u103d\u1014\u103a\u102f\u1015\u103a\u104f\u1005\u102c\u1019\u103b\u1000\u103a\u1014\u103e\u102c \u1016\u103d\u1004\u1037\u103a\u1019\u100a\u103a',
            continue: '\u1006\u1000\u103a\u101e\u103d\u102c\u1038\u1019\u100a\u103a',
            alreadyAccount: '\u1021\u1000\u1031\u102c\u1004\u1037\u103a\u101b\u103e\u102d\u1015\u103c\u102e\u1038\u101e\u102c\u1038',
            levels: '\u1021\u1006\u1004\u1037\u103a\u1019\u103b\u102c\u1038',
            levelsText: 'Learner \u1010\u1005\u103a\u101a\u1031\u102c\u1000\u103a\u1001\u103b\u1004\u103a\u1038\u1021\u1010\u103d\u1000\u103a \u101e\u1004\u1037\u103a\u1010\u1031\u102c\u103a\u101e\u1031\u102c JLPT \u101c\u1019\u103a\u1038\u1000\u103c\u1031\u102c\u1004\u103a\u1038\u1000\u102d\u102f admin \u1000 \u101e\u1010\u103a\u1019\u103e\u1010\u103a\u1015\u1031\u1038\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            practice: '\u101c\u1031\u1037\u1000\u103b\u1004\u1037\u103a\u1019\u103e\u102f',
            practiceText: 'Reading\u104a meaning\u104a example\u104a quiz \u1014\u103e\u1004\u1037\u103a flashcard \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            access: '\u1021\u101e\u102f\u1036\u1038\u1015\u103c\u102f\u1001\u103d\u1004\u1037\u103a',
            approved: '\u1021\u1010\u100a\u103a\u1015\u103c\u102f\u1015\u103c\u102e\u1038',
            accessText: '\u1005\u102c\u101b\u1004\u103a\u1038\u101e\u103d\u1004\u103a\u1038\u1011\u102c\u1038\u101e\u1031\u102c learner \u1019\u103b\u102c\u1038\u1000\u102d\u102f admin \u1000 \u1021\u1010\u100a\u103a\u1015\u103c\u102f\u1015\u103c\u102e\u1038\u1019\u103e study access \u1005\u1010\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            today: '\u101a\u1014\u1031\u1037 KMM \u1014\u103e\u1004\u1037\u103a',
            guidedTitle: '\u1010\u1000\u101a\u1037\u103a learner \u1019\u103b\u102c\u1038\u1021\u1010\u103d\u1000\u103a \u101c\u1019\u103a\u1038\u100a\u103d\u103e\u1014\u103a\u1011\u102c\u1038\u101e\u1031\u102c study flow',
            focus: '\u1021\u1013\u102d\u1000\u1011\u102c\u1038',
            learnByLevel: 'Level \u1021\u101c\u102d\u102f\u1000\u103a \u101c\u1031\u1037\u101c\u102c\u1015\u102b',
            step1: '\u1041\u104b \u1005\u102c\u101b\u1004\u103a\u1038\u101e\u103d\u1004\u103a\u1038\u1015\u102b',
            step1Text: '\u1021\u1001\u103c\u1031\u1001\u1036\u1021\u1001\u103b\u1000\u103a\u1021\u101c\u1000\u103a\u1019\u103b\u102c\u1038\u1016\u103c\u1004\u1037\u103a learner account \u1010\u1005\u103a\u1001\u102f \u1016\u1014\u103a\u1010\u102e\u1038\u1015\u102b\u104b',
            step2: '\u1042\u104b \u1021\u1010\u100a\u103a\u1015\u103c\u102f\u1001\u103b\u1000\u103a\u101b\u101a\u1030\u1015\u102b',
            step2Text: 'Admin \u1000 registration \u1000\u102d\u102f \u101c\u1000\u103a\u1001\u1036\u1015\u103c\u102e\u1038 JLPT levels \u1019\u103b\u102c\u1038 \u101e\u1010\u103a\u1019\u103e\u1010\u103a\u1015\u1031\u1038\u1015\u102b\u101e\u100a\u103a\u104b',
            step3: '\u1043\u104b \u1005\u1010\u1004\u103a\u101c\u1031\u1037\u101c\u102c\u1015\u102b',
            step3Text: 'Study home\u104a lessons\u104a vocabulary\u104a kanji\u104a flashcards \u1014\u103e\u1004\u1037\u103a quizzes \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1016\u103d\u1004\u1037\u103a\u1015\u102b\u104b',
            jlptText: 'Learner \u1010\u1005\u103a\u101a\u1031\u102c\u1000\u103a\u1001\u103b\u1004\u103a\u1038\u1005\u102e\u1021\u1010\u103d\u1000\u103a admin \u1001\u103d\u1004\u1037\u103a\u1015\u103c\u102f\u1011\u102c\u1038\u101e\u1031\u102c level \u1019\u103b\u102c\u1038\u1000\u102d\u102f\u101e\u102c \u1019\u103c\u1004\u103a\u101b\u1015\u102b\u1019\u100a\u103a\u104b',
            lessonsText: '\u101b\u102d\u102f\u1038\u101b\u103e\u1004\u103a\u1038\u101e\u1031\u102c reading layout \u1016\u103c\u1004\u1037\u103a structured lesson pages \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1016\u103d\u1004\u1037\u103a\u1015\u102b\u104b',
            vocabularyText: 'Word\u104a reading\u104a meaning \u1014\u103e\u1004\u1037\u103a example \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1010\u1005\u103a\u1014\u1031\u101b\u102c\u1010\u100a\u103a\u1038\u1010\u103d\u1004\u103a \u101c\u1031\u1037\u101c\u102c\u1015\u102b\u104b',
            kanjiText: 'Approval \u101b\u1015\u103c\u102e\u1038\u1014\u1031\u102c\u1000\u103a kanji details\u104a flashcards \u1014\u103e\u1004\u1037\u103a quizzes \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u101c\u1031\u1037\u101c\u102c\u1015\u102b\u104b',
            words: '\u1005\u1000\u102c\u1038\u101c\u102f\u1036\u1038\u1019\u103b\u102c\u1038',
            read: '\u1016\u1010\u103a\u1019\u100a\u103a',
        },
    },
};

const locale = computed(() => getLocale());
const text = computed(() => copy[locale.value]?.home ?? copy.en.home);
const common = computed(() => copy[locale.value]?.common ?? copy.en.common);
const sectionTitles = computed(() => copy[locale.value]?.sectionTitles ?? copy.en.sectionTitles);
</script>