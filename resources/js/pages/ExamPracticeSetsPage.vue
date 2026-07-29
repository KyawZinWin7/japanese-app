<template>
    <main class="page-shell">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="app-eyebrow">Exam Practice</p>
                <h1 class="app-title">Practice exam sets at your own pace</h1>
                <p class="app-subtitle">Choose a set, answer one question at a time, and review detailed explanations when you finish.</p>
            </div>
            <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="app-link">
                {{ viewer.isAuthenticated ? 'Study Home' : 'Login' }}
            </a>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <article v-for="item in items" :key="item.slug" class="content-card">
                <span class="app-badge">{{ item.exam_code || 'Practice Set' }}</span>
                <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ item.title }}</h2>
                <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ item.description || 'No description yet.' }}</p>
                <p class="mt-4 text-sm text-slate-500">{{ item.question_count }} questions</p>
                <a :href="item.showUrl" class="app-btn mt-6 inline-flex">Open Set</a>
            </article>
        </div>

        <p v-if="!items.length" class="app-empty mt-8">No exam practice sets are published yet.</p>
    </main>
</template>

<script setup>
defineProps({
    items: { type: Array, required: true },
    viewer: { type: Object, required: true },
});
</script>
