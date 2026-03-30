<template>
    <main class="page-shell max-w-4xl">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ item.level.name }}</p>
                <h1 class="mt-3 text-5xl font-semibold text-slate-900">{{ item.word }}</h1>
                <p class="mt-3 text-2xl text-slate-500">{{ item.reading }}</p>
                <p class="mt-5 text-xl leading-8 text-slate-700">{{ item.meaning }}</p>
                <p v-if="item.meaning_mm" class="mt-2 text-lg leading-8 text-emerald-800">{{ item.meaning_mm }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a :href="routes.index" class="app-link">{{ t('vocabulary.back') }}</a>
                <BookmarkButton v-if="item.canBookmark" :action="item.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="item.isBookmarked" />
                <a v-else :href="viewer.loginUrl" class="app-link">{{ t('vocabulary.loginBookmark') }}</a>
            </div>
        </div>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('vocabulary.exampleSentence') }}</p>
                <p class="mt-3 text-lg leading-9 text-slate-800">{{ item.example_sentence || t('vocabulary.noSentence') }}</p>
            </section>
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ t('vocabulary.translation') }}</p>
                <p class="mt-3 text-lg leading-8 text-slate-800">{{ item.example_translation || t('vocabulary.noTranslation') }}</p>
            </section>
        </div>
    </main>
</template>

<script setup>
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    item: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});
</script>
