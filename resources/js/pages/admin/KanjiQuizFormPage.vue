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
                <h1 class="app-title">{{ mode === 'create' ? 'Create Quiz' : 'Edit Quiz' }}</h1>
                <p class="app-subtitle">Choose a JLPT level, add quiz questions, and save the quiz.</p>
            </div>

            <KanjiQuizForm
                :action="routes.action"
                :csrf-token="csrfToken"
                :errors="errors"
                :existing-quizzes="existingQuizzes"
                :index-url="routes.index"
                :levels="levels"
                :method="method"
                :quiz="quiz"
                :submit-label="mode === 'create' ? 'Create Quiz' : 'Update Quiz'"
            />
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import KanjiQuizForm from '../../components/quizzes/KanjiQuizForm.vue';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    existingQuizzes: { type: Array, default: () => [] },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    quiz: { type: Object, required: true },
    routes: { type: Object, required: true },
});
</script>
