<template>
    <AdminLayout
        :actions="layout.actions"
        :csrf-token="csrfToken"
        :navigation="layout.navigation"
        :subtitle="layout.subtitle"
        :title="layout.title"
        :user="layout.user"
    >
        <main class="mx-auto max-w-5xl">
            <div class="mb-6">
                <p class="app-eyebrow">Admin</p>
                <h1 class="app-title">{{ mode === 'create' ? 'Create Example Word' : 'Edit Example Word' }}</h1>
                <p class="app-subtitle">Save one word once, then attach it to one or more kanji.</p>
            </div>

            <form :action="routes.action" method="POST" class="space-y-6 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <input type="hidden" name="_token" :value="csrfToken">
                <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
                <input type="hidden" name="is_published" value="0">

                <div class="grid gap-5 md:grid-cols-3">
                    <div>
                        <label for="jlpt_level_id" class="app-label">JLPT Level</label>
                        <select id="jlpt_level_id" v-model="selectedLevelId" name="jlpt_level_id" class="app-input" required>
                            <option value="">Choose a level</option>
                            <option v-for="level in levels" :key="level.id" :value="String(level.id)">{{ level.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="source_id" class="app-label">Book Category</label>
                        <select id="source_id" v-model="selectedSourceId" name="source_id" class="app-input">
                            <option value="">Choose a category</option>
                            <option v-for="source in availableSources" :key="source.id" :value="String(source.id)">{{ source.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="chapter" class="app-label">Chapter</label>
                        <input id="chapter" v-model="selectedChapter" name="chapter" type="text" class="app-input" placeholder="8">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="word" class="app-label">Word</label>
                        <input id="word" name="word" type="text" :value="item.word" class="app-input" required>
                    </div>
                    <div>
                        <label for="reading" class="app-label">Reading</label>
                        <input id="reading" name="reading" type="text" :value="item.reading" class="app-input" required>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="meaning" class="app-label">Meaning</label>
                        <input id="meaning" name="meaning" type="text" :value="item.meaning" class="app-input" required>
                    </div>
                    <div>
                        <label for="meaning_mm" class="app-label">Meaning (Myanmar)</label>
                        <input id="meaning_mm" name="meaning_mm" type="text" :value="item.meaning_mm" class="app-input">
                    </div>
                </div>

                <div>
                    <label class="app-label">Attach To Kanji</label>
                    <p class="mt-2 text-sm text-slate-500">Choose one or more kanji for this word, for example `友達` can be linked to `友` and `達`.</p>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        <label v-for="kanji in filteredKanjiOptions" :key="kanji.id" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <input type="checkbox" name="kanji_ids[]" :value="kanji.id" :checked="selectedKanjiIds.includes(kanji.id)">
                            <span class="text-2xl font-semibold text-slate-900">{{ kanji.character }}</span>
                            <span class="text-sm text-slate-500">{{ kanji.meaning }}</span>
                        </label>
                    </div>
                    <p v-if="!filteredKanjiOptions.length" class="mt-4 text-sm text-slate-500">No kanji match the current level/category/chapter yet.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="sort_order" class="app-label">Sort Order</label>
                        <input id="sort_order" name="sort_order" type="number" min="1" max="9999" :value="item.sort_order" class="app-input" required>
                    </div>
                    <label class="mt-7 flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="is_published" value="1" :checked="Boolean(Number(item.is_published) || item.is_published)">
                        Publish this example word
                    </label>
                </div>

                <div v-if="errorList.length" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p v-for="error in errorList" :key="error">{{ error }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="app-btn">{{ mode === 'create' ? 'Create Example Word' : 'Update Example Word' }}</button>
                    <a :href="routes.index" class="app-link">Back to example words</a>
                </div>
            </form>
        </main>
    </AdminLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import AdminLayout from '../../components/admin/AdminLayout.vue';

const props = defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    item: { type: Object, required: true },
    kanjiOptions: { type: Array, required: true },
    layout: { type: Object, required: true },
    levels: { type: Array, required: true },
    sources: { type: Array, default: () => [] },
    method: { type: String, required: true },
    mode: { type: String, required: true },
    routes: { type: Object, required: true },
});

const selectedLevelId = ref(props.item.jlpt_level_id ? String(props.item.jlpt_level_id) : '');
const selectedSourceId = ref(props.item.source_id ? String(props.item.source_id) : '');
const selectedChapter = ref(props.item.chapter ?? '');
const selectedKanjiIds = computed(() => (props.item.kanji_ids ?? []).map((id) => Number(id)));
const availableSources = computed(() => props.sources.filter((source) => String(source.jlpt_level_id) === selectedLevelId.value));
const filteredKanjiOptions = computed(() => props.kanjiOptions.filter((kanji) => {
    if (selectedLevelId.value && String(kanji.jlpt_level_id) !== selectedLevelId.value) {
        return false;
    }

    if (selectedSourceId.value && String(kanji.source_id) !== selectedSourceId.value) {
        return false;
    }

    if (selectedChapter.value && (kanji.chapter ?? '') !== selectedChapter.value) {
        return false;
    }

    return true;
}));
const errorList = computed(() => Object.values(props.errors).flat());
</script>
