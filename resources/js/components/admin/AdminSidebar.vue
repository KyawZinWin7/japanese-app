<template>
    <aside
        class="flex w-full flex-col rounded-[2rem] bg-slate-950 px-5 py-6 text-slate-100 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.7)] lg:min-h-[calc(100vh-4rem)] lg:w-72"
    >
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300">Japanese App</p>
            <h2 class="mt-3 text-2xl font-semibold">Admin Panel</h2>
            <p class="mt-2 text-sm leading-6 text-slate-400">Manage content with a calm, readable workspace.</p>
        </div>

        <nav class="mt-8 space-y-2">
            <a
                v-for="item in navigation"
                :key="item.href"
                :href="item.href"
                :class="[
                    'flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition',
                    item.active
                        ? 'bg-emerald-400 text-slate-950 shadow-sm'
                        : 'text-slate-300 hover:bg-white/8 hover:text-white',
                ]"
            >
                {{ item.label }}
            </a>
        </nav>

        <div class="mt-auto rounded-2xl border border-white/8 bg-slate-900/80 p-4">
            <p class="text-sm font-medium text-white">{{ user.name }}</p>
            <p class="mt-1 text-sm text-slate-400">{{ user.email }}</p>
        </div>
    </aside>
</template>

<script setup>
defineProps({
    navigation: { type: Array, required: true },
    user: { type: Object, required: true },
});
</script>
