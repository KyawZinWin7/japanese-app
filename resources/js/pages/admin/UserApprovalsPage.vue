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
                    <h1 class="app-title">Learner Approvals</h1>
                    <p class="app-subtitle">Search learners, filter by status, and approve or reject registrations.</p>
                </div>
                <a :href="routes.editBase" class="app-link">Manage all users</a>
            </div>

            <p v-if="status" class="app-status mt-6">{{ status }}</p>

            <form :action="routes.index" method="GET" class="mt-8 grid gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 md:grid-cols-[1fr,220px,auto]">
                <div>
                    <label class="app-label" for="search">Search learner</label>
                    <input id="search" name="search" type="text" class="app-input mt-2" :value="filters.search" placeholder="Search by name or email">
                </div>
                <div>
                    <label class="app-label" for="status">Status</label>
                    <select id="status" name="status" class="app-input mt-2">
                        <option value="pending" :selected="filters.status === 'pending'">Pending</option>
                        <option value="approved" :selected="filters.status === 'approved'">Approved</option>
                        <option value="all" :selected="filters.status === 'all'">All learners</option>
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="app-btn">Apply</button>
                    <a :href="routes.index" class="app-link">Reset</a>
                </div>
            </form>

            <div v-if="users.length" class="mt-8 grid gap-4">
                <article v-for="userItem in users" :key="userItem.id" class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <p class="text-lg font-semibold text-slate-900">{{ userItem.name }}</p>
                                <span :class="userItem.is_approved ? 'bg-sky-100 text-sky-700' : 'bg-amber-100 text-amber-700'" class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                    {{ userItem.is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-slate-600">{{ userItem.email }}</p>
                            <p class="mt-4 text-sm text-slate-500">
                                Assigned levels:
                                <span class="font-medium text-slate-700">{{ userItem.levels.length ? userItem.levels.map(level => level.name).join(', ') : 'No levels assigned yet' }}</span>
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a :href="`${routes.editBase}/${userItem.id}/edit`" class="app-link">Edit user</a>
                            <form v-if="!userItem.is_approved" :action="`${routes.approveBase}/${userItem.id}/approve`" method="POST">
                                <input type="hidden" name="_token" :value="csrfToken">
                                <button type="submit" class="app-btn">Approve learner</button>
                            </form>
                            <form v-if="!userItem.is_approved" :action="`${routes.rejectBase}/${userItem.id}/reject`" method="POST">
                                <input type="hidden" name="_token" :value="csrfToken">
                                <button type="submit" class="rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Reject</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>

            <p v-else class="app-empty mt-8">No learners match the current filter.</p>
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';

defineProps({
    csrfToken: { type: String, required: true },
    filters: { type: Object, required: true },
    layout: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    users: { type: Array, required: true },
});
</script>
