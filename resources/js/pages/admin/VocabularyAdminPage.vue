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
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Manage Vocabulary</h1>
                <p class="mt-2 text-slate-600">Search, filter, and manage vocabulary content.</p>
            </div>
            <div class="flex items-center gap-3">
                <a :href="routes.publicIndex" class="text-sm font-medium text-slate-600 hover:text-slate-900">View public list</a>
                <a :href="routes.create" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">New Vocabulary</a>
            </div>
        </div>

        <p v-if="status" class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ status }}</p>

        <div class="mt-8">
            <VocabularyFilters :action="routes.index" :filters="filters" :levels="levels" :sources="sources" />
        </div>

        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Word</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Reading</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Meaning</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Level</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Chapter</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <tr v-for="item in items" :key="item.id">
                        <td class="px-4 py-4 font-medium text-slate-900">{{ item.word }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ item.reading }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ item.meaning }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ item.level.name }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ item.source?.name || '-' }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ item.chapter || '-' }}</td>
                        <td class="px-4 py-4">
                            <span :class="item.is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">{{ item.is_published ? 'Published' : 'Draft' }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a :href="`${routes.editBase}/${item.slug}/edit`" class="text-sm font-medium text-emerald-700 hover:text-emerald-600">Edit</a>
                                <form :action="`${routes.editBase}/${item.slug}`" method="POST">
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

        <p v-if="!items.length" class="mt-6 rounded-2xl bg-slate-50 p-5 text-slate-600">No vocabulary found.</p>

        <div v-if="pagination.total" class="mt-8 text-sm text-slate-500">Showing {{ pagination.from }}-{{ pagination.to }} of {{ pagination.total }} vocabulary items</div>
        <PaginationNav :pagination="pagination" />
    </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import PaginationNav from '../../components/lessons/PaginationNav.vue';
import VocabularyFilters from '../../components/vocabulary/VocabularyFilters.vue';

defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    sources: { type: Array, default: () => [] },
    pagination: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
});
</script>
