<template>
    <main class="page-shell max-w-5xl">
        <section class="section-card">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="app-eyebrow">{{ text.eyebrow }}</p>
                    <h1 class="app-title">{{ text.title }}</h1>
                    <p class="app-subtitle">{{ text.subtitle }}</p>
                </div>
                <a :href="routes.dashboard" class="app-link">{{ common.studyHome }}</a>
            </div>
        </section>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <section class="mt-8 section-card">
            <p class="app-eyebrow">{{ text.step1 }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseLevel }}</h2>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                <button v-for="level in levels" :key="level.id" type="button" :class="cardClass(selectedLevel === level.slug)" @click="selectedLevel = level.slug">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedLevel === level.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ common.level }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ level.name }}</span>
                </button>
            </div>
        </section>

        <section v-if="selectedLevel" class="mt-8 section-card">
            <p class="app-eyebrow">{{ text.step2 }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseType }}</h2>
            <div class="mt-6 grid gap-3 md:grid-cols-3">
                <button type="button" :class="cardClass(selectedType === 'kanji')" @click="selectedType = 'kanji'">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'kanji' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ text.kanjiFlashcards }}</span>
                </button>
                <button type="button" :class="cardClass(selectedType === 'vocabulary')" @click="selectedType = 'vocabulary'">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'vocabulary' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ text.vocabularyFlashcards }}</span>
                </button>
                <button type="button" :class="cardClass(selectedType === 'exampleWords')" @click="selectedType = 'exampleWords'">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'exampleWords' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ text.exampleWordFlashcards }}</span>
                </button>
            </div>
        </section>

        <section v-if="selectedType === 'exampleWords'" class="mt-8 section-card">
            <p class="app-eyebrow">{{ text.step3 }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseBookCategory }}</h2>
            <div v-if="availableSources.length" class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button v-for="source in availableSources" :key="source.slug" type="button" :class="cardClass(selectedSource === source.slug)" @click="selectedSource = source.slug">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedSource === source.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.bookCategory }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ source.name }}</span>
                </button>
            </div>
            <p v-else class="app-empty mt-6">{{ text.noBookCategories }}</p>
        </section>

        <section v-if="showChapterStep" class="mt-8 section-card">
            <p class="app-eyebrow">{{ chapterStepLabel }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseChapter }}</h2>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button type="button" :class="cardClass(selectedChapter === '__all__')" @click="selectedChapter = '__all__'">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === '__all__' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.option }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ text.all }}</span>
                </button>
                <button v-for="chapter in availableChapters" :key="chapter" type="button" :class="cardClass(selectedChapter === chapter)" @click="selectedChapter = chapter">
                    <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === chapter ? 'text-emerald-200' : 'text-emerald-700'">{{ common.chapter }}</span>
                    <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ chapterLabel(chapter) }}</span>
                </button>
            </div>
        </section>

        <section v-if="isReady" class="mt-8 section-card">
            <p class="app-eyebrow">{{ text.ready }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.openTitle }}</h2>
            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a :href="targetUrl" class="app-btn-accent">{{ text.openButton }}</a>
                <button type="button" class="app-btn-secondary" @click="reset">{{ text.startOver }}</button>
            </div>
        </section>
    </main>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { getLocale } from '../frontendI18n';

const props = defineProps({
    chapters: { type: Object, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    sources: { type: Object, default: () => ({}) },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});

const copy = {
    en: {
        common: {
            studyHome: 'Study Home',
            chapter: 'Chapter',
            level: 'Level',
        },
        flashcards: {
            eyebrow: 'Flashcards',
            title: 'Choose Your Flashcards',
            subtitle: 'Pick a level, choose a flashcard type, then open the study set you want.',
            step1: 'Step 1',
            chooseLevel: 'Choose Level',
            step2: 'Step 2',
            chooseType: 'Choose Flashcard Type',
            step3: 'Step 3',
            step4: 'Step 4',
            chooseBookCategory: 'Choose Book Category',
            chooseChapter: 'Choose Chapter Or All',
            ready: 'Ready',
            openTitle: 'Open Flashcards',
            openButton: 'Open Flashcards',
            startOver: 'Start Over',
            type: 'Type',
            option: 'Option',
            bookCategory: 'Book',
            all: 'All',
            noBookCategories: 'No book categories are available for this level yet.',
            kanjiFlashcards: 'Kanji Flashcards',
            vocabularyFlashcards: 'Vocabulary Flashcards',
            exampleWordFlashcards: 'Kanji Word Flashcards',
        },
    },
    my: {
        common: {
            studyHome: 'လေ့လာရန် ပင်မစာမျက်နှာ',
            chapter: 'အခန်း',
            level: 'Level',
        },
        flashcards: {
            eyebrow: 'Flashcards',
            title: 'Flashcards ကို ရွေးပါ',
            subtitle: 'Level ရွေးပါ၊ flashcard type ရွေးပါ၊ ပြီးမှ လေ့လာချင်တဲ့ set ကိုဖွင့်ပါ။',
            step1: 'အဆင့် ၁',
            chooseLevel: 'Level ရွေးပါ',
            step2: 'အဆင့် ၂',
            chooseType: 'Flashcard အမျိုးအစား ရွေးပါ',
            step3: 'အဆင့် ၃',
            step4: 'အဆင့် ၄',
            chooseBookCategory: 'စာအုပ် category ရွေးပါ',
            chooseChapter: 'Chapter သို့မဟုတ် All ကို ရွေးပါ',
            ready: 'အဆင်သင့်',
            openTitle: 'Flashcards ဖွင့်မည်',
            openButton: 'Flashcards ဖွင့်မည်',
            startOver: 'အစမှ ပြန်စမည်',
            type: 'အမျိုးအစား',
            option: 'ရွေးချယ်မှု',
            bookCategory: 'စာအုပ်',
            all: 'အားလုံး',
            noBookCategories: 'ဒီ level အတွက် စာအုပ် category မရှိသေးပါ။',
            kanjiFlashcards: 'Kanji Flashcards',
            vocabularyFlashcards: 'Vocabulary Flashcards',
            exampleWordFlashcards: 'Kanji Word Flashcards',
        },
    },
};

const locale = computed(() => getLocale());
const text = computed(() => copy[locale.value]?.flashcards ?? copy.en.flashcards);
const common = computed(() => copy[locale.value]?.common ?? copy.en.common);

const selectedLevel = ref('');
const selectedType = ref('');
const selectedSource = ref('');
const selectedChapter = ref('');

const availableSources = computed(() => {
    if (!selectedLevel.value || selectedType.value !== 'exampleWords') {
        return [];
    }

    return props.sources.exampleWords?.[selectedLevel.value] ?? [];
});

const availableChapters = computed(() => {
    if (!selectedLevel.value || !selectedType.value) {
        return [];
    }

    if (selectedType.value === 'exampleWords') {
        if (!selectedSource.value) {
            return [];
        }

        return props.chapters.exampleWords?.[`${selectedLevel.value}|${selectedSource.value}`] ?? [];
    }

    return props.chapters[selectedType.value]?.[selectedLevel.value] ?? [];
});

const showChapterStep = computed(() => {
    if (!selectedType.value) {
        return false;
    }

    if (selectedType.value === 'exampleWords') {
        return selectedSource.value !== '';
    }

    return true;
});

const chapterStepLabel = computed(() => selectedType.value === 'exampleWords' ? text.value.step4 : text.value.step3);

const isReady = computed(() => {
    if (!selectedType.value || !selectedChapter.value) {
        return false;
    }

    return selectedType.value !== 'exampleWords' || selectedSource.value !== '';
});

const targetUrl = computed(() => {
    const base = selectedType.value === 'vocabulary'
        ? props.routes.vocabulary
        : (selectedType.value === 'exampleWords' ? props.routes.exampleWords : props.routes.kanji);

    const url = new URL(base, window.location.origin);
    url.searchParams.set('level', selectedLevel.value);

    if (selectedType.value === 'exampleWords' && selectedSource.value) {
        url.searchParams.set('source', selectedSource.value);
    }

    if (selectedChapter.value !== '__all__') {
        url.searchParams.set('chapter', selectedChapter.value);
    }

    return `${url.pathname}${url.search}`;
});

watch(selectedLevel, () => {
    selectedType.value = '';
    selectedSource.value = '';
    selectedChapter.value = '';
});

watch(selectedType, () => {
    selectedSource.value = '';
    selectedChapter.value = '';
});

watch(selectedSource, () => {
    selectedChapter.value = '';
});

function chapterLabel(chapter) {
    return /^\d+$/.test(chapter) ? `${common.value.chapter} ${chapter}` : chapter;
}

function cardClass(active) {
    return [
        'rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5',
        active
            ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]'
            : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]',
    ];
}

function reset() {
    selectedLevel.value = '';
    selectedType.value = '';
    selectedSource.value = '';
    selectedChapter.value = '';
}
</script>
