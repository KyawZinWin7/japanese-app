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
                    <h1 class="app-title">Manage Quizzes</h1>
                    <p class="app-subtitle">Create JLPT-based quizzes and keep each level organized.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="routes.publicIndex" class="app-link">View public list</a>
                    <a :href="routes.create" class="app-btn">New Quiz</a>
                </div>
            </div>

            <p v-if="status" class="app-status mt-6">{{ status }}</p>

            <form :action="routes.index" method="GET" class="section-card mt-8">
                <div class="grid gap-4 md:grid-cols-[220px,auto] md:items-end">
                    <div>
                        <label for="level" class="app-label">JLPT Level</label>
                        <select id="level" name="level" :value="filters.level" class="app-input">
                            <option value="">All levels</option>
                            <option v-for="level in levels" :key="level.id" :value="level.slug">{{ level.name }}</option>
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="app-btn">Filter</button>
                        <a :href="routes.index" class="app-btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div v-if="pagination.total" class="mt-8 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-slate-500">Showing {{ pagination.from }}-{{ pagination.to }} of {{ pagination.total }} quizzes</p>
                <PaginationNav :pagination="pagination" />
            </div>

            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Quiz</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Level</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Questions</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <tr v-for="item in items" :key="item.slug">
                            <td class="px-4 py-4">
                                <p class="font-medium text-slate-900">{{ item.title }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ item.slug }}</p>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ item.level.name || '-' }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ item.question_count }}</td>
                            <td class="px-4 py-4">
                                <span :class="item.is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                    {{ item.is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a :href="`${routes.editBase}/${item.slug}/edit`" class="text-sm font-medium text-emerald-700 hover:text-emerald-600">Edit</a>
                                    <form :action="`${routes.editBase}/${item.slug}`" method="POST" @submit="confirmDelete($event, item.title)">
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

            <p v-if="!items.length" class="app-empty mt-8">No quizzes found.</p>
            <div v-if="pagination.total" class="mt-8 text-sm text-slate-500">Showing {{ pagination.from }}-{{ pagination.to }} of {{ pagination.total }} quizzes</div>
            <PaginationNav :pagination="pagination" />
        </main>
    </AdminLayout>
</template>

<script setup>
import Swal from 'sweetalert2';
import AdminLayout from '../../components/admin/AdminLayout.vue';
import PaginationNav from '../../components/lessons/PaginationNav.vue';

defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    pagination: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
});

async function confirmDelete(event, title) {
    event.preventDefault();

    const result = await Swal.fire({
        title: 'Are you sure?',
        html: `<div class="swal-delete-copy">Delete <strong>${title}</strong>?</div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true,
        background: '#ffffff',
        customClass: {
            popup: 'app-swal-popup',
            icon: 'app-swal-icon',
            title: 'app-swal-title',
            htmlContainer: 'app-swal-copy',
            actions: 'app-swal-actions',
            confirmButton: 'app-swal-confirm',
            cancelButton: 'app-swal-cancel',
        },
        buttonsStyling: false,
    });

    if (result.isConfirmed) {
        event.target.submit();
    }
}
</script>
