<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article
                v-for="stat in stats"
                :key="stat.label"
                :class="[
                    'rounded-3xl p-5 shadow-sm ring-1',
                    tones[stat.tone] ?? tones.slate,
                ]"
            >
                <p class="text-sm font-semibold uppercase tracking-[0.2em]">{{ stat.label }}</p>
                <p class="mt-4 text-4xl font-semibold">{{ stat.value }}</p>
            </article>
        </section>

        <section class="mt-6 grid gap-6 lg:grid-cols-[1.4fr,1fr]">
            <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Overview</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-900">Content workspace</h2>
                <p class="mt-3 max-w-2xl text-slate-600">
                    This reusable admin layout is ready for CRUD pages. It gives us a responsive sidebar, a shared
                    topbar, and a clean space for content tools.
                </p>
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Structure</p>
                        <p class="mt-2 text-lg font-medium text-slate-900">Reusable layout shell</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Navigation</p>
                        <p class="mt-2 text-lg font-medium text-slate-900">Shared admin menu</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Responsive</p>
                        <p class="mt-2 text-lg font-medium text-slate-900">Mobile to desktop</p>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Quick Links</p>
                <div class="mt-4 space-y-3">
                    <a
                        v-for="link in recentLinks"
                        :key="link.href"
                        :href="link.href"
                        class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-slate-100"
                    >
                        <p class="font-medium text-slate-900">{{ link.label }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ link.description }}</p>
                    </a>
                </div>
            </article>
        </section>

    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';

defineProps({
    layout: { type: Object, required: true },
    recentLinks: { type: Array, required: true },
    stats: { type: Array, required: true },
});

const tones = {
    amber: 'bg-amber-50 text-amber-900 ring-amber-100',
    emerald: 'bg-emerald-50 text-emerald-900 ring-emerald-100',
    rose: 'bg-rose-50 text-rose-900 ring-rose-100',
    sky: 'bg-sky-50 text-sky-900 ring-sky-100',
    slate: 'bg-slate-50 text-slate-900 ring-slate-100',
};
</script>
