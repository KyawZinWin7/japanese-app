<template>
    <main class="page-shell max-w-4xl">
        <p class="app-eyebrow">{{ quiz.level.name || t('quizDetail.fallbackLevel') }}</p>
        <h1 class="app-title">{{ quiz.title }}</h1>
        <p class="app-subtitle">{{ quiz.description || t('quizDetail.fallbackDescription') }}</p>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('quizDetail.questionCount') }}</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ quiz.question_count }}</p>
            </section>
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('quizDetail.latestAttempt') }}</p>
                <p class="mt-3 text-lg text-slate-700">
                    <span v-if="latestAttempt">{{ latestAttempt.score }}/{{ latestAttempt.total_questions }}</span>
                    <span v-else>{{ t('quizDetail.noAttempts') }}</span>
                </p>
            </section>
        </div>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a :href="viewer.isAuthenticated ? quiz.takeUrl : routes.login" class="app-btn">
                {{ viewer.isAuthenticated ? t('quizDetail.startQuiz') : t('quizDetail.loginToStart') }}
            </a>
            <a :href="routes.index" class="app-link">{{ t('quizDetail.backToQuizList') }}</a>
        </div>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    latestAttempt: { type: Object, default: null },
    quiz: { type: Object, required: true },
    routes: { type: Object, required: true },
    viewer: { type: Object, required: true },
});
</script>