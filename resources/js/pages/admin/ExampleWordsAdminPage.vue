<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <main class="page-shell">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="app-eyebrow">Admin</p>
                    <h1 class="app-title">Manage Example Words</h1>
                    <p class="app-subtitle">Save one compound word and attach it to any kanji you want.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="routes.create" class="app-btn">New Example Word</a>
                </div>
            </div>

            <p v-if="status" class="app-status mt-6">{{ status }}</p>

            <form :action="routes.index" method="GET" class="section-card mt-8">
                <div class="grid gap-4 md:grid-cols-[200px,220px,160px,1fr,auto] md:items-end">
                    <div>
                        <label for="level" class="app-label">JLPT Level</label>
                        <select id="level" name="level" :value="filters.level" class="app-input">
                            <option value="">All levels</option>
                            <option v-for="level in levels" :key="level.id" :value="level.slug">{{ level.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="source" class="app-label">Book Category</label>
                        <select id="source" name="source" :value="filters.source" class="app-input">
                            <option value="">All categories</option>
                            <option v-for="source in filteredSources" :key="source.id" :value="source.slug">{{ source.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="chapter" class="app-label">Chapter</label>
                        <input id="chapter" name="chapter" type="text" :value="filters.chapter" class="app-input" placeholder="8">
                    </div>
                    <div>
                        <label for="search" class="app-label">Search</label>
                        <input id="search" name="search" type="text" :value="filters.search" class="app-input" placeholder="Word, reading, meaning">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="app-btn">Filter</button>
                        <a :href="routes.index" class="app-btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Word</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Reading</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Meaning</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Linked Kanji</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Chapter</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <tr v-for="item in items" :key="item.id">
                            <td class="px-4 py-4 font-semibold text-slate-900">{{ item.word }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ item.reading }}</td>
                            <td class="px-4 py-4 text-slate-600">
                                <p>{{ item.meaning }}</p>
                                <p v-if="item.meaning_mm" class="mt-1 text-emerald-800">{{ item.meaning_mm }}</p>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="kanji in item.kanji" :key="kanji.id" class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">
                                        {{ kanji.character }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ item.chapter || '-' }}</td>
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

            <p v-if="!items.length" class="app-empty mt-8">No example words found.</p>
            <div v-if="pagination.total" class="mt-8 text-sm text-slate-500">Showing {{ pagination.from }}-{{ pagination.to }} of {{ pagination.total }} example words</div>
            <PaginationNav :pagination="pagination" />
        </main>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import AdminLayout from '../../components/admin/AdminLayout.vue';
import PaginationNav from '../../components/lessons/PaginationNav.vue';

const props = defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    pagination: { type: Object, required: true },
    routes: { type: Object, required: true },
    sources: { type: Array, default: () => [] },
    status: { type: String, default: null },
});

const filteredSources = computed(() => {
    if (! props.filters.level) {
        return props.sources;
    }

    return props.sources.filter((source) => source.level.slug === props.filters.level);
});
</script>
