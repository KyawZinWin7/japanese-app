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
            <h1 class="app-title">{{ mode === 'create' ? 'Create Kanji' : 'Edit Kanji' }}</h1>
            <p class="app-subtitle">Enter the kanji, readings, meaning, and example usage.</p>
        </div>

        <KanjiForm
            :action="routes.action"
            :csrf-token="csrfToken"
            :errors="errors"
            :index-url="routes.index"
            :item="item"
            :levels="levels"
            :sources="sources"
            :method="method"
            :submit-label="mode === 'create' ? 'Create Kanji' : 'Update Kanji'"
        />
    </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/admin/AdminLayout.vue';
import KanjiForm from '../../components/kanji/KanjiForm.vue';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    layout: { type: Object, required: true },
    item: { type: Object, required: true },
    levels: { type: Array, required: true },
    sources: { type: Array, default: () => [] },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
});
</script>
