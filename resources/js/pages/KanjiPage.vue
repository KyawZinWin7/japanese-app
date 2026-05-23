<template>
    <main class="page-shell">
        <section class="relative overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-[linear-gradient(135deg,rgba(15,23,42,0.96),rgba(6,78,59,0.88))] px-4 py-6 text-white shadow-[0_24px_80px_-32px_rgba(15,23,42,0.7)] sm:px-5 sm:py-7 md:rounded-[2rem] md:px-8 md:py-8">
            <div class="absolute inset-y-0 right-0 w-1/2 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_55%)]"></div>
            <div class="relative flex flex-wrap items-start justify-between gap-4">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-emerald-200">{{ text.tracks }}</p>
                    <h1 class="mt-4 text-2xl font-semibold tracking-tight sm:text-3xl md:text-5xl">{{ text.heroTitle }}</h1>
                    <p class="mt-4 max-w-2xl text-[15px] leading-7 text-slate-200">{{ text.heroText }}</p>
                </div>
                <div class="flex w-full flex-wrap items-center gap-3 md:w-auto">
                    <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="rounded-2xl bg-white/12 px-4 py-3 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-white/18">{{ viewer.isAuthenticated ? common.studyHome : common.login }}</a>
                    <a :href="previewUrl" class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-emerald-50">{{ text.openFirst }}</a>
                </div>
            </div>
        </section>

        <p v-if="status" class="app-status mt-6">{{ status }}</p>

        <section class="mt-8 space-y-8 md:hidden">
            <section class="rounded-[1.5rem] border border-slate-200/80 bg-white/90 p-4 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="app-eyebrow">{{ mobileStepLabel }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ mobileStepTitle }}</h2>
                    </div>
                    <button v-if="mobileStep > 1" type="button" class="app-btn-secondary" @click="goBack">{{ text.back }}</button>
                </div>

                <p v-if="mobileStep === 1" class="mt-4 text-sm text-slate-600">{{ text.step1Text }}</p>
                <p v-else-if="mobileStep === 2" class="mt-4 text-sm text-slate-600">
                    <span v-if="requiresCategory">{{ replace(text.chooseTrackForLevel, { level: selectedLevelName }) }}</span>
                    <span v-else>{{ replace(text.noSeparateCategory, { level: selectedLevelName }) }}</span>
                </p>
                <p v-else class="mt-4 text-sm text-slate-600">
                    <span v-if="requiresChapter">{{ replace(text.pickChapter, { track: selectedTrackLabel }) }}</span>
                    <span v-else>{{ text.noChapterSplit }}</span>
                </p>

                <div v-if="mobileStep === 1" class="mt-6 grid gap-3">
                    <button v-for="level in levels" :key="level.id" type="button" :class="levelCardClass(level.slug)" @click="selectLevel(level.slug, true)">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedLevel === level.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.level }}</span>
                        <span class="mt-4 block text-3xl font-semibold">{{ level.name }}</span>
                        <span class="mt-3 block text-sm leading-6" :class="selectedLevel === level.slug ? 'text-slate-200' : 'text-slate-500'">{{ selectedLevel === level.slug ? text.selectedContinue : text.tapOpenTracks }}</span>
                    </button>
                </div>

                <div v-else-if="mobileStep === 2" class="mt-6">
                    <div v-if="availableCategories.length" class="grid gap-3">
                        <button v-for="category in availableCategories" :key="category.id" type="button" :class="categoryCardClass(category.slug)" @click="selectCategory(category.slug, true)">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedSource === category.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.bookCategory }}</p>
                                    <h3 class="mt-4 text-3xl font-semibold">{{ category.name }}</h3>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]" :class="selectedSource === category.slug ? 'bg-white/15 text-white' : 'bg-emerald-100 text-emerald-700'">{{ selectedLevelName }}</span>
                            </div>
                            <p class="mt-5 text-[15px] leading-7" :class="selectedSource === category.slug ? 'text-slate-200' : 'text-slate-600'">{{ categoryDescription(category.name) }}</p>
                        </button>
                    </div>
                    <div v-else class="mt-2 flex flex-col gap-3">
                        <a :href="launchUrl()" class="app-btn-accent">{{ text.openStudyPage }}</a>
                        <button type="button" class="app-btn-secondary" @click="resetAll">{{ text.clearSelection }}</button>
                    </div>
                </div>

                <div v-else class="mt-6">
                    <div v-if="requiresChapter" class="grid gap-3">
                        <a v-for="chapter in availableChapters" :key="chapter" :href="chapterLaunchUrl(chapter)" :class="chapterCardClass(chapter)" @click="selectedChapter = chapter">
                            <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === chapter ? 'text-emerald-200' : 'text-emerald-700'">{{ common.chapter }}</span>
                            <span class="mt-4 block text-3xl font-semibold">{{ chapterLabel(chapter) }}</span>
                            <span class="mt-3 block text-sm leading-6" :class="selectedChapter === chapter ? 'text-slate-200' : 'text-slate-500'">{{ selectedChapter === chapter ? text.openingStudyPage : text.tapNextStudyPage }}</span>
                        </a>
                    </div>
                    <div v-else class="mt-2 flex flex-col gap-3">
                        <a :href="launchUrl()" class="app-btn-accent">{{ text.openStudyPage }}</a>
                        <button type="button" class="app-btn-secondary" @click="resetAll">{{ text.clearSelection }}</button>
                    </div>
                </div>
            </section>
        </section>

        <div class="hidden md:block">
            <section class="mt-8 rounded-[1.5rem] border border-slate-200/80 bg-white/90 p-4 shadow-sm sm:p-5 md:rounded-[2rem] md:p-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="app-eyebrow">{{ text.step1 }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseLevel }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ text.step1Text }}</p>
                    </div>
                    <button v-if="selectedLevel" type="button" class="app-link" @click="resetAll">{{ text.clearSelection }}</button>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                    <button v-for="level in levels" :key="level.id" type="button" :class="levelCardClass(level.slug)" @click="selectLevel(level.slug)">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedLevel === level.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.level }}</span>
                        <span class="mt-4 block text-3xl font-semibold">{{ level.name }}</span>
                        <span class="mt-3 block text-sm leading-6" :class="selectedLevel === level.slug ? 'text-slate-200' : 'text-slate-500'">{{ selectedLevel === level.slug ? text.selectedContinue : text.tapOpenTracks }}</span>
                    </button>
                </div>
            </section>

            <section v-if="selectedLevel" class="mt-8 rounded-[1.5rem] border border-slate-200/80 bg-slate-50/85 p-4 shadow-sm sm:p-5 md:rounded-[2rem] md:p-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="app-eyebrow">{{ text.step2 }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseBook }}</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            <span v-if="requiresCategory">{{ replace(text.chooseTrackForLevel, { level: selectedLevelName }) }}</span>
                            <span v-else>{{ replace(text.noSeparateCategory, { level: selectedLevelName }) }}</span>
                        </p>
                    </div>
                    <button type="button" class="app-link" @click="resetLevel">{{ text.changeLevel }}</button>
                </div>

                <div v-if="availableCategories.length" class="mt-6 grid gap-4 md:grid-cols-2">
                    <button v-for="category in availableCategories" :key="category.id" type="button" :class="categoryCardClass(category.slug)" @click="selectCategory(category.slug)">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedSource === category.slug ? 'text-emerald-200' : 'text-emerald-700'">{{ text.bookCategory }}</p>
                                <h3 class="mt-4 text-3xl font-semibold">{{ category.name }}</h3>
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]" :class="selectedSource === category.slug ? 'bg-white/15 text-white' : 'bg-emerald-100 text-emerald-700'">{{ selectedLevelName }}</span>
                        </div>
                        <p class="mt-5 text-[15px] leading-7" :class="selectedSource === category.slug ? 'text-slate-200' : 'text-slate-600'">{{ categoryDescription(category.name) }}</p>
                        <div class="mt-6 inline-flex items-center gap-2 text-sm font-semibold" :class="selectedSource === category.slug ? 'text-white' : 'text-slate-900'">
                            <span>{{ selectedSource === category.slug ? text.selectedTrack : replace(text.chooseCategory, { name: category.name }) }}</span>
                            <span aria-hidden="true">-></span>
                        </div>
                    </button>
                </div>
            </section>

            <section v-if="showChapterStep" class="mt-8 rounded-[1.5rem] border border-slate-200/80 bg-slate-50/85 p-4 shadow-sm sm:p-5 md:rounded-[2rem] md:p-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="app-eyebrow">{{ text.step3 }}</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ text.chooseChapter }}</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            <span v-if="requiresChapter">{{ replace(text.pickChapter, { track: selectedTrackLabel }) }}</span>
                            <span v-else>{{ text.noChapterSplit }}</span>
                        </p>
                    </div>
                    <button v-if="requiresCategory" type="button" class="app-link" @click="selectedSource = ''">{{ text.changeBook }}</button>
                </div>

                <div v-if="requiresChapter" class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <a v-for="chapter in availableChapters" :key="chapter" :href="chapterLaunchUrl(chapter)" :class="chapterCardClass(chapter)" @click="selectedChapter = chapter">
                        <span class="text-xs font-semibold uppercase tracking-[0.28em]" :class="selectedChapter === chapter ? 'text-emerald-200' : 'text-emerald-700'">{{ common.chapter }}</span>
                        <span class="mt-4 block text-3xl font-semibold">{{ chapterLabel(chapter) }}</span>
                        <span class="mt-3 block text-sm leading-6" :class="selectedChapter === chapter ? 'text-slate-200' : 'text-slate-500'">{{ selectedChapter === chapter ? text.openingStudyPage : text.tapNextStudyPage }}</span>
                    </a>
                </div>
            </section>
        </div>
    </main>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { getLocale } from '../frontendI18n';

const props = defineProps({
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    sources: { type: Array, default: () => [] },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});

const copy = {
    en: {
        common: {
            studyHome: 'Study Home',
            login: 'Login',
            chapter: 'Chapter',
        },
        kanji: {
            tracks: 'Kanji Tracks',
            heroTitle: 'Choose a level, choose a book, choose a chapter, then open your study page.',
            heroText: 'Pick the JLPT level first. Then choose Somatome or Shinkanzen, select a chapter if needed, and move into a dedicated one-by-one study page with next controls.',
            openFirst: 'Open First Kanji',
            step1: 'Step 1',
            chooseLevel: 'Choose JLPT Level',
            step1Text: 'Tap one card to unlock the matching book tracks below.',
            clearSelection: 'Clear selection',
            back: 'Back',
            level: 'Level',
            selectedContinue: 'Selected. Continue to book category.',
            tapOpenTracks: 'Tap to open tracks.',
            step2: 'Step 2',
            chooseBook: 'Choose Book Category',
            chooseTrackForLevel: 'Pick one track for {level} before the study page opens.',
            noSeparateCategory: '{level} does not need a separate book category. The study page is ready below.',
            changeLevel: 'Change level',
            bookCategory: 'Book Category',
            selectedTrack: 'Selected track',
            chooseCategory: 'Choose {name}',
            step3: 'Step 3',
            chooseChapter: 'Choose Chapter',
            pickChapter: 'Pick the chapter you want to study for {track}.',
            noChapterSplit: 'No chapter split is needed for this track. Your study page is ready below.',
            changeBook: 'Change book',
            openingStudyPage: 'Opening study page.',
            tapNextStudyPage: 'Tap to open the next study page.',
            openStudyPage: 'Open Study Page',
            categorySomatome: 'A faster review track with a clean daily pace for quick study sessions.',
            categoryShinkanzen: 'A deeper structured track for learners who want stronger intensive practice.',
            categoryDefault: 'Choose this track to open the kanji set prepared for this level.',
        },
    },
    my: {
        common: {
            studyHome: '\u101c\u1031\u1037\u101c\u102c\u101b\u1031\u1038 \u1015\u1004\u103a\u1019\u1005\u102c\u1019\u103b\u1000\u103a\u1014\u103e\u102c',
            login: '\u101c\u1031\u102c\u1037\u1002\u103a\u1021\u1004\u103a\u101d\u1004\u103a\u1019\u100a\u103a',
            chapter: '\u1021\u1001\u1014\u103a\u1038',
        },
        kanji: {
            tracks: 'Kanji \u101c\u1019\u103a\u1038\u1000\u103c\u1031\u102c\u1004\u103a\u1038\u1019\u103b\u102c\u1038',
            heroTitle: 'Level \u101b\u103d\u1031\u1038\u1015\u102b\u104a \u1005\u102c\u1021\u102f\u1015\u103a\u101b\u103d\u1031\u1038\u1015\u102b\u104a chapter \u101b\u103d\u1031\u1038\u1015\u102b\u104a \u1015\u103c\u102e\u1038\u101b\u1004\u103a study page \u1000\u102d\u102f \u1016\u103d\u1004\u1037\u103a\u1015\u102b\u104b',
            heroText: '\u1015\u1011\u1019\u1006\u102f\u1036\u1038 JLPT level \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u102b\u104b \u1011\u102d\u102f\u1037\u1014\u1031\u102c\u1000\u103a Somatome \u101e\u102d\u102f\u1037\u1019\u101f\u102f\u1010\u103a Shinkanzen \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u103c\u102e\u1038 \u101c\u102d\u102f\u1021\u1015\u103a\u1015\u102b\u1000 chapter \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u102b\u104b \u1021\u1032\u1012\u102e\u1014\u1031\u102c\u1000\u103a next button \u1014\u1032\u1037 \u1010\u1005\u103a\u101c\u102f\u1036\u1038\u1001\u103b\u1004\u103a\u1038\u101c\u1031\u1037\u101c\u102c\u1014\u102d\u102f\u1004\u103a\u101e\u1031\u102c study page \u101e\u102d\u102f\u1037 \u101d\u1004\u103a\u1014\u102d\u102f\u1004\u103a\u1015\u102b\u1010\u101a\u103a\u104b',
            openFirst: '\u1015\u1011\u1019 Kanji \u1016\u103d\u1004\u1037\u103a\u1019\u100a\u103a',
            step1: '\u1021\u1006\u1004\u1037\u103a \u1041',
            chooseLevel: 'JLPT Level \u101b\u103d\u1031\u1038\u1015\u102b',
            step1Text: '\u1021\u1031\u102c\u1000\u103a\u1000 book tracks \u1019\u103b\u102c\u1038\u1015\u1031\u102b\u103a\u101c\u102c\u101b\u1014\u103a card \u1010\u1005\u103a\u1001\u102f\u1000\u102d\u102f\u1014\u103e\u102d\u1015\u103a\u1015\u102b\u104b',
            clearSelection: '\u101b\u103d\u1031\u1038\u1001\u103b\u101a\u103a\u1019\u103e\u102f\u101b\u103e\u1004\u103a\u1038\u1019\u100a\u103a',
            back: '\u1015\u103c\u1014\u103a\u1019\u100a\u103a',
            level: 'Level',
            selectedContinue: '\u101b\u103d\u1031\u1038\u1015\u103c\u102e\u1038\u1015\u102b\u1015\u103c\u102e\u104b Book category \u101e\u102d\u102f\u1037\u1006\u1000\u103a\u101e\u103d\u102c\u1038\u1015\u102b\u104b',
            tapOpenTracks: 'Tracks \u1016\u103d\u1004\u1037\u103a\u101b\u1014\u103a\u1014\u103e\u102d\u1015\u103a\u1015\u102b\u104b',
            step2: '\u1021\u1006\u1004\u1037\u103a \u1042',
            chooseBook: '\u1005\u102c\u1021\u102f\u1015\u103a\u1021\u1019\u103b\u102d\u102f\u1038\u1021\u1005\u102c\u1038 \u101b\u103d\u1031\u1038\u1015\u102b',
            chooseTrackForLevel: '{level} \u1021\u1010\u103d\u1000\u103a study page \u1019\u1016\u103d\u1004\u1037\u103a\u1001\u1004\u103a track \u1010\u1005\u103a\u1001\u102f\u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u102b\u104b',
            noSeparateCategory: '{level} \u1021\u1010\u103d\u1000\u103a \u101e\u102e\u1038\u1001\u103c\u102c\u1038 book category \u1019\u101c\u102d\u102f\u1015\u102b\u104b Study page \u1021\u1006\u1004\u103a\u101e\u1004\u1037\u103a\u1016\u103c\u1005\u103a\u1014\u1031\u1015\u102b\u1015\u103c\u102e\u104b',
            changeLevel: 'Level \u1015\u103c\u1031\u102c\u1004\u103a\u1038\u1019\u100a\u103a',
            bookCategory: '\u1005\u102c\u1021\u102f\u1015\u103a\u1021\u1019\u103b\u102d\u102f\u1038\u1021\u1005\u102c\u1038',
            selectedTrack: '\u101b\u103d\u1031\u1038\u1015\u103c\u102e\u1038\u101e\u1031\u102c track',
            chooseCategory: '{name} \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1019\u100a\u103a',
            step3: '\u1021\u1006\u1004\u1037\u103a \u1043',
            chooseChapter: 'Chapter \u101b\u103d\u1031\u1038\u1015\u102b',
            pickChapter: '{track} \u1021\u1010\u103d\u1000\u103a \u101c\u1031\u1037\u101c\u102c\u101c\u102d\u102f\u101e\u1031\u102c chapter \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u102b\u104b',
            noChapterSplit: '\u1012\u102e track \u1021\u1010\u103d\u1000\u103a chapter \u1001\u103d\u1032\u101b\u1014\u103a\u1019\u101c\u102d\u102f\u1015\u102b\u104b Study page \u1021\u1006\u1004\u103a\u101e\u1004\u1037\u103a\u1016\u103c\u1005\u103a\u1014\u1031\u1015\u102b\u1015\u103c\u102e\u104b',
            changeBook: '\u1005\u102c\u1021\u102f\u1015\u103a\u1015\u103c\u1031\u102c\u1004\u103a\u1038\u1019\u100a\u103a',
            openingStudyPage: 'Study page \u1016\u103d\u1004\u1037\u103a\u1014\u1031\u1015\u102b\u101e\u100a\u103a\u104b',
            tapNextStudyPage: '\u1014\u1031\u102c\u1000\u103a study page \u1016\u103d\u1004\u1037\u103a\u101b\u1014\u103a\u1014\u103e\u102d\u1015\u103a\u1015\u102b\u104b',
            openStudyPage: 'Study page \u1016\u103d\u1004\u1037\u103a\u1019\u100a\u103a',
            categorySomatome: '\u101c\u103b\u1004\u103a\u1019\u103c\u1014\u103a\u101e\u1031\u102c review \u1021\u1010\u103d\u1000\u103a \u1014\u1031\u1037\u1005\u1009\u103a pace \u101e\u1014\u1037\u103a\u101b\u103e\u1004\u103a\u1038\u101e\u100a\u1037\u103a track \u1016\u103c\u1005\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            categoryShinkanzen: '\u1015\u102d\u102f\u1014\u1000\u103a\u101b\u103e\u102d\u102f\u1004\u103a\u1038\u101e\u1031\u102c intensive practice \u101c\u102f\u1015\u103a\u101c\u102d\u102f\u101e\u1030\u1019\u103b\u102c\u1038\u1021\u1010\u103d\u1000\u103a structured track \u1016\u103c\u1005\u103a\u1015\u102b\u101e\u100a\u103a\u104b',
            categoryDefault: '\u1012\u102e level \u1021\u1010\u103d\u1000\u103a\u1015\u103c\u1004\u103a\u1011\u102c\u1038\u101e\u1031\u102c kanji set \u1000\u102d\u102f\u1016\u103d\u1004\u1037\u103a\u101b\u1014\u103a \u1012\u102e track \u1000\u102d\u102f\u101b\u103d\u1031\u1038\u1015\u102b\u104b',
        },
    },
};
const locale = computed(() => getLocale());
const text = computed(() => copy[locale.value]?.kanji ?? copy.en.kanji);
const common = computed(() => copy[locale.value]?.common ?? copy.en.common);

const selectedLevel = ref(props.filters.level ?? '');
const selectedSource = ref(props.filters.source ?? '');
const selectedChapter = ref(props.filters.chapter ?? '');

const selectedLevelName = computed(() => props.levels.find((level) => level.slug === selectedLevel.value)?.name ?? '');
const selectedSourceName = computed(() => props.sources.find((source) => source.slug === selectedSource.value)?.name ?? '');
const selectedTrackLabel = computed(() => [selectedLevelName.value, selectedSourceName.value].filter(Boolean).join(' / '));
const availableCategories = computed(() => !selectedLevel.value ? [] : props.sources.filter((source) => source.level.slug === selectedLevel.value));
const requiresCategory = computed(() => availableCategories.value.length > 0);
const availableChapters = computed(() => [...new Set(
    props.items
        .filter((item) => selectedLevel.value
            && item.level.slug === selectedLevel.value
            && (!requiresCategory.value || item.source?.slug === selectedSource.value)
            && Boolean(item.chapter))
        .map((item) => item.chapter),
)].sort(compareChapters));
const requiresChapter = computed(() => availableChapters.value.length > 0);
const showChapterStep = computed(() => selectedLevel.value && (!requiresCategory.value || selectedSource.value !== ''));
const previewUrl = computed(() => props.items.find((item) => (
    (!selectedLevel.value || item.level.slug === selectedLevel.value)
    && (!requiresCategory.value || !selectedSource.value || item.source?.slug === selectedSource.value)
    && (!selectedChapter.value || item.chapter === selectedChapter.value)
))?.showUrl ?? props.routes.index);

const mobileStep = computed(() => {
    if (!selectedLevel.value) {
        return 1;
    }

    if (requiresCategory.value && !selectedSource.value) {
        return 2;
    }

    return 3;
});

const mobileStepLabel = computed(() => mobileStep.value === 1 ? text.value.step1 : (mobileStep.value === 2 ? text.value.step2 : text.value.step3));
const mobileStepTitle = computed(() => mobileStep.value === 1 ? text.value.chooseLevel : (mobileStep.value === 2 ? text.value.chooseBook : text.value.chooseChapter));

watch(selectedLevel, () => {
    if (!availableCategories.value.find((source) => source.slug === selectedSource.value)) {
        selectedSource.value = '';
    }

    if (!availableChapters.value.includes(selectedChapter.value)) {
        selectedChapter.value = '';
    }

    syncUrl();
});

watch(selectedSource, () => {
    if (!availableChapters.value.includes(selectedChapter.value)) {
        selectedChapter.value = '';
    }

    syncUrl();
});

watch(selectedChapter, () => syncUrl());

function replace(template, replacements = {}) {
    return Object.entries(replacements).reduce(
        (result, [key, value]) => result.replaceAll(`{${key}}`, String(value)),
        template,
    );
}

function selectLevel(levelSlug, mobile = false) {
    selectedLevel.value = levelSlug;

    if (mobile && !requiresCategory.value && !requiresChapter.value) {
        window.location.assign(launchUrl());
    }
}

function selectCategory(sourceSlug, mobile = false) {
    selectedSource.value = sourceSlug;

    if (mobile && !requiresChapter.value) {
        window.location.assign(launchUrl());
    }
}

function resetLevel() {
    selectedLevel.value = '';
    selectedSource.value = '';
    selectedChapter.value = '';
}

function resetAll() {
    resetLevel();
}

function goBack() {
    if (mobileStep.value === 3 && requiresCategory.value) {
        selectedSource.value = '';
        selectedChapter.value = '';
        return;
    }

    resetAll();
}

function syncUrl() {
    const url = new URL(window.location.href);
    selectedLevel.value ? url.searchParams.set('level', selectedLevel.value) : url.searchParams.delete('level');
    selectedSource.value ? url.searchParams.set('source', selectedSource.value) : url.searchParams.delete('source');
    selectedChapter.value ? url.searchParams.set('chapter', selectedChapter.value) : url.searchParams.delete('chapter');
    window.history.replaceState({}, '', `${url.pathname}${url.search}`);
}

function launchUrl(chapter = '') {
    const url = new URL(props.routes.launch, window.location.origin);

    if (selectedLevel.value) {
        url.searchParams.set('level', selectedLevel.value);
    }

    if (selectedSource.value) {
        url.searchParams.set('source', selectedSource.value);
    }

    if (chapter) {
        url.searchParams.set('chapter', chapter);
    }

    return `${url.pathname}${url.search}`;
}

function chapterLaunchUrl(chapter) {
    return launchUrl(chapter);
}

function levelCardClass(levelSlug) {
    return [
        'rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5',
        selectedLevel.value === levelSlug
            ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]'
            : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]',
    ];
}

function categoryCardClass(sourceSlug) {
    return [
        'rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-6',
        selectedSource.value === sourceSlug
            ? 'border-slate-900 bg-[linear-gradient(135deg,rgba(15,23,42,0.97),rgba(6,78,59,0.9))] text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]'
            : 'border-slate-200 bg-white text-slate-950 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]',
    ];
}

function chapterCardClass(chapter) {
    return [
        'rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5',
        selectedChapter.value === chapter
            ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]'
            : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]',
    ];
}

function categoryDescription(name) {
    if (name.toLowerCase().includes('somatome')) {
        return text.value.categorySomatome;
    }

    if (name.toLowerCase().includes('shinkanzen')) {
        return text.value.categoryShinkanzen;
    }

    return text.value.categoryDefault;
}

function chapterLabel(chapter) {
    return /^\d+$/.test(chapter) ? `${common.value.chapter} ${chapter}` : chapter;
}

function compareChapters(left, right) {
    const leftNumber = Number(left);
    const rightNumber = Number(right);

    if (Number.isFinite(leftNumber) && Number.isFinite(rightNumber)) {
        return leftNumber - rightNumber;
    }

    return left.localeCompare(right, undefined, { numeric: true, sensitivity: 'base' });
}
</script>
