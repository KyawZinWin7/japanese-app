<template>
    <main class="page-shell max-w-4xl">
        <p class="app-eyebrow">{{ set.exam_code || 'Exam Practice' }}</p>
        <h1 class="app-title">{{ set.title }}</h1>
        <p class="app-subtitle">{{ set.description || 'Answer one question at a time and review your score at the end.' }}</p>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Question Count</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ set.question_count }}</p>
            </section>
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Latest Attempt</p>
                <p class="mt-3 text-lg text-slate-700">
                    <span v-if="latestAttempt">{{ latestAttempt.score }}/{{ latestAttempt.total_questions }}</span>
                    <span v-else>No attempts yet</span>
                </p>
            </section>
        </div>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a :href="viewer.isAuthenticated ? (viewer.isApproved ? set.takeUrl : viewer.pendingUrl) : routes.login" class="app-btn">
                {{ viewer.isAuthenticated ? (viewer.isApproved ? 'Start Practice' : 'Approval Required') : 'Login to Start' }}
            </a>
            <a :href="routes.index" class="app-link">Back to Exam Practice</a>
        </div>
    </main>
</template>

<script setup>
defineProps({
    latestAttempt: { type: Object, default: null },
    routes: { type: Object, required: true },
    set: { type: Object, required: true },
    viewer: { type: Object, required: true },
});
</script>
