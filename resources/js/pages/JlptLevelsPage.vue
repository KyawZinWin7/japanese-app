<template>
    <main class="mx-auto max-w-4xl rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-600">{{ t('common.app') }}</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ t('levels.title') }}</h1>
                <p class="mt-2 text-slate-600">{{ t('levels.subtitle') }}</p>
            </div>
            <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                {{ viewer.isAuthenticated ? t('common.studyHome') : t('common.login') }}
            </a>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <article v-for="level in levels" :key="level.id" class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-2xl font-semibold text-slate-900">{{ level.name }}</h2>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700">{{ t('levels.order', { value: level.sort_order }) }}</span>
                </div>
                <p class="mt-3 text-sm uppercase tracking-[0.2em] text-slate-500">{{ level.slug }}</p>
                <p class="mt-4 text-slate-600">{{ level.description || t('levels.noDescription') }}</p>
            </article>
        </div>

        <p v-if="!levels.length" class="mt-8 rounded-2xl bg-slate-50 p-5 text-slate-600">{{ t('levels.empty') }}</p>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    viewer: { type: Object, required: true },
});
</script>
