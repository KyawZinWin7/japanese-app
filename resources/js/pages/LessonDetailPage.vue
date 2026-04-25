<template>
    <main class="page-shell max-w-4xl">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">{{ lesson.level.name }}</p>
                <h1 class="app-title">{{ lesson.title }}</h1>
                <p v-if="lesson.excerpt" class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">{{ lesson.excerpt }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a :href="routes.index" class="app-link">{{ t('lessons.back') }}</a>
                <BookmarkButton v-if="lesson.canBookmark" :action="lesson.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="lesson.isBookmarked" />
                <CompletionButton v-if="lesson.canBookmark" :action="lesson.completionUrl" :csrf-token="csrfToken" :is-completed="lesson.isCompleted" />
                <a v-if="!viewer.isAuthenticated" :href="viewer.loginUrl" class="app-link">{{ t('common.login') }}</a>
            </div>
        </div>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <article class="section-card mt-8 p-7">
            <div class="max-w-none whitespace-pre-line text-[17px] leading-9 text-slate-700">{{ lesson.content }}</div>
        </article>
    </main>
</template>

<script setup>
import { onMounted } from 'vue';
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import CompletionButton from '../components/progress/CompletionButton.vue';
import { t } from '../frontendI18n';
import { saveStudyResume, trackStudyHistory } from '../studyHistory';

const props = defineProps({
    csrfToken: { type: String, required: true },
    lesson: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    studyState: { type: Object, default: () => ({}) },
    viewer: { type: Object, required: true },
});

onMounted(() => {
    const entry = {
        id: `lesson:${window.location.pathname}`,
        href: window.location.href,
        title: props.lesson.title,
        subtitle: `${props.lesson.level.name} ${t('study.read')}`,
        progressLabel: t('study.ready'),
    };

    trackStudyHistory(entry);
    saveStudyResume(entry);
});
</script>
