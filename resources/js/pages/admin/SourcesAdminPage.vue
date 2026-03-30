<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <main class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-600">Admin</p>
                    <h1 class="mt-3 text-3xl font-semibold text-slate-900">Manage Sources</h1>
                    <p class="mt-2 text-slate-600">Create reusable book and source options for vocabulary and kanji.</p>
                </div>
                <a :href="routes.create" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    New Source
                </a>
            </div>

            <p v-if="status" class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ status }}</p>

            <form :action="routes.index" method="GET" class="mt-8 grid gap-4 rounded-2xl bg-slate-50 p-5 md:grid-cols-[1fr,220px,auto] md:items-end">
                <div>
                    <label for="level" class="app-label">JLPT Level</label>
                    <select id="level" name="level" :value="filters.level" class="app-input">
                        <option value="">All levels</option>
                        <option v-for="level in levels" :key="level.id" :value="level.slug">{{ level.name }}</option>
                    </select>
                </div>
                <div>
                    <label for="content_type" class="app-label">Content Type</label>
                    <select id="content_type" name="content_type" :value="filters.content_type" class="app-input">
                        <option value="">All types</option>
                        <option v-for="type in contentTypes" :key="type.value" :value="type.value">{{ type.label }}</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="app-btn">Filter</button>
                    <a :href="routes.index" class="app-btn-secondary">Reset</a>
                </div>
            </form>

            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Source</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Level</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <tr v-for="item in items" :key="item.id">
                            <td class="px-4 py-4">
                                <p class="font-medium text-slate-900">{{ item.name }}</p>
                                <p class="text-sm text-slate-500">{{ item.slug }}</p>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ item.level.name }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ formatType(item.content_type) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ item.sort_order }}</td>
                            <td class="px-4 py-4">
                                <span :class="item.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                    {{ item.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a :href="`${routes.editBase}/${item.id}/edit`" class="text-sm font-medium text-emerald-700 hover:text-emerald-600">Edit</a>
                                    <form :action="`${routes.editBase}/${item.id}`" method="POST">
                                        <input type="hidden" name="_token" :value="csrfToken">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p v-if="!items.length" class="mt-6 rounded-2xl bg-slate-50 p-5 text-slate-600">No sources found.</p>
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';

defineProps({
    contentTypes: { type: Array, required: true },
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
});

function formatType(value) {
    return value.replace('-', ' ').replace(/\b\w/g, (match) => match.toUpperCase());
}
</script>
