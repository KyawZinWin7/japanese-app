<template>
    <nav v-if="pagination.lastPage > 1" class="mt-8 flex flex-wrap items-center gap-2">
        <a
            v-for="link in pagination.links"
            :key="`${link.label}-${link.url ?? 'none'}`"
            :href="link.url || undefined"
            :class="[
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                link.active ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50',
                !link.url ? 'pointer-events-none opacity-50' : '',
            ]"
        >
            {{ normalizeLabel(link.label) }}
        </a>
    </nav>
</template>

<script setup>
import { t } from '../../frontendI18n';

defineProps({
    pagination: { type: Object, required: true },
});

function normalizeLabel(label) {
    return label
        .replace('&laquo; Previous', t('components.previous'))
        .replace('Next &raquo;', t('components.next'));
}
</script>
