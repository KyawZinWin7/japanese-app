<template>
    <main class="page-shell max-w-6xl !p-3 sm:!p-5 md:!p-8">
        <section class="rounded-[1.25rem] bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-6 md:rounded-[2rem] md:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-start sm:justify-between">
                <div>
                    <p class="app-eyebrow">KMM JAPANESE</p>
                    <h1 class="app-title">{{ t('study.title') }}</h1>
                    <p class="app-subtitle">{{ t('study.subtitle', { name: user.name }) }}</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3 sm:mt-8 sm:gap-5 md:grid-cols-2 xl:grid-cols-4">
                <a :href="routes.levels" class="content-card min-h-[10.75rem] !rounded-[1.25rem] !p-4 transition hover:-translate-y-0.5 hover:shadow-md sm:min-h-[12rem] sm:!rounded-[1.5rem] sm:!p-5">
                    <p class="app-badge">{{ t('study.start') }}</p>
                    <h2 class="mt-3 text-lg font-semibold text-slate-950 sm:mt-4 sm:text-2xl">{{ t('levels.title') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:text-[15px] sm:leading-7">{{ t('study.levelsText') }}</p>
                </a>
                <a :href="routes.lessons" class="content-card min-h-[10.75rem] !rounded-[1.25rem] !p-4 transition hover:-translate-y-0.5 hover:shadow-md sm:min-h-[12rem] sm:!rounded-[1.5rem] sm:!p-5">
                    <p class="app-badge">{{ t('study.read') }}</p>
                    <h2 class="mt-3 text-lg font-semibold text-slate-950 sm:mt-4 sm:text-2xl">{{ t('lessons.title') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:text-[15px] sm:leading-7">{{ t('study.lessonsText') }}</p>
                </a>
                <a :href="routes.vocabulary" class="content-card min-h-[10.75rem] !rounded-[1.25rem] !p-4 transition hover:-translate-y-0.5 hover:shadow-md sm:min-h-[12rem] sm:!rounded-[1.5rem] sm:!p-5">
                    <p class="app-badge">{{ t('study.words') }}</p>
                    <h2 class="mt-3 text-lg font-semibold text-slate-950 sm:mt-4 sm:text-2xl">{{ t('vocabulary.title') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:text-[15px] sm:leading-7">{{ t('study.vocabularyText') }}</p>
                </a>
                <a :href="routes.kanji" class="content-card min-h-[10.75rem] !rounded-[1.25rem] !p-4 transition hover:-translate-y-0.5 hover:shadow-md sm:min-h-[12rem] sm:!rounded-[1.5rem] sm:!p-5">
                    <p class="app-badge">{{ t('study.kanji') }}</p>
                    <h2 class="mt-3 text-lg font-semibold text-slate-950 sm:mt-4 sm:text-2xl">Kanji</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:text-[15px] sm:leading-7">{{ t('study.kanjiText') }}</p>
                </a>
            </div>
        </section>

        <section class="mt-6 grid gap-4 sm:mt-8 sm:gap-6 lg:grid-cols-[1.1fr,0.9fr]">
            <article class="section-card !rounded-[1.25rem] !p-4 sm:!rounded-[1.5rem] sm:!p-5">
                <p class="app-eyebrow">{{ t('levels.title') }}</p>
                <h2 class="mt-3 text-xl font-semibold text-slate-950 sm:text-2xl">{{ t('study.available') }}</h2>
                <div v-if="levels.length" class="mt-5 flex flex-wrap gap-2.5 sm:mt-6 sm:gap-3">
                    <span v-for="level in levels" :key="level.id" class="rounded-full bg-emerald-100 px-3.5 py-2 text-sm font-semibold text-emerald-700 sm:px-4">{{ level.name }}</span>
                </div>
                <p v-else class="app-empty mt-5 sm:mt-6">{{ t('study.noLevels') }}</p>
            </article>

            <article class="section-card !rounded-[1.25rem] !p-4 sm:!rounded-[1.5rem] sm:!p-5">
                <p class="app-eyebrow">{{ t('study.quick') }}</p>
                <h2 class="mt-3 text-xl font-semibold text-slate-950 sm:text-2xl">{{ t('study.continueLearning') }}</h2>
                <div class="mt-5 space-y-2.5 sm:mt-6 sm:space-y-3">
                    <a :href="routes.flashcards" class="block rounded-[1.15rem] bg-white p-3.5 ring-1 ring-slate-200 transition hover:bg-slate-100 sm:rounded-2xl sm:p-4">
                        <p class="font-medium text-slate-900">{{ t('study.flashcards') }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ t('study.flashcardsText') }}</p>
                    </a>
                    <a :href="routes.quizzes" class="block rounded-[1.15rem] bg-white p-3.5 ring-1 ring-slate-200 transition hover:bg-slate-100 sm:rounded-2xl sm:p-4">
                        <p class="font-medium text-slate-900">{{ t('study.quizzes') }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ t('study.quizzesText') }}</p>
                    </a>
                    <a :href="routes.bookmarks" class="block rounded-[1.15rem] bg-white p-3.5 ring-1 ring-slate-200 transition hover:bg-slate-100 sm:rounded-2xl sm:p-4">
                        <p class="font-medium text-slate-900">{{ t('study.bookmarks') }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ t('study.bookmarksText') }}</p>
                    </a>
                </div>
            </article>
        </section>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    user: { type: Object, required: true },
});
</script>
