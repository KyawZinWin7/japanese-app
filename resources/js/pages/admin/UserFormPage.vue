<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <main class="mx-auto max-w-4xl rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <div>
                <p class="app-eyebrow">Admin</p>
                <h1 class="app-title">{{ mode === 'create' ? 'Create User' : 'Edit User' }}</h1>
                <p class="app-subtitle">Assign learner login details, approval status, and JLPT study access.</p>
            </div>

            <form :action="routes.action" method="POST" class="mt-8 space-y-6">
                <input type="hidden" name="_token" :value="csrfToken">
                <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="app-label" for="name">Name</label>
                        <input id="name" name="name" type="text" class="app-input" :value="userItem.name">
                        <p v-if="errors.name?.length" class="app-help">{{ errors.name[0] }}</p>
                    </div>
                    <div>
                        <label class="app-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="app-input" :value="userItem.email">
                        <p v-if="errors.email?.length" class="app-help">{{ errors.email[0] }}</p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="app-label" for="password">Password</label>
                        <input id="password" name="password" type="password" class="app-input">
                        <p class="mt-2 text-sm text-slate-500" v-if="mode === 'edit'">Leave blank to keep the current password.</p>
                        <p v-if="errors.password?.length" class="app-help">{{ errors.password[0] }}</p>
                    </div>
                    <div>
                        <label class="app-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="app-input">
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="section-card">
                        <label class="flex items-center gap-3 text-sm font-medium text-slate-700">
                            <input type="hidden" name="is_admin" value="0">
                            <input type="checkbox" name="is_admin" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600" :checked="userItem.is_admin" @change="isAdmin = $event.target.checked">
                            Admin account
                        </label>
                        <p class="mt-2 text-sm text-slate-500">Admins can manage users and all learning content without JLPT restrictions.</p>
                    </div>

                    <div class="section-card" :class="isAdmin ? 'opacity-50' : ''">
                        <label class="flex items-center gap-3 text-sm font-medium text-slate-700">
                            <input type="hidden" name="is_approved" value="0">
                            <input :disabled="isAdmin" type="checkbox" name="is_approved" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600" :checked="userItem.is_approved || userItem.is_admin">
                            Approved learner
                        </label>
                        <p class="mt-2 text-sm text-slate-500">Approved learners can access the study home and learning pages.</p>
                    </div>
                </div>

                <div class="section-card" :class="isAdmin ? 'opacity-50' : ''">
                    <p class="app-label">Allowed JLPT Levels</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                        <label v-for="level in levels" :key="level.id" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
                            <input :disabled="isAdmin" type="checkbox" name="jlpt_levels[]" :value="level.id" class="h-4 w-4 rounded border-slate-300 text-emerald-600" :checked="userItem.jlpt_levels.includes(level.id)">
                            <span>{{ level.name }}</span>
                        </label>
                    </div>
                    <p v-if="errors.jlpt_levels?.length" class="app-help">{{ errors.jlpt_levels[0] }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="app-btn">{{ mode === 'create' ? 'Create User' : 'Update User' }}</button>
                    <a :href="routes.index" class="app-link">Back to users</a>
                </div>
            </form>
        </main>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import AdminLayout from '../../components/admin/AdminLayout.vue';

const props = defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
    userItem: { type: Object, required: true },
});

const isAdmin = ref(props.userItem.is_admin);
</script>
