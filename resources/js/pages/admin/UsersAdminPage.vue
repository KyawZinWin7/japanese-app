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
                    <p class="app-eyebrow">Admin</p>
                    <h1 class="app-title">Manage Users</h1>
                    <p class="app-subtitle">Create learner accounts, assign JLPT access, approve registrations, and manage admins.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a :href="routes.approvals" class="app-btn-secondary">Pending Approvals</a>
                    <a :href="routes.create" class="app-btn">New User</a>
                </div>
            </div>

            <p v-if="status" class="app-status mt-6">{{ status }}</p>

            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Allowed Levels</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <tr v-for="userItem in users" :key="userItem.id">
                            <td class="px-4 py-4 font-medium text-slate-900">{{ userItem.name }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ userItem.email }}</td>
                            <td class="px-4 py-4">
                                <span :class="userItem.is_admin ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                    {{ userItem.is_admin ? 'Admin' : 'Learner' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span :class="userItem.is_approved ? 'bg-sky-100 text-sky-700' : 'bg-amber-100 text-amber-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                    {{ userItem.is_approved || userItem.is_admin ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                <span v-if="userItem.is_admin">All access</span>
                                <span v-else-if="userItem.levels.length">{{ userItem.levels.map(level => level.name).join(', ') }}</span>
                                <span v-else>No access</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a :href="`${routes.editBase}/${userItem.id}/edit`" class="text-sm font-medium text-emerald-700 hover:text-emerald-600">Edit</a>
                                    <form :action="`${routes.editBase}/${userItem.id}`" method="POST">
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

            <p v-if="!users.length" class="app-empty mt-8">No users created yet.</p>
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';

defineProps({
    csrfToken: { type: String, required: true },
    layout: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    users: { type: Array, required: true },
});
</script>
