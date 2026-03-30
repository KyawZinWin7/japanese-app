<template>
    <main class="page-shell">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ t('common.app') }}</p>
                <h1 class="app-title">{{ t('vocabulary.title') }}</h1>
                <p class="app-subtitle">{{ t('vocabulary.subtitle') }}</p>
            </div>
            <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="app-link">{{ viewer.isAuthenticated ? t('common.studyHome') : t('common.login') }}</a>
        </div>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <div class="mt-8">
            <VocabularyFilters :action="routes.index" :filters="filters" :levels="levels" :sources="sources" />
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <article v-for="item in items" :key="item.id" class="content-card">
                <div class="flex items-center justify-between gap-3">
                    <span class="app-badge">{{ item.level.name }}</span>
                    <span class="text-sm text-slate-500">#{{ item.sort_order }}</span>
                </div>
                <p v-if="item.source" class="mt-3 text-sm font-medium text-emerald-700">{{ item.source.name }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-slate-900">{{ item.word }}</h2>
                <p class="mt-2 text-lg text-slate-500">{{ item.reading }}</p>
                <p class="mt-3 text-[15px] leading-7 text-slate-700">{{ item.meaning }}</p>
                <p v-if="item.meaning_mm" class="mt-1 text-[15px] leading-7 text-emerald-800">{{ item.meaning_mm }}</p>
                <div class="mt-6 flex items-center gap-3">
                    <a :href="item.showUrl" class="app-btn">{{ t('common.open') }}</a>
                    <BookmarkButton v-if="item.canBookmark" :action="item.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="item.isBookmarked" />
                    <a v-else :href="viewer.loginUrl" class="app-link">{{ t('vocabulary.loginBookmark') }}</a>
                </div>
            </article>
        </div>

        <p v-if="!items.length" class="app-empty mt-8">{{ t('vocabulary.empty') }}</p>

        <div v-if="pagination.total" class="mt-8 text-sm text-slate-500">{{ t('vocabulary.showing', { from: pagination.from, to: pagination.to, total: pagination.total }) }}</div>
        <PaginationNav :pagination="pagination" />
    </main>
</template>

<script setup>
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import PaginationNav from '../components/lessons/PaginationNav.vue';
import VocabularyFilters from '../components/vocabulary/VocabularyFilters.vue';
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    levels: { type: Array, required: true },
    pagination: { type: Object, required: true },
    routes: { type: Object, required: true },
    sources: { type: Array, default: () => [] },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});
</script>
