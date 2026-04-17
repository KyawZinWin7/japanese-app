<template>
    <form :action="action" method="POST" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
        <input type="hidden" name="is_published" value="0">

        <div>
            <label for="jlpt_level_id" class="app-label">JLPT Level</label>
            <select id="jlpt_level_id" v-model="selectedLevelId" name="jlpt_level_id" class="app-input" required>
                <option value="">Choose a level</option>
                <option v-for="level in levels" :key="level.id" :value="String(level.id)">{{ level.name }}</option>
            </select>
            <p v-if="errors.jlpt_level_id?.length" class="app-help">{{ errors.jlpt_level_id[0] }}</p>
        </div>

        <div v-if="availableSources.length">
            <label for="source_id" class="app-label">Book Category</label>
            <select id="source_id" v-model="selectedSourceId" name="source_id" class="app-input" :required="availableSources.length > 1">
                <option value="">Choose a category</option>
                <option v-for="source in availableSources" :key="source.id" :value="String(source.id)">{{ source.name }}</option>
            </select>
            <p v-if="errors.source_id?.length" class="app-help">{{ errors.source_id[0] }}</p>
        </div>

        <div>
            <label for="chapter" class="app-label">Chapter</label>
            <input id="chapter" v-model="chapterValue" name="chapter" type="text" class="app-input" placeholder="Example - 1, 2, 3 or Chapter 1">
            <p v-if="errors.chapter?.length" class="app-help">{{ errors.chapter[0] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="character" class="app-label">Kanji</label>
                <input id="character" v-model="characterValue" name="character" type="text" class="app-input text-3xl" required>
                <p v-if="errors.character?.length" class="app-help">{{ errors.character[0] }}</p>
            </div>
            <div>
                <label for="slug" class="app-label">Slug</label>
                <input id="slug" v-model="slugValue" name="slug" type="text" class="app-input" @input="handleSlugInput">
                <p class="app-help">Auto-generated from meaning. You can change it if needed, for example <code>benkyou-kanji</code>.</p>
                <p v-if="errors.slug?.length" class="app-help">{{ errors.slug[0] }}</p>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="onyomi" class="app-label">Onyomi</label>
                <textarea id="onyomi" name="onyomi" rows="3" class="app-input" placeholder="Example: イチ, イツ">{{ item.onyomi }}</textarea>
                <p class="app-help">You can enter one reading per line or separate them with commas.</p>
            </div>
            <div>
                <label for="kunyomi" class="app-label">Kunyomi</label>
                <textarea id="kunyomi" name="kunyomi" rows="3" class="app-input" placeholder="Example: ひと-つ, ひと-り">{{ item.kunyomi }}</textarea>
                <p class="app-help">Example: <code>あぶ-ない, あや-うい</code></p>
            </div>
        </div>

        <div>
            <label for="meaning" class="app-label">Meaning</label>
            <input id="meaning" v-model="meaningValue" name="meaning" type="text" class="app-input" required>
            <p v-if="errors.meaning?.length" class="app-help">{{ errors.meaning[0] }}</p>
        </div>

        <div>
            <label for="meaning_mm" class="app-label">Meaning (Myanmar)</label>
            <input id="meaning_mm" name="meaning_mm" type="text" :value="item.meaning_mm" class="app-input" placeholder="Example - help, support">
            <p v-if="errors.meaning_mm?.length" class="app-help">{{ errors.meaning_mm[0] }}</p>
        </div>

        <div>
            <label for="example_sentence" class="app-label">Example Sentence</label>
            <textarea id="example_sentence" name="example_sentence" rows="3" class="app-input">{{ item.example_sentence }}</textarea>
        </div>

        <div>
            <label for="example_translation" class="app-label">Example Translation</label>
            <textarea id="example_translation" name="example_translation" rows="3" class="app-input">{{ item.example_translation }}</textarea>
        </div>

        <div>
            <label for="example_translation_mm" class="app-label">Example Translation (Myanmar)</label>
            <textarea id="example_translation_mm" name="example_translation_mm" rows="3" class="app-input">{{ item.example_translation_mm }}</textarea>
        </div>

        <div>
            <label for="sort_order" class="app-label">Sort Order</label>
            <input id="sort_order" v-model="sortOrderValue" name="sort_order" type="number" min="1" max="9999" class="app-input" @input="handleSortOrderInput">
            <p class="app-help">Auto-generated as the next number for this level, category, and chapter. Smaller numbers show first.</p>
            <p v-if="errors.sort_order?.length" class="app-help">{{ errors.sort_order[0] }}</p>
        </div>

        <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
            <input type="checkbox" name="is_published" value="1" :checked="Boolean(Number(item.is_published) || item.is_published)">
            Publish this kanji
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="app-btn">{{ submitLabel }}</button>
            <a :href="indexUrl" class="app-link">Back to kanji</a>
        </div>
    </form>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    action: { type: String, required: true },
    csrfToken: { type: String, required: true },
    existingKanji: { type: Array, default: () => [] },
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
const chapterValue = ref(props.item.chapter ?? '');
const characterValue = ref(props.item.character ?? '');
const meaningValue = ref(props.item.meaning ?? '');
const slugValue = ref(props.item.slug ?? '');
const sortOrderValue = ref(props.item.sort_order ? String(props.item.sort_order) : '');
const slugEditedManually = ref(Boolean(props.item.slug));
const sortOrderEditedManually = ref(Boolean(props.item.sort_order));
const currentKanjiId = props.item.id ?? null;

const availableSources = computed(() => props.sources.filter((source) => String(source.jlpt_level_id) === selectedLevelId.value));

const existingSlugs = computed(() => new Set(
    props.existingKanji
        .filter((item) => item.id !== currentKanjiId)
        .map((item) => item.slug),
));

watch(availableSources, (nextSources) => {
    if (! nextSources.find((source) => String(source.id) === selectedSourceId.value)) {
        selectedSourceId.value = '';
    }
}, { immediate: true });

watch([meaningValue, characterValue], () => {
    if (! slugEditedManually.value) {
        slugValue.value = buildSuggestedSlug();
    }
}, { immediate: true });

watch([selectedLevelId, selectedSourceId, chapterValue], () => {
    if (! sortOrderEditedManually.value) {
        sortOrderValue.value = buildSuggestedSortOrder();
    }
}, { immediate: true });

function buildSuggestedSlug() {
    const baseSource = meaningValue.value || characterValue.value;
    const normalized = String(baseSource)
        .toLowerCase()
        .trim()
        .replace(/['"]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    const base = normalized ? (normalized.endsWith('-kanji') ? normalized : `${normalized}-kanji`) : 'kanji-item';

    if (! existingSlugs.value.has(base)) {
        return base;
    }

    let suffix = 2;
    let candidate = `${base}-${suffix}`;

    while (existingSlugs.value.has(candidate)) {
        suffix += 1;
        candidate = `${base}-${suffix}`;
    }

    return candidate;
}

function buildSuggestedSortOrder() {
    if (! selectedLevelId.value) {
        return '1';
    }

    const chapter = normalizeScopeValue(chapterValue.value);
    const sourceId = normalizeScopeValue(selectedSourceId.value);
    const levelId = normalizeScopeValue(selectedLevelId.value);

    const maxSortOrder = props.existingKanji
        .filter((item) => item.id !== currentKanjiId)
        .filter((item) => String(item.jlpt_level_id ?? '') === levelId)
        .filter((item) => normalizeScopeValue(item.source_id) === sourceId)
        .filter((item) => normalizeScopeValue(item.chapter) === chapter)
        .reduce((maxValue, item) => Math.max(maxValue, Number(item.sort_order) || 0), 0);

    return String(maxSortOrder + 1);
}

function normalizeScopeValue(value) {
    if (value === null || value === undefined) {
        return '';
    }

    return String(value).trim();
}

function handleSlugInput(event) {
    slugEditedManually.value = event.target.value !== '';
}

function handleSortOrderInput(event) {
    sortOrderEditedManually.value = event.target.value !== '';
}
</script>
