<template>
    <main class="page-shell">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ t('common.app') }}</p>
                <h1 class="app-title">{{ t('lessons.title') }}</h1>
                <p class="app-subtitle">{{ t('lessons.subtitle') }}</p>
            </div>
            <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="app-link">{{ viewer.isAuthenticated ? t('common.studyHome') : t('common.login') }}</a>
        </div>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <div class="section-card mt-8">
            <p class="text-sm font-medium text-slate-700">{{ t('lessons.filter') }}</p>
            <div class="mt-3 flex flex-wrap gap-2">
                <a :href="routes.index" :class="chipClass(filters.level === '')">{{ t('lessons.all') }}</a>
                <a v-for="level in levels" :key="level.id" :href="`${routes.index}?level=${level.slug}`" :class="chipClass(filters.level === level.slug)">{{ level.name }}</a>
            </div>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <article v-for="lesson in lessons" :key="lesson.id" class="content-card">
                <div class="flex items-center justify-between gap-3">
                    <span class="app-badge">{{ lesson.level.name }}</span>
                    <span class="text-sm text-slate-500">#{{ lesson.sort_order }}</span>
                </div>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ lesson.title }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ lesson.excerpt || t('lessons.noSummary') }}</p>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a :href="lesson.showUrl" class="app-btn">{{ t('lessons.openLesson') }}</a>
                    <BookmarkButton v-if="lesson.canBookmark" :action="lesson.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="lesson.isBookmarked" />
                    <CompletionButton v-if="lesson.canBookmark" :action="lesson.completionUrl" :csrf-token="csrfToken" :is-completed="lesson.isCompleted" />
                    <a v-else :href="viewer.loginUrl" class="app-link">{{ t('lessons.loginSave') }}</a>
                </div>
            </article>
        </div>

        <p v-if="!lessons.length" class="app-empty mt-8">{{ t('lessons.empty') }}</p>

        <div v-if="pagination.total" class="mt-8 text-sm text-slate-500">{{ t('lessons.showing', { from: pagination.from, to: pagination.to, total: pagination.total }) }}</div>

        <PaginationNav :pagination="pagination" />
    </main>
</template>

<script setup>
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import PaginationNav from '../components/lessons/PaginationNav.vue';
import CompletionButton from '../components/progress/CompletionButton.vue';
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    levels: { type: Array, required: true },
    lessons: { type: Array, required: true },
    pagination: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});

function chipClass(active) {
    return [
        'rounded-full px-4 py-2 text-sm font-medium transition',
        active ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100',
    ];
}
</script>
