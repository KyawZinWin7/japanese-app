<template>
    <form :action="action" method="POST" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
        <input type="hidden" name="is_published" value="0">

        <div>
            <label for="jlpt_level_id" class="mb-2 block text-sm font-medium text-slate-700">JLPT Level</label>
            <select id="jlpt_level_id" v-model="selectedLevelId" name="jlpt_level_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
                <option value="">Choose a level</option>
                <option v-for="level in levels" :key="level.id" :value="String(level.id)">{{ level.name }}</option>
            </select>
            <p v-if="errors.jlpt_level_id?.length" class="mt-2 text-sm text-rose-600">{{ errors.jlpt_level_id[0] }}</p>
        </div>

        <div v-if="availableSources.length">
            <label for="source_id" class="mb-2 block text-sm font-medium text-slate-700">Book Category</label>
            <select id="source_id" v-model="selectedSourceId" name="source_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" :required="availableSources.length > 1">
                <option value="">Choose a category</option>
                <option v-for="source in availableSources" :key="source.id" :value="String(source.id)">{{ source.name }}</option>
            </select>
            <p v-if="errors.source_id?.length" class="mt-2 text-sm text-rose-600">{{ errors.source_id[0] }}</p>
        </div>

        <div>
            <label for="chapter" class="mb-2 block text-sm font-medium text-slate-700">Chapter</label>
            <input id="chapter" name="chapter" type="text" :value="item.chapter" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" placeholder="ဥပမာ - 1, 2, 3 or Chapter 1">
            <p v-if="errors.chapter?.length" class="mt-2 text-sm text-rose-600">{{ errors.chapter[0] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="word" class="mb-2 block text-sm font-medium text-slate-700">Word</label>
                <input id="word" name="word" type="text" :value="item.word" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
                <p v-if="errors.word?.length" class="mt-2 text-sm text-rose-600">{{ errors.word[0] }}</p>
            </div>
            <div>
                <label for="reading" class="mb-2 block text-sm font-medium text-slate-700">Reading</label>
                <input id="reading" name="reading" type="text" :value="item.reading" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
                <p v-if="errors.reading?.length" class="mt-2 text-sm text-rose-600">{{ errors.reading[0] }}</p>
            </div>
        </div>

        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
            <input id="slug" name="slug" type="text" :value="item.slug" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
            <p v-if="errors.slug?.length" class="mt-2 text-sm text-rose-600">{{ errors.slug[0] }}</p>
        </div>

        <div>
            <label for="meaning" class="mb-2 block text-sm font-medium text-slate-700">Meaning</label>
            <input id="meaning" name="meaning" type="text" :value="item.meaning" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
            <p v-if="errors.meaning?.length" class="mt-2 text-sm text-rose-600">{{ errors.meaning[0] }}</p>
        </div>

        <div>
            <label for="meaning_mm" class="mb-2 block text-sm font-medium text-slate-700">Meaning (Myanmar)</label>
            <input id="meaning_mm" name="meaning_mm" type="text" :value="item.meaning_mm" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" placeholder="ဥပမာ - မိတ်ဆွေ">
            <p v-if="errors.meaning_mm?.length" class="mt-2 text-sm text-rose-600">{{ errors.meaning_mm[0] }}</p>
        </div>

        <div>
            <label for="example_sentence" class="mb-2 block text-sm font-medium text-slate-700">Example Sentence</label>
            <textarea id="example_sentence" name="example_sentence" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500">{{ item.example_sentence }}</textarea>
        </div>

        <div>
            <label for="example_translation" class="mb-2 block text-sm font-medium text-slate-700">Example Translation</label>
            <textarea id="example_translation" name="example_translation" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500">{{ item.example_translation }}</textarea>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" min="1" max="9999" :value="item.sort_order" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
        </div>

        <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
            <input type="checkbox" name="is_published" value="1" :checked="Boolean(Number(item.is_published) || item.is_published)">
            Publish this vocabulary
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">{{ submitLabel }}</button>
            <a :href="indexUrl" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back to vocabulary</a>
        </div>
    </form>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    action: { type: String, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    indexUrl: { type: String, required: true },
    item: { type: Object, required: true },
    levels: { type: Array, required: true },
    sources: { type: Array, default: () => [] },
    method: { type: String, default: 'POST' },
    submitLabel: { type: String, required: true },
});

const selectedLevelId = ref(props.item.jlpt_level_id ? String(props.item.jlpt_level_id) : '');
const selectedSourceId = ref(props.item.source_id ? String(props.item.source_id) : '');

const availableSources = computed(() => props.sources.filter((source) => String(source.jlpt_level_id) === selectedLevelId.value));

watch(availableSources, (nextSources) => {
    if (! nextSources.find((source) => String(source.id) === selectedSourceId.value)) {
        selectedSourceId.value = '';
    }
}, { immediate: true });
</script>
