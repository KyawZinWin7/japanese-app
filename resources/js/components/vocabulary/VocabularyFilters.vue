<template>
    <form :action="action" method="GET" class="section-card">
        <div class="grid gap-4 md:grid-cols-[1fr,220px,220px,auto] md:items-end">
            <div>
                <label for="search" class="app-label">{{ t('vocabulary.filtersSearch') }}</label>
                <input id="search" name="search" type="text" :value="filters.search" :placeholder="t('vocabulary.filtersPlaceholder')" class="app-input">
            </div>
            <div>
                <label for="level" class="app-label">{{ t('vocabulary.filtersLevel') }}</label>
                <select id="level" v-model="selectedLevel" name="level" class="app-input">
                    <option value="">{{ t('vocabulary.filtersAllLevels') }}</option>
                    <option v-for="level in levels" :key="level.id" :value="level.slug">{{ level.name }}</option>
                </select>
            </div>
            <div v-if="filteredSources.length">
                <label for="source" class="app-label">{{ t('vocabulary.filtersSource') }}</label>
                <select id="source" v-model="selectedSource" name="source" class="app-input">
                    <option value="">{{ t('vocabulary.filtersAllCategories') }}</option>
                    <option v-for="source in filteredSources" :key="source.id" :value="source.slug">{{ source.name }}</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="app-btn">{{ t('vocabulary.filtersButton') }}</button>
                <a :href="action" class="app-btn-secondary">{{ t('vocabulary.filtersReset') }}</a>
            </div>
        </div>
    </form>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

import { t } from '../../frontendI18n';

const props = defineProps({
    action: { type: String, required: true },
    filters: { type: Object, required: true },
    levels: { type: Array, required: true },
    sources: { type: Array, default: () => [] },
});

const selectedLevel = ref(props.filters.level ?? '');
const selectedSource = ref(props.filters.source ?? '');

const filteredSources = computed(() => {
    if (! selectedLevel.value) {
        return [];
    }

    return props.sources.filter((source) => source.level.slug === selectedLevel.value);
});

watch(selectedLevel, () => {
    if (! filteredSources.value.find((source) => source.slug === selectedSource.value)) {
        selectedSource.value = '';
    }
});
</script>
