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
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Manage JLPT Levels</h1>
                <p class="mt-2 text-slate-600">Create, edit, and remove level records.</p>
            </div>
            <div class="flex items-center gap-3">
                <a :href="routes.publicIndex" class="text-sm font-medium text-slate-600 hover:text-slate-900">View public list</a>
                <a :href="routes.create" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    New Level
                </a>
            </div>
        </div>

        <p v-if="status" class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ status }}
        </p>

        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Slug</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Description</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <tr v-for="level in levels" :key="level.id">
                        <td class="px-4 py-4 font-medium text-slate-900">{{ level.name }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ level.slug }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ level.sort_order }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ level.description || '-' }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a :href="`${routes.editBase}/${level.id}/edit`" class="text-sm font-medium text-emerald-700 hover:text-emerald-600">
                                    Edit
                                </a>
                                <form :action="`${routes.editBase}/${level.id}`" method="POST" @submit="confirmDelete($event, level.name)">
                                    <input type="hidden" name="_token" :value="csrfToken">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p v-if="!levels.length" class="mt-6 rounded-2xl bg-slate-50 p-5 text-slate-600">
            No levels yet. Create your first JLPT level.
        </p>
    </main>
    </AdminLayout>
</template>

<script setup>
import Swal from 'sweetalert2';
import AdminLayout from '../../components/admin/AdminLayout.vue';

defineProps({
    csrfToken: { type: String, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
});

async function confirmDelete(event, name) {
    event.preventDefault();

    const result = await Swal.fire({
        title: 'Are you sure?',
        html: `<div class="swal-delete-copy">Delete <strong>${name}</strong>?</div>`,
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
