<template>
    <main class="page-shell max-w-6xl !p-3 sm:!p-5 md:!p-8">
        <section class="overflow-hidden rounded-[1.75rem] bg-[linear-gradient(145deg,_#0f172a,_#111827_52%,_#1e293b)] px-5 py-6 text-white shadow-[0_24px_70px_-35px_rgba(15,23,42,0.55)] sm:px-7 sm:py-8 md:rounded-[2rem] md:px-8">
            <p class="app-eyebrow !text-emerald-300">KMM JAPANESE</p>
            <h1 class="mt-4 text-3xl font-semibold tracking-tight sm:text-4xl">{{ t('study.title') }}</h1>
            <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-300 sm:text-[15px]">{{ t('study.launcherText') }}</p>
        </section>

        <section class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
            <a :href="routes.lessons" class="content-card transition hover:-translate-y-1 hover:shadow-md">
                <p class="app-badge">{{ t('study.read') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('lessons.title') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.lessonsText') }}</p>
            </a>

            <a :href="routes.vocabulary" class="content-card transition hover:-translate-y-1 hover:shadow-md">
                <p class="app-badge">{{ t('study.words') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('vocabulary.title') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.vocabularyText') }}</p>
            </a>

            <a :href="routes.kanji" class="content-card transition hover:-translate-y-1 hover:shadow-md">
                <p class="app-badge">{{ t('study.kanji') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.kanji') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.kanjiText') }}</p>
            </a>

            <a :href="routes.flashcards" class="content-card transition hover:-translate-y-1 hover:shadow-md">
                <p class="app-badge">{{ t('study.flashcards') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.flashcards') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.flashcardsText') }}</p>
            </a>

            <a :href="routes.quizzes" class="content-card transition hover:-translate-y-1 hover:shadow-md">
                <p class="app-badge">{{ t('study.quizzes') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.quizzes') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.quizzesText') }}</p>
            </a>
        </section>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    routes: { type: Object, required: true },
});
</script>
