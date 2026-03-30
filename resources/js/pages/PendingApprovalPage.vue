<template>
    <main class="page-shell max-w-3xl">
        <section class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <p class="app-eyebrow">KMM JAPANESE</p>
            <h1 class="app-title mt-3">{{ t('pending.title') }}</h1>
            <p class="app-subtitle mt-4">{{ t('pending.intro', { name: user.name }) }}</p>

            <div class="mt-8 rounded-3xl border border-amber-200 bg-amber-50 p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">{{ t('pending.status') }}</p>
                <p class="mt-3 text-lg font-medium text-slate-900">{{ t('pending.pendingFor', { email: user.email }) }}</p>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ t('pending.waitText') }}</p>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a :href="routes.home" class="app-btn">{{ t('pending.backHome') }}</a>
                <form :action="routes.logout" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <button type="submit" class="app-btn-secondary">{{ t('common.logout') }}</button>
                </form>
            </div>
        </section>
    </main>
</template>

<script setup>
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    routes: { type: Object, required: true },
    user: { type: Object, required: true },
});
</script>
