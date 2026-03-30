<template>
    <header class="flex flex-wrap items-center justify-between gap-4 rounded-[2rem] border border-white/70 bg-white/90 px-6 py-5 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.25)] backdrop-blur">
        <div>
            <p class="app-eyebrow">Admin</p>
            <h1 class="mt-2 text-3xl font-semibold text-slate-900 md:text-4xl">{{ title }}</h1>
            <p class="mt-2 max-w-2xl text-[15px] leading-7 text-slate-600">{{ subtitle }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a :href="actions.siteUrl" class="app-btn-secondary">
                Back to Site
            </a>
            <form :action="actions.logoutUrl" method="POST">
                <input type="hidden" name="_token" :value="csrfToken">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">
                    Logout
                </button>
            </form>
        </div>
    </header>
</template>

<script setup>
defineProps({
    actions: { type: Object, required: true },
    csrfToken: { type: String, required: true },
    subtitle: { type: String, required: true },
    title: { type: String, required: true },
});
</script>
