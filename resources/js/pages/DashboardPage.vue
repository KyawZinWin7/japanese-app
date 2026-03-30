<template>
    <main class="page-shell max-w-5xl">
        <section class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="app-eyebrow">{{ t('dashboard.eyebrow') }}</p>
                    <h1 class="app-title">{{ t('dashboard.welcome', { name: user.name }) }}</h1>
                    <p class="app-subtitle">
                        {{ t('dashboard.loggedInWith', { email: user.email }) }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a v-if="isAdmin" :href="routes.adminDashboard" class="app-btn-secondary">{{ t('dashboard.adminDashboard') }}</a>
                    <form :action="routes.logout" method="POST">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button type="submit" class="rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">
                            {{ t('common.logout') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <section class="section-card">
                    <p class="text-sm text-slate-500">{{ t('dashboard.completedLessons') }}</p>
                    <p class="mt-2 text-4xl font-semibold text-slate-950">{{ progress.summary.completedLessons }}/{{ progress.summary.totalLessons }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ t('dashboard.lessonsCompleted', { rate: progress.summary.lessonCompletionRate }) }}</p>
                </section>
                <section class="section-card">
                    <p class="text-sm text-slate-500">{{ t('dashboard.quizAttempts') }}</p>
                    <p class="mt-2 text-4xl font-semibold text-slate-950">{{ progress.summary.quizAttempts }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ t('dashboard.averageScore', { score: progress.summary.averageQuizScore }) }}</p>
                </section>
                <section class="section-card">
                    <p class="text-sm text-slate-500">{{ t('dashboard.bestQuizScore') }}</p>
                    <p class="mt-2 text-4xl font-semibold text-slate-950">{{ progress.summary.bestQuizScore }}%</p>
                    <p class="mt-2 text-sm text-slate-600">{{ t('dashboard.keepImproving') }}</p>
                </section>
            </div>
        </section>

        <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <a :href="routes.levels" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('dashboard.browse') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('levels.title') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('study.levelsText') }}</p>
            </a>
            <a :href="routes.lessons" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('study.read') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('lessons.title') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.lessonCardText') }}</p>
            </a>
            <a :href="routes.vocabulary" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('study.start') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('vocabulary.title') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.vocabularyCardText') }}</p>
            </a>
            <a :href="routes.bookmarks" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('dashboard.saved') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.bookmarks') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.bookmarksCardText') }}</p>
            </a>
            <a :href="routes.progress" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('dashboard.progress') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('dashboard.progress') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.progressCardText') }}</p>
            </a>
            <a :href="routes.kanji" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('study.kanji') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.kanji') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.kanjiCardText') }}</p>
            </a>
            <a :href="routes.kanjiQuizzes" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('study.quizzes') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('study.quizzes') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.quizCardText') }}</p>
            </a>
            <a :href="routes.kanjiFlashcards" class="content-card transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="app-badge">{{ t('study.flashcards') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ t('flashcardStudy.exampleWordFlashcards') }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ t('dashboard.flashcardsCardText') }}</p>
            </a>
        </section>

        <section class="mt-8 grid gap-5 lg:grid-cols-[0.95fr,1.05fr]">
            <div class="section-card">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="app-eyebrow">{{ t('dashboard.lessonProgress') }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ t('dashboard.byJlptLevel') }}</h2>
                    </div>
                    <a :href="routes.lessons" class="app-link">{{ t('dashboard.openLessons') }}</a>
                </div>

                <div class="mt-6 space-y-4">
                    <article v-for="level in progress.levels" :key="level.name">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-semibold text-slate-900">{{ level.name }}</p>
                            <p class="text-sm text-slate-500">{{ level.completedLessons }}/{{ level.totalLessons }}</p>
                        </div>
                        <div class="mt-2 h-3 overflow-hidden rounded-full bg-slate-200">
                            <div class="h-full rounded-full bg-emerald-500" :style="{ width: `${level.percentage}%` }"></div>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">{{ t('dashboard.percentCompleted', { value: level.percentage }) }}</p>
                    </article>
                </div>
            </div>

            <div class="section-card">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="app-eyebrow">{{ t('dashboard.quizHistory') }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ t('dashboard.recentScores') }}</h2>
                    </div>
                    <a :href="routes.kanjiQuizzes" class="app-link">{{ t('dashboard.openQuizzes') }}</a>
                </div>

                <div v-if="progress.recentQuizAttempts.length" class="mt-6 space-y-4">
                    <article v-for="attempt in progress.recentQuizAttempts" :key="attempt.id" class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-950">{{ attempt.quizTitle }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ attempt.level }}</p>
                            </div>
                            <span class="app-badge">{{ attempt.percentage }}%</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">{{ t('dashboard.scoreLine', { score: attempt.score, total: attempt.totalQuestions }) }}</p>
                    </article>
                </div>
                <p v-else class="app-empty mt-6">{{ t('dashboard.noQuizAttempts') }}</p>
            </div>
        </section>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    isAdmin: { type: Boolean, default: false },
    progress: { type: Object, required: true },
    routes: { type: Object, required: true },
    user: { type: Object, required: true },
});
</script>
