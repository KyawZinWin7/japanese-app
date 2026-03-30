<template>
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_#dcfce7,_#f8fafc_34%,_#eef2ff)] p-3 md:p-6">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 lg:flex-row">
            <AdminSidebar :navigation="navigation" :user="user" />

            <div class="flex-1 space-y-6">
                <AdminTopbar
                    :actions="actions"
                    :csrf-token="csrfToken"
                    :subtitle="subtitle"
                    :title="title"
                />

                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminSidebar from './AdminSidebar.vue';
import AdminTopbar from './AdminTopbar.vue';

defineProps({
    actions: { type: Object, required: true },
    csrfToken: { type: String, required: true },
    navigation: { type: Array, required: true },
    subtitle: { type: String, required: true },
    title: { type: String, required: true },
    user: { type: Object, required: true },
});
</script>
