<template>
    <main class="page-shell max-w-6xl">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ t('bookmarks.eyebrow') }}</p>
                <h1 class="app-title">{{ t('bookmarks.title') }}</h1>
                <p class="app-subtitle">{{ t('bookmarks.subtitle') }}</p>
            </div>
            <a :href="routes.dashboard" class="app-link">{{ t('common.studyHome') }}</a>
        </div>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <section class="mt-8">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-2xl font-semibold text-slate-950">{{ t('bookmarks.lessons') }}</h2>
                <a :href="routes.lessons" class="app-link">{{ t('bookmarks.browseLessons') }}</a>
            </div>

            <div v-if="items.lessons.length" class="mt-5 grid gap-5 md:grid-cols-2">
                <article v-for="lesson in items.lessons" :key="lesson.id" class="content-card">
                    <div class="flex items-center justify-between gap-3">
                        <span class="app-badge">{{ lesson.level.name }}</span>
                        <BookmarkButton :action="lesson.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="true" :active-label="t('bookmarks.saved')" />
                    </div>
                    <h3 class="mt-4 text-2xl font-semibold text-slate-950">{{ lesson.title }}</h3>
                    <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ lesson.excerpt || t('bookmarks.noSummary') }}</p>
                    <a :href="lesson.showUrl" class="app-btn mt-6 inline-flex">{{ t('lessons.openLesson') }}</a>
                </article>
            </div>

            <p v-else class="app-empty mt-5">{{ t('bookmarks.noLessons') }}</p>
        </section>

        <section class="mt-10">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-2xl font-semibold text-slate-950">{{ t('bookmarks.vocabulary') }}</h2>
                <a :href="routes.vocabulary" class="app-link">{{ t('bookmarks.browseVocabulary') }}</a>
            </div>

            <div v-if="items.vocabulary.length" class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <article v-for="item in items.vocabulary" :key="item.id" class="content-card">
                    <div class="flex items-center justify-between gap-3">
                        <span class="app-badge">{{ item.level.name }}</span>
                        <BookmarkButton :action="item.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="true" :active-label="t('bookmarks.saved')" />
                    </div>
                    <h3 class="mt-4 text-2xl font-semibold text-slate-950">{{ item.word }}</h3>
                    <p class="mt-2 text-lg text-slate-500">{{ item.reading }}</p>
                    <p class="mt-3 text-[15px] leading-7 text-slate-700">{{ item.meaning }}</p>
                    <p v-if="item.meaning_mm" class="mt-1 text-[15px] leading-7 text-emerald-800">{{ item.meaning_mm }}</p>
                    <a :href="item.showUrl" class="app-btn mt-6 inline-flex">{{ t('bookmarks.openWord') }}</a>
                </article>
            </div>

            <p v-else class="app-empty mt-5">{{ t('bookmarks.noVocabulary') }}</p>
        </section>

        <section class="mt-10">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-2xl font-semibold text-slate-950">{{ t('bookmarks.kanji') }}</h2>
                <a :href="routes.kanji" class="app-link">{{ t('bookmarks.browseKanji') }}</a>
            </div>

            <div v-if="items.kanji.length" class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <article v-for="item in items.kanji" :key="item.id" class="content-card">
                    <div class="flex items-center justify-between gap-3">
                        <span class="app-badge">{{ item.level.name }}</span>
                        <BookmarkButton :action="item.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="true" :active-label="t('bookmarks.saved')" />
                    </div>
                    <p class="mt-4 text-5xl font-semibold text-slate-900">{{ item.character }}</p>
                    <p class="mt-4 text-lg font-medium text-slate-700">{{ item.meaning }}</p>
                    <p v-if="item.meaning_mm" class="mt-1 text-base text-emerald-800">{{ item.meaning_mm }}</p>
                    <p class="mt-3 text-sm text-slate-500">{{ t('bookmarks.on') }}: {{ item.onyomi || '-' }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ t('bookmarks.kun') }}: {{ item.kunyomi || '-' }}</p>
                    <a :href="item.showUrl" class="app-btn mt-6 inline-flex">{{ t('bookmarks.openKanji') }}</a>
                </article>
            </div>

            <p v-else class="app-empty mt-5">{{ t('bookmarks.noKanji') }}</p>
        </section>
    </main>
</template>

<script setup>
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    items: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
});
</script>
