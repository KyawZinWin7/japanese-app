<template>
    <main class="page-shell max-w-6xl !p-3 sm:!p-5 md:!p-8">
        <section class="rounded-[1.5rem] bg-slate-950 p-4 text-white shadow-xl sm:p-7 md:rounded-[2rem]">
            <p class="app-eyebrow !text-emerald-300">{{ t('study.profile') }}</p>
            <div class="mt-4 flex items-center gap-3 sm:gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-400/20 text-xl font-semibold text-emerald-200 sm:h-16 sm:w-16 sm:text-2xl">
                    {{ initials }}
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl font-semibold sm:text-3xl">{{ user.name }}</h1>
                    <p class="mt-1 break-all text-sm text-slate-300">{{ user.email }}</p>
                    <p v-if="user.joinedAt" class="mt-1 text-[11px] uppercase tracking-[0.2em] text-slate-400 sm:text-xs sm:tracking-[0.24em]">{{ t('study.memberSince', { date: user.joinedAt }) }}</p>
                </div>
            </div>

            <p class="mt-5 max-w-xl text-sm leading-7 text-slate-300 sm:text-[15px]">{{ t('study.subtitle', { name: user.name }) }}</p>

            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                <div class="rounded-[1.25rem] bg-white/10 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">{{ t('study.completedLessons') }}</p>
                    <p class="mt-3 text-3xl font-semibold">{{ progress.completedLessons }}</p>
                    <p class="mt-1 text-sm text-slate-300">{{ t('study.totalLessons', { total: progress.totalLessons }) }}</p>
                </div>
                <div class="rounded-[1.25rem] bg-white/10 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">{{ t('study.progressRate') }}</p>
                    <p class="mt-3 text-3xl font-semibold">{{ progress.completionRate }}%</p>
                    <p class="mt-1 text-sm text-slate-300">{{ t('study.bookmarkedCount', { total: progress.bookmarkedLessons }) }}</p>
                </div>
                <div class="rounded-[1.25rem] bg-white/10 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">{{ t('study.quizActivity') }}</p>
                    <p class="mt-3 text-3xl font-semibold">{{ progress.quizAttempts }}</p>
                    <p class="mt-1 text-sm text-slate-300">
                        {{ progress.averageQuizScore === null ? t('study.noQuizScore') : t('study.averageQuizScore', { score: progress.averageQuizScore }) }}
                    </p>
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]">
            <article class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5 md:rounded-[2rem]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="app-eyebrow">{{ t('study.resume') }}</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-950 sm:text-2xl">{{ t('study.continueLearning') }}</h2>
                    </div>
                </div>

                <div v-if="resumeItems.length" class="mt-6 space-y-3">
                    <a
                        v-for="item in resumeItems"
                        :key="item.id"
                        :href="item.href"
                        class="block rounded-[1.25rem] border border-slate-200 bg-slate-50/80 p-4 transition hover:-translate-y-0.5 hover:border-emerald-200 hover:bg-emerald-50/60"
                    >
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-base font-semibold text-slate-950 sm:text-lg">{{ item.title }}</p>
                                <p v-if="item.subtitle" class="mt-1 text-sm text-slate-500">{{ item.subtitle }}</p>
                            </div>
                            <span v-if="item.progressLabel" class="app-badge self-start">{{ item.progressLabel }}</span>
                        </div>
                        <p class="mt-3 text-[11px] uppercase tracking-[0.18em] text-slate-400 sm:text-xs sm:tracking-[0.22em]">{{ item.updatedAtLabel }}</p>
                    </a>
                </div>
                <p v-else class="app-empty mt-6">{{ t('study.noResume') }}</p>
            </article>

            <article class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5 md:rounded-[2rem]">
                <p class="app-eyebrow">{{ t('study.history') }}</p>
                <h2 class="mt-3 text-xl font-semibold text-slate-950 sm:text-2xl">{{ t('study.recentActivity') }}</h2>

                <div v-if="historyItems.length" class="mt-6 space-y-3">
                    <a
                        v-for="item in historyItems"
                        :key="item.id"
                        :href="item.href"
                        class="block rounded-[1.25rem] border border-slate-200 bg-white p-4 transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-sm"
                    >
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-base font-semibold text-slate-950">{{ item.title }}</p>
                                <p v-if="item.subtitle" class="mt-1 text-sm text-slate-500">{{ item.subtitle }}</p>
                            </div>
                            <span v-if="item.progressLabel" class="self-start text-sm font-semibold text-emerald-700">{{ item.progressLabel }}</span>
                        </div>
                        <p class="mt-3 text-[11px] uppercase tracking-[0.18em] text-slate-400 sm:text-xs sm:tracking-[0.22em]">{{ item.updatedAtLabel }}</p>
                    </a>
                </div>
                <p v-else class="app-empty mt-6">{{ t('study.noHistory') }}</p>
            </article>
        </section>

        <section class="mt-6 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-6 md:rounded-[2rem]">
            <div class="flex flex-col items-start gap-4 sm:flex-row sm:justify-between">
                <div>
                    <p class="app-eyebrow">{{ t('levels.title') }}</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-950 sm:text-2xl">{{ t('study.available') }}</h2>
                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ t('levels.subtitle') }}</p>
                </div>
                <a :href="routes.levels" class="app-link">{{ t('common.open') }}</a>
            </div>

            <div v-if="levels.length" class="mt-6 grid gap-4 md:grid-cols-2">
                <article v-for="level in levels" :key="level.id" class="rounded-[1.4rem] border border-slate-200 bg-slate-50/80 p-4 sm:p-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h3 class="text-xl font-semibold text-slate-950 sm:text-2xl">{{ level.name }}</h3>
                            <p class="mt-2 text-sm text-slate-500">{{ level.slug.toUpperCase().replace('-', ' ') }}</p>
                        </div>
                        <span class="app-badge self-start">{{ t('levels.order', { value: level.sortOrder }) }}</span>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-700 sm:mt-6 sm:leading-8">{{ level.description || t('levels.noDescription') }}</p>
                </article>
            </div>
            <p v-else class="app-empty mt-6">{{ t('study.noLevels') }}</p>
        </section>
    </main>
</template>

<script setup>
import { computed } from 'vue';
import { t } from '../frontendI18n';

const props = defineProps({
    historyItems: { type: Array, default: () => [] },
    levels: { type: Array, required: true },
    progress: { type: Object, required: true },
    resumeItems: { type: Array, default: () => [] },
    routes: { type: Object, required: true },
    user: { type: Object, required: true },
});

const historyItems = computed(() => props.historyItems);
const resumeItems = computed(() => props.resumeItems);

const initials = computed(() => (
    props.user.name
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('') || 'U'
));
</script>
