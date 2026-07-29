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
                        <a :href="viewer.isAuthenticated ? routes.accountHome : routes.lessons" class="app-btn-accent">
                            {{ viewer.isAuthenticated ? text.openMyPage : text.startFree }}
                        </a>
                        <a :href="routes.flashcards" class="app-btn-secondary">{{ text.tryFlashcards }}</a>
                        <a :href="viewer.isAuthenticated ? routes.accountHome : routes.login" class="app-link text-base">
                            {{ viewer.isAuthenticated ? text.continue : text.signInToSave }}
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

        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-6">
            <a :href="routes.levels" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">JLPT</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ text.levels }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.jlptText }}</p>
            </a>
            <a :href="routes.lessons" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.read }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.lessons }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.lessonsText }}</p>
            </a>
            <a :href="routes.vocabulary" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.words }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.vocabulary }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.vocabularyText }}</p>
            </a>
            <a :href="routes.kanji" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.practice }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.kanji }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.kanjiText }}</p>
            </a>
            <a :href="routes.quizzes" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.quizzes }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ text.quizzes }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.quizzesText }}</p>
            </a>
            <a :href="routes.flashcards" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.flashcards }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ sectionTitles.flashcards }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.flashcardsText }}</p>
            </a>
            <a :href="routes.examPractice" class="content-card block transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ text.examPractice }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ text.examPractice }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.examPracticeText }}</p>
            </a>
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
            flashcards: 'Flashcards',
            kanji: 'Kanji',
        },
        home: {
            webApp: 'Japanese Learning Web App',
            heroTitle: 'Study Japanese for free with lessons, kanji, vocabulary, quizzes, and flashcards in one place.',
            heroText: 'KMM JAPANESE gives learners a simple place to start studying right away, and accounts help you save progress, bookmarks, and resume history.',
            openMyPage: 'Open My Page',
            startFree: 'Start Free',
            tryFlashcards: 'Try Flashcards',
            continue: 'Continue',
            signInToSave: 'Sign in to save progress',
            levels: 'Levels',
            levelsText: 'Start from the JLPT level that matches what you want to study next.',
            practice: 'Practice',
            practiceText: 'Review readings, meanings, examples, quizzes, and flashcards in one flow.',
            access: 'Free',
            approved: 'Open',
            accessText: 'Browse the study materials freely, then sign in when you want to keep your progress.',
            today: 'Today With KMM',
            guidedTitle: 'A simple study flow you can start right away',
            focus: 'Focus',
            learnByLevel: 'Learn by level',
            step1: '1. Choose a level',
            step1Text: 'Pick the JLPT level or topic you want to focus on first.',
            step2: '2. Open a study page',
            step2Text: 'Read lessons, review vocabulary, and practice kanji with simple study screens.',
            step3: '3. Keep going',
            step3Text: 'Use an account when you want to save bookmarks, history, and resume shortcuts.',
            jlptText: 'Study materials are organized by JLPT level so you can jump in where you belong.',
            lessonsText: 'Read structured lesson pages designed for focused, easy review.',
            vocabularyText: 'Study words, readings, meanings, and examples together in one place.',
            flashcards: 'Flashcards',
            flashcardsText: 'Launch quick review sets for vocabulary and kanji from one simple starting point.',
            kanjiText: 'Practice kanji details, flashcards, and quizzes as part of your regular review.',
            words: 'Words',
            read: 'Read',
            quizzes: 'Quizzes',
            examPractice: 'Exam Practice',
            quizzesText: 'Browse published quiz sets now, then sign in when you are ready to take them.',
            examPracticeText: 'Open separate practice sets such as AWS Cloud Practitioner with a focused one-question-at-a-time flow.',
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
            flashcards: 'Flashcards',
            kanji: '\u1001\u1014\u103a\u1038\u1002\u103b\u102e\u1038',
        },
        home: {
            webApp: '\u1002\u103b\u1015\u1014\u103a\u1005\u102c \u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 Web App',
            heroTitle: '\u101e\u1004\u103a\u1001\u1014\u103a\u1038\u1005\u102c\u1019\u103b\u102c\u1038\u104a kanji\u104a \u101d\u1031\u102b\u101f\u102c\u101b\u1019\u103b\u102c\u1038\u104a quizzes \u1014\u103e\u1004\u1037\u103a flashcards \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1010\u1005\u103a\u1014\u1031\u101b\u102c\u1010\u100a\u103a\u1038\u1010\u103d\u1004\u103a \u1021\u1001\u1019\u1032\u1037 \u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u101e\u100a\u1037\u103a \u1002\u103b\u1015\u1014\u103a\u1005\u102c\u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 web app \u1016\u103c\u1005\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            heroText: 'KMM JAPANESE \u1010\u103d\u1004\u103a \u1002\u103b\u1015\u1014\u103a\u1005\u102c\u1000\u102d\u102f \u1010\u1001\u103b\u1000\u103a\u1001\u103b\u1004\u103a\u1038 \u1005\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u101e\u100a\u1037\u103a \u101c\u103d\u101a\u103a\u1000\u1030\u101e\u1031\u102c study flow \u101b\u103e\u102d\u1015\u102b\u101e\u100a\u103a\u104b account \u1016\u103d\u1004\u1037\u103a\u1011\u102c\u1038\u1015\u102b\u1000 progress\u104a bookmarks \u1014\u103e\u1004\u1037\u103a resume history \u1019\u103b\u102c\u1038\u1000\u102d\u102f\u101c\u100a\u103a\u1038 \u101e\u102d\u1019\u103a\u1038\u1011\u102c\u1038\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            openMyPage: '\u1000\u103b\u103d\u1014\u103a\u102f\u1015\u103a\u104f\u1005\u102c\u1019\u103b\u1000\u103a\u1014\u103e\u102c \u1016\u103d\u1004\u1037\u103a\u1019\u100a\u103a',
            startFree: '\u1021\u1001\u1019\u1032\u1037 \u1005\u101c\u1031\u1037\u101c\u102c\u1019\u100a\u103a',
            tryFlashcards: 'Flashcards \u1005\u1019\u103a\u1038\u1019\u100a\u103a',
            continue: '\u1006\u1000\u103a\u101e\u103d\u102c\u1038\u1019\u100a\u103a',
            signInToSave: 'Progress \u101e\u102d\u1019\u103a\u1038\u1011\u102c\u1038\u101b\u1014\u103a sign in \u101d\u1004\u103a\u1015\u102b',
            levels: '\u1021\u1006\u1004\u1037\u103a\u1019\u103b\u102c\u1038',
            levelsText: '\u1019\u102d\u1019\u102d \u101c\u1031\u1037\u101c\u102c\u1001\u103b\u1004\u103a\u101e\u100a\u1037\u103a JLPT level \u1000\u102d\u102f \u101b\u103d\u1031\u1038\u1015\u103c\u102e\u1038 \u1010\u1014\u103a\u1038\u1010\u1000\u103a\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            practice: '\u101c\u1031\u1037\u1000\u103b\u1004\u1037\u103a\u1019\u103e\u102f',
            practiceText: 'Reading\u104a meaning\u104a example\u104a quiz \u1014\u103e\u1004\u1037\u103a flashcard \u1019\u103b\u102c\u1038\u1000\u102d\u102f study flow \u1010\u1005\u103a\u1001\u102f\u1010\u100a\u103a\u1038\u1010\u103d\u1004\u103a \u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            access: '\u1021\u101e\u102f\u1036\u1038\u1015\u103c\u102f\u1001\u103d\u1004\u1037\u103a',
            approved: '\u1016\u103d\u1004\u1037\u103a\u1011\u102c\u1038',
            accessText: '\u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 content \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u101c\u103d\u1010\u103a\u101c\u1015\u103a\u1005\u103d\u102c \u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b progress \u101e\u102d\u1019\u103a\u1038\u1011\u102c\u1038\u1001\u103b\u1004\u103a\u101c\u103e\u103b\u1004\u103a sign in \u101d\u1004\u103a\u1015\u102b\u104b',
            today: '\u101a\u1014\u1031\u1037 KMM \u1014\u103e\u1004\u1037\u103a',
            guidedTitle: '\u1010\u1001\u103b\u1000\u103a\u1001\u103b\u1004\u103a\u1038 \u1005\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u101e\u100a\u1037\u103a \u101b\u103e\u1004\u103a\u1038\u101c\u1004\u103a\u1038\u101e\u1031\u102c study flow',
            focus: '\u1021\u1013\u102d\u1000\u1011\u102c\u1038',
            learnByLevel: 'Level \u1021\u101c\u102d\u102f\u1000\u103a \u101c\u1031\u1037\u101c\u102c\u1015\u102b',
            step1: '\u1041\u104b level \u101b\u103d\u1031\u1038\u1015\u102b',
            step1Text: '\u1019\u102d\u1019\u102d \u101c\u1031\u1037\u101c\u102c\u1001\u103b\u1004\u103a\u101e\u100a\u1037\u103a JLPT level \u101e\u102d\u102f\u1037\u1019\u101f\u102f\u1010\u103a topic \u1000\u102d\u102f \u1021\u1005\u1026\u1026\u101b\u103d\u1031\u1038\u1015\u102b\u104b',
            step2: '\u1042\u104b study page \u1016\u103d\u1004\u1037\u103a\u1015\u102b',
            step2Text: '\u101e\u1004\u103a\u1001\u1014\u103a\u1038\u1005\u102c\u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1016\u1010\u103a\u101b\u103e\u102f\u1015\u103c\u102e\u1038 vocabulary \u1014\u103e\u1004\u1037\u103a kanji \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u101c\u103d\u101a\u103a\u1000\u1030\u101e\u1031\u102c screen \u1019\u103b\u102c\u1038\u1016\u103c\u1004\u1037\u103a \u101c\u1031\u1037\u1010\u103d\u1004\u103a\u1015\u102b\u104b',
            step3: '\u1043\u104b \u1006\u1000\u103a\u101c\u1031\u1037\u101c\u102c\u1015\u102b',
            step3Text: 'Bookmarks\u104a history \u1014\u103e\u1004\u1037\u103a resume shortcuts \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u101e\u102d\u1019\u103a\u1038\u1011\u102c\u1038\u1001\u103b\u1004\u103a\u101c\u103e\u103b\u1004\u103a account \u1016\u103d\u1004\u1037\u103a\u1011\u102c\u1038\u1015\u102b\u104b',
            jlptText: '\u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 content \u1019\u103b\u102c\u1038\u1000\u102d\u102f JLPT level \u1021\u101c\u102d\u102f\u1000\u103a \u1005\u102e\u1005\u1009\u103a\u1011\u102c\u1038\u101e\u103c\u102c\u1038\u1015\u103c\u102e\u1038 \u1019\u102d\u1019\u102d\u1014\u1031\u101b\u102c\u1000 \u1010\u1014\u103a\u1038\u1010\u1000\u103a\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            lessonsText: '\u1021\u102c\u101b\u102f\u1036\u1005\u102d\u102f\u1000\u103a\u1016\u1010\u103a\u101b\u103e\u102f\u1014\u102d\u102f\u1004\u103a\u101b\u1014\u103a \u1015\u1036\u102f\u1005\u1036\u1000\u103b\u1005\u103d\u102c \u1010\u100a\u103a\u1006\u1031\u102c\u1000\u103a\u1011\u102c\u1038\u101e\u1031\u102c lesson pages \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1016\u103d\u1004\u1037\u103a\u1015\u102b\u104b',
            vocabularyText: 'Word\u104a reading\u104a meaning \u1014\u103e\u1004\u1037\u103a example \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1010\u1005\u103a\u1014\u1031\u101b\u102c\u1010\u100a\u103a\u1038\u1010\u103d\u1004\u103a \u1015\u1031\u102b\u1004\u103a\u1038\u1005\u100a\u103a\u1038\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u104b',
            flashcards: 'Flashcards',
            flashcardsText: 'Vocabulary \u1014\u103e\u1004\u1037\u103a kanji \u1010\u102d\u102f\u1037\u1021\u1010\u103d\u1000\u103a quick review set \u1019\u103b\u102c\u1038\u1000\u102d\u102f start point \u1010\u1005\u103a\u1014\u1031\u101b\u102c\u1010\u100a\u103a\u1038\u1019\u103e \u101c\u103d\u101a\u103a\u1000\u1030\u1005\u103d\u102c \u1016\u103d\u1004\u1037\u103a\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u104b',
            kanjiText: 'Kanji details\u104a flashcards \u1014\u103e\u1004\u1037\u103a quizzes \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1015\u102f\u1036\u1019\u103e\u1014\u103a review \u101c\u102f\u1015\u103a\u1004\u1014\u103a\u1038\u1005\u1009\u103a \u1010\u1005\u103a\u1001\u102f\u1021\u1016\u103c\u1005\u103a \u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u104b',
            words: '\u1005\u1000\u102c\u1038\u101c\u102f\u1036\u1038\u1019\u103b\u102c\u1038',
            read: '\u1016\u1010\u103a\u1019\u100a\u103a',
            quizzes: 'Quizzes',
            examPractice: 'Exam Practice',
            quizzesText: '\u1011\u102f\u1010\u103a\u101c\u103d\u103e\u1004\u1037\u103a\u1011\u102c\u1038\u101e\u1031\u102c quiz set \u1019\u103b\u102c\u1038\u1000\u102d\u102f \u1021\u1001\u1019\u1032\u1037 \u1000\u103c\u100a\u1037\u103a\u101b\u103e\u102f\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u101e\u100a\u103a\u104b \u1016\u103c\u1031\u1006\u102d\u102f\u101b\u1014\u103a ready \u1016\u103c\u1005\u103a\u101e\u1031\u102c\u1021\u1001\u102b sign in \u101d\u1004\u103a\u1015\u102b\u104b',
            examPracticeText: 'AWS Cloud Practitioner လို separate practice set များကို question တစ်ခုပြီးတစ်ခု ဖြေနိုင်သော flow နဲ့ ဖွင့်လေ့လာနိုင်ပါသည်။',
        },
    },
};

const locale = computed(() => getLocale());
const text = computed(() => copy[locale.value]?.home ?? copy.en.home);
const common = computed(() => copy[locale.value]?.common ?? copy.en.common);
const sectionTitles = computed(() => copy[locale.value]?.sectionTitles ?? copy.en.sectionTitles);
</script>
