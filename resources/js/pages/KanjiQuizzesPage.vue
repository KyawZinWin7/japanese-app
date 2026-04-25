<template>
    <main class="page-shell">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ t('quizzes.eyebrow') }}</p>
                <h1 class="app-title">{{ t('quizzes.title') }}</h1>
                <p class="app-subtitle">{{ t('quizzes.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="app-link">{{ viewer.isAuthenticated ? t('common.studyHome') : t('common.login') }}</a>
                <a :href="routes.kanji" class="app-btn-secondary">{{ t('quizzes.browseKanji') }}</a>
            </div>
        </div>

        <section class="mt-8 section-card">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="app-eyebrow">{{ t('quizzes.step1') }}</p>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ t('quizzes.chooseLevel') }}</h2>
                </div>
                <a v-if="selectedLevel" :href="routes.index" class="app-btn-secondary">{{ t('quizzes.changeLevel') }}</a>
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                <a
                    v-for="level in levels"
                    :key="level.id"
                    :href="`${routes.index}?level=${level.slug}`"
                    class="rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5"
                    :class="selectedLevel?.slug === level.slug
                        ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]'
                        : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]'"
                >
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedLevel?.slug === level.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ t('quizzes.level') }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ level.name }}</span>
                </a>
            </div>
        </section>

        <section v-if="selectedLevel" class="mt-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="app-eyebrow">{{ selectedLevel.name }}</p>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ t('quizzes.chooseQuiz') }}</h2>
                </div>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <article v-for="item in items" :key="item.slug" class="content-card">
                    <span class="app-badge">{{ item.level.name || t('quizzes.mixed') }}</span>
                    <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ item.title }}</h2>
                    <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ item.description || t('quizzes.noDescription') }}</p>
                    <p class="mt-4 text-sm text-slate-500">{{ t('quizzes.questions', { count: item.question_count }) }}</p>
                    <a :href="item.showUrl" class="app-btn mt-6 inline-flex">{{ t('quizzes.openQuiz') }}</a>
                </article>
            </div>

            <p v-if="!items.length" class="app-empty mt-8">{{ t('quizzes.empty') }}</p>
        </section>
        <p v-else class="app-empty mt-8">{{ t('quizzes.selectLevelFirst') }}</p>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    items: { type: Array, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    selectedLevel: { type: Object, default: null },
    viewer: { type: Object, required: true },
});
</script>
