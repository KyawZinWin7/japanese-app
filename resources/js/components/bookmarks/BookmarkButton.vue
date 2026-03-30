<template>
    <form :action="action" method="POST">
        <input type="hidden" name="_token" :value="csrfToken">
        <button type="submit" :class="buttonClass">
            {{ isBookmarked ? resolvedActiveLabel : resolvedInactiveLabel }}
        </button>
    </form>
</template>

<script setup>
import { computed } from 'vue';

import { t } from '../../frontendI18n';

const props = defineProps({
    action: { type: String, required: true },
    activeLabel: { type: String, default: '' },
    csrfToken: { type: String, required: true },
    inactiveLabel: { type: String, default: '' },
    isBookmarked: { type: Boolean, required: true },
});

const resolvedActiveLabel = computed(() => props.activeLabel || t('components.bookmarked'));
const resolvedInactiveLabel = computed(() => props.inactiveLabel || t('components.bookmark'));

const buttonClass = computed(() => [
    'inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-semibold transition',
    props.isBookmarked
        ? 'bg-amber-300 text-slate-900 shadow-sm hover:bg-amber-200'
        : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100',
]);
</script>
