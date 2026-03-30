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
                <p class="app-eyebrow">Admin</p>
                <h1 class="app-title">{{ mode === 'create' ? 'Create Source' : 'Edit Source' }}</h1>
                <p class="app-subtitle">Set the JLPT level, source name, and supported content types.</p>
            </div>

            <SourceForm
                :action="routes.action"
                :content-types="contentTypes"
                :csrf-token="csrfToken"
                :errors="errors"
                :index-url="routes.index"
                :item="item"
                :levels="levels"
                :method="method"
                :submit-label="mode === 'create' ? 'Create Source' : 'Update Source'"
            />
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import SourceForm from '../../components/sources/SourceForm.vue';

defineProps({
    contentTypes: { type: Array, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    item: { type: Object, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
});
</script>
