<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
    <main class="mx-auto max-w-4xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-600">Admin</p>
            <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ mode === 'create' ? 'Create Lesson' : 'Edit Lesson' }}</h1>
            <p class="mt-2 text-slate-600">Fill in the lesson details, choose a JLPT level, and save.</p>
        </div>

        <LessonForm
            :action="routes.action"
            :csrf-token="csrfToken"
            :errors="errors"
            :index-url="routes.index"
            :lesson="lesson"
            :levels="levels"
            :method="method"
            :submit-label="mode === 'create' ? 'Create Lesson' : 'Update Lesson'"
        />
    </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import LessonForm from '../../components/lessons/LessonForm.vue';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    layout: { type: Object, required: true },
    lesson: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
});
</script>
