<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <main class="mx-auto max-w-6xl">
            <div class="mb-6">
                <p class="app-eyebrow">Admin</p>
                <h1 class="app-title">{{ mode === 'create' ? 'Create Exam Practice Set' : 'Edit Exam Practice Set' }}</h1>
                <p class="app-subtitle">Add standalone practice questions without changing the existing quiz module.</p>
            </div>

            <ExamPracticeForm
                :action="routes.action"
                :csrf-token="csrfToken"
                :errors="errors"
                :existing-sets="existingSets"
                :index-url="routes.index"
                :method="method"
                :set="set"
                :submit-label="mode === 'create' ? 'Create Set' : 'Update Set'"
            />
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import ExamPracticeForm from '../../components/exam-practice/ExamPracticeForm.vue';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    existingSets: { type: Array, default: () => [] },
    layout: { type: Object, required: true },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
    set: { type: Object, required: true },
});
</script>
