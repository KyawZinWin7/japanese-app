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

        <section class="mt-8 space-y-8 md:hidden">
            <section class="section-card">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="app-eyebrow">{{ mobileStepBadge }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ mobileStepTitle }}</h2>
                    </div>
                    <button
                        v-if="mobileStep > 1"
                        type="button"
                        class="app-btn-secondary"
                        @click="goBack"
                    >
                        {{ text.back }}
                    </button>
                </div>

                <p v-if="mobileHint" class="mt-4 text-sm leading-7 text-slate-600">{{ mobileHint }}</p>

                <div v-if="mobileStep === 1" class="mt-6 grid gap-3">
                    <button
                        v-for="level in levels"
                        :key="level.id"
                        type="button"
                        :class="cardClass(selectedLevel === level.slug)"
                        @click="selectLevel(level.slug)"
                    >
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedLevel === level.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ common.level }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ level.name }}</span>
                    </button>
                </div>

                <div v-else-if="mobileStep === 2" class="mt-6 grid gap-3">
                    <button type="button" :class="cardClass(selectedType === 'kanji')" @click="selectType('kanji')">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'kanji' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ text.kanjiFlashcards }}</span>
                    </button>
                    <button type="button" :class="cardClass(selectedType === 'vocabulary')" @click="selectType('vocabulary')">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'vocabulary' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ text.vocabularyFlashcards }}</span>
                    </button>
                    <button type="button" :class="cardClass(selectedType === 'exampleWords')" @click="selectType('exampleWords')">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedType === 'exampleWords' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.type }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ text.exampleWordFlashcards }}</span>
                    </button>
                </div>

                <div v-else-if="mobileStep === 3 && needsSourceStep" class="mt-6">
                    <div v-if="availableSources.length" class="grid gap-3">
                        <button
                            v-for="source in availableSources"
                            :key="source.slug"
                            type="button"
                            :class="cardClass(selectedSource === source.slug)"
                            @click="selectSource(source.slug)"
                        >
                            <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedSource === source.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.bookCategory }}</span>
                            <span class="mt-3 block text-2xl font-semibold">{{ source.name }}</span>
                        </button>
                    </div>
                    <p v-else class="app-empty mt-2">{{ text.noBookCategories }}</p>
                </div>

                <div v-else-if="mobileStep === chapterStepIndex" class="mt-6 grid gap-3">
                    <button type="button" :class="cardClass(selectedChapter === '__all__')" @click="selectChapter('__all__')">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === '__all__' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.option }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ text.all }}</span>
                    </button>
                    <button
                        v-for="chapter in availableChapters"
                        :key="chapter"
                        type="button"
                        :class="cardClass(selectedChapter === chapter)"
                        @click="selectChapter(chapter)"
                    >
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === chapter ? 'text-emerald-200' : 'text-emerald-700'">{{ common.chapter }}</span>
                        <span class="mt-3 block text-2xl font-semibold">{{ chapterLabel(chapter) }}</span>
                    </button>
                </div>

                <div v-if="mobileStep === chapterStepIndex && selectedChapter" class="mt-6">
                    <button type="button" class="app-btn-secondary w-full" @click="reset">{{ text.startOver }}</button>
                </div>
            </section>
        </section>

        <div class="hidden md:block">
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
                    <button type="button" :class="cardClass(selectedChapter === '__all__')" @click="selectChapter('__all__')">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === '__all__' ? 'text-emerald-200' : 'text-emerald-700'">{{ text.option }}</span>
                        <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ text.all }}</span>
                    </button>
                    <button v-for="chapter in availableChapters" :key="chapter" type="button" :class="cardClass(selectedChapter === chapter)" @click="selectChapter(chapter)">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === chapter ? 'text-emerald-200' : 'text-emerald-700'">{{ common.chapter }}</span>
                        <span class="mt-3 block text-2xl font-semibold sm:text-3xl">{{ chapterLabel(chapter) }}</span>
                    </button>
                </div>
            </section>

            <div class="mt-8 flex justify-end">
                <button type="button" class="app-btn-secondary" @click="reset">{{ text.startOver }}</button>
            </div>
        </div>
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
            back: 'Back',
            next: 'Next',
            reviewSelection: 'Review Selection',
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
            studyHome: 'á€œá€±á€·á€œá€¬á€›á€”á€º á€•á€„á€ºá€™á€…á€¬á€™á€»á€€á€ºá€”á€¾á€¬',
            chapter: 'á€¡á€á€”á€ºá€¸',
            level: 'Level',
        },
        flashcards: {
            eyebrow: 'Flashcards',
            title: 'Flashcards á€€á€­á€¯ á€›á€½á€±á€¸á€•á€«',
            subtitle: 'Level á€›á€½á€±á€¸á€•á€«áŠ flashcard type á€›á€½á€±á€¸á€•á€«áŠ á€•á€¼á€®á€¸á€™á€¾ á€œá€±á€·á€œá€¬á€á€»á€„á€ºá€á€²á€· set á€€á€­á€¯á€–á€½á€„á€·á€ºá€•á€«á‹',
            step1: 'á€¡á€†á€„á€·á€º á',
            chooseLevel: 'Level á€›á€½á€±á€¸á€•á€«',
            step2: 'á€¡á€†á€„á€·á€º á‚',
            chooseType: 'Flashcard á€¡á€™á€»á€­á€¯á€¸á€¡á€…á€¬á€¸ á€›á€½á€±á€¸á€•á€«',
            step3: 'á€¡á€†á€„á€·á€º áƒ',
            step4: 'á€¡á€†á€„á€·á€º á„',
            chooseBookCategory: 'á€…á€¬á€¡á€¯á€•á€º category á€›á€½á€±á€¸á€•á€«',
            chooseChapter: 'Chapter á€žá€­á€¯á€·á€™á€Ÿá€¯á€á€º All á€€á€­á€¯ á€›á€½á€±á€¸á€•á€«',
            ready: 'á€¡á€†á€„á€ºá€žá€„á€·á€º',
            openTitle: 'Flashcards á€–á€½á€„á€·á€ºá€™á€Šá€º',
            openButton: 'Flashcards á€–á€½á€„á€·á€ºá€™á€Šá€º',
            startOver: 'á€¡á€…á€™á€¾ á€•á€¼á€”á€ºá€…á€™á€Šá€º',
            back: 'á€•á€¼á€”á€ºá€™á€Šá€º',
            next: 'á€›á€¾á€±á€·á€žá€­á€¯á€·',
            reviewSelection: 'á€›á€½á€±á€¸á€‘á€¬á€¸á€™á€¾á€¯ á€•á€¼á€”á€ºá€€á€¼á€Šá€·á€ºá€™á€Šá€º',
            type: 'á€¡á€™á€»á€­á€¯á€¸á€¡á€…á€¬á€¸',
            option: 'á€›á€½á€±á€¸á€á€»á€šá€ºá€™á€¾á€¯',
            bookCategory: 'á€…á€¬á€¡á€¯á€•á€º',
            all: 'á€¡á€¬á€¸á€œá€¯á€¶á€¸',
            noBookCategories: 'á€’á€® level á€¡á€á€½á€€á€º á€…á€¬á€¡á€¯á€•á€º category á€™á€›á€¾á€­á€žá€±á€¸á€•á€«á‹',
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
const mobileStep = ref(1);

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

const needsSourceStep = computed(() => selectedType.value === 'exampleWords');
const chapterStepIndex = computed(() => (needsSourceStep.value ? 4 : 3));

const showChapterStep = computed(() => {
    if (!selectedType.value) {
        return false;
    }

    if (needsSourceStep.value) {
        return selectedSource.value !== '';
    }

    return true;
});

const chapterStepLabel = computed(() => needsSourceStep.value ? text.value.step4 : text.value.step3);

const selectedLevelName = computed(() => props.levels.find((level) => level.slug === selectedLevel.value)?.name ?? '');

const selectedTypeLabel = computed(() => {
    if (selectedType.value === 'kanji') {
        return text.value.kanjiFlashcards;
    }

    if (selectedType.value === 'vocabulary') {
        return text.value.vocabularyFlashcards;
    }

    if (selectedType.value === 'exampleWords') {
        return text.value.exampleWordFlashcards;
    }

    return '';
});

const selectedSourceName = computed(() => availableSources.value.find((source) => source.slug === selectedSource.value)?.name ?? '');
const selectedChapterLabel = computed(() => selectedChapter.value === '__all__' ? text.value.all : chapterLabel(selectedChapter.value));

const mobileStepBadge = computed(() => {
    return mobileStep.value === 4 && !needsSourceStep.value ? text.value.step3 : `Step ${mobileStep.value}`;
});

const mobileStepTitle = computed(() => {
    if (mobileStep.value === 1) {
        return text.value.chooseLevel;
    }

    if (mobileStep.value === 2) {
        return text.value.chooseType;
    }

    if (mobileStep.value === 3 && needsSourceStep.value) {
        return text.value.chooseBookCategory;
    }

    if (mobileStep.value === chapterStepIndex.value) {
        return text.value.chooseChapter;
    }
    return text.value.chooseChapter;
});

const mobileHint = computed(() => {
    if (mobileStep.value === 1) {
        return text.value.subtitle;
    }

    if (mobileStep.value === chapterStepIndex.value && !availableChapters.value.length) {
        return text.value.noBookCategories;
    }

    return '';
});

function buildTargetUrl(level, type, source, chapter) {
    const base = type === 'vocabulary'
        ? props.routes.vocabulary
        : (type === 'exampleWords' ? props.routes.exampleWords : props.routes.kanji);
    const url = new URL(base, window.location.origin);
    url.searchParams.set('level', level);

    if (type === 'exampleWords' && source) {
        url.searchParams.set('source', source);
    }

    if (chapter !== '__all__') {
        url.searchParams.set('chapter', chapter);
    }

    return `${url.pathname}${url.search}`;
}

const targetUrl = computed(() => buildTargetUrl(
    selectedLevel.value,
    selectedType.value,
    selectedSource.value,
    selectedChapter.value,
));

watch(selectedLevel, () => {
    selectedType.value = '';
    selectedSource.value = '';
    selectedChapter.value = '';
    mobileStep.value = 1;
});

watch(selectedType, () => {
    selectedSource.value = '';
    selectedChapter.value = '';

    if (!selectedType.value && mobileStep.value > 2) {
        mobileStep.value = 2;
    }
});

watch(selectedSource, () => {
    selectedChapter.value = '';
});

function chapterLabel(chapter) {
    if (!chapter) {
        return '';
    }

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

function goBack() {
    mobileStep.value = Math.max(mobileStep.value - 1, 1);
}

function selectLevel(levelSlug) {
    selectedLevel.value = levelSlug;
    mobileStep.value = 2;
}

function selectType(type) {
    selectedType.value = type;
    mobileStep.value = type === 'exampleWords' ? 3 : chapterStepIndex.value;
}

function selectSource(sourceSlug) {
    selectedSource.value = sourceSlug;
    mobileStep.value = chapterStepIndex.value;
}

function selectChapter(chapter) {
    selectedChapter.value = chapter;
    const url = buildTargetUrl(
        selectedLevel.value,
        selectedType.value,
        selectedSource.value,
        chapter,
    );
    window.location.assign(url);
}

function reset() {
    selectedLevel.value = '';
    selectedType.value = '';
    selectedSource.value = '';
    selectedChapter.value = '';
    mobileStep.value = 1;
}
</script>
