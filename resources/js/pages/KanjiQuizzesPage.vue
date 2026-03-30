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
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    items: { type: Array, required: true },
    routes: { type: Object, required: true },
    viewer: { type: Object, required: true },
});
</script>
