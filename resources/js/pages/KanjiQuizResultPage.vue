<template>
    <main class="page-shell max-w-5xl">
        <p class="app-eyebrow">{{ t('quizResult.eyebrow') }}</p>
        <h1 class="app-title">{{ result.quizTitle }}</h1>
        <p class="app-subtitle">{{ t('quizResult.subtitle', { score: result.score, total: result.total }) }}</p>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('quizResult.score') }}</p>
                <p class="mt-3 text-4xl font-semibold text-slate-900">{{ result.score }}/{{ result.total }}</p>
            </section>
            <section class="section-card md:col-span-2">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('quizResult.accuracy') }}</p>
                <p class="mt-3 text-4xl font-semibold text-slate-900">{{ result.percentage }}%</p>
            </section>
        </div>

        <div class="mt-8 space-y-4">
            <article v-for="answer in result.answers" :key="answer.question_id" class="content-card">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ answer.prompt }}</h2>
                        <p class="mt-3 text-slate-600">{{ t('quizResult.yourAnswer') }} <span class="font-medium text-slate-900">{{ answer.selected || t('quizResult.noAnswer') }}</span></p>
                        <p class="mt-2 text-slate-600">{{ t('quizResult.correctAnswer') }} <span class="font-medium text-slate-900">{{ answer.correct }}</span></p>
                    </div>
                    <span :class="answer.is_correct ? 'app-badge' : 'rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-700'">
                        {{ answer.is_correct ? t('quizResult.correct') : t('quizResult.incorrect') }}
                    </span>
                </div>
            </article>
        </div>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a :href="routes.retry" class="app-btn">{{ t('quizResult.tryAgain') }}</a>
            <a :href="routes.detail" class="app-btn-secondary">{{ t('quizResult.quizDetail') }}</a>
            <a :href="routes.index" class="app-link">{{ t('quizResult.backToQuizzes') }}</a>
        </div>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    result: { type: Object, required: true },
    routes: { type: Object, required: true },
});
</script>