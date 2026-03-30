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
            categorySomatome: 'A faster review track with a clean daily pace for quick study sessions.',
            categoryShinkanzen: 'A deeper structured track for learners who want stronger intensive practice.',
            categoryDefault: 'Choose this track to open the kanji set prepared for this level.',
        },
    },
    my: {
        common: {
            studyHome: 'လေ့လာရေး ပင်မစာမျက်နှာ',
            login: 'လော့ဂ်အင်ဝင်မည်',
            chapter: 'အခန်း',
        },
        kanji: {
            tracks: 'Kanji လမ်းကြောင်းများ',
            heroTitle: 'Level ရွေးပါ၊ စာအုပ်ရွေးပါ၊ chapter ရွေးပါ၊ ပြီးရင် study page ကို ဖွင့်ပါ။',
            heroText: 'ပထမဆုံး JLPT level ကိုရွေးပါ။ ထို့နောက် Somatome သို့မဟုတ် Shinkanzen ကိုရွေးပြီး လိုအပ်ပါက chapter ကိုရွေးပါ။ အဲဒီနောက် next button နဲ့ တစ်လုံးချင်းလေ့လာနိုင်သော study page သို့ဝင်နိုင်ပါသည်။',
            openFirst: 'ပထမ Kanji ဖွင့်မည်',
            step1: 'အဆင့် ၁',
            chooseLevel: 'JLPT Level ရွေးပါ',
            step1Text: 'အောက်က book tracks များပေါ်လာရန် card တစ်ခုကိုနှိပ်ပါ။',
            clearSelection: 'ရွေးချယ်မှုရှင်းမည်',
            level: 'Level',
            selectedContinue: 'ရွေးပြီးပါပြီ။ Book category သို့ဆက်သွားပါ။',
            tapOpenTracks: 'Tracks ဖွင့်ရန်နှိပ်ပါ။',
            step2: 'အဆင့် ၂',
            chooseBook: 'စာအုပ်အမျိုးအစား ရွေးပါ',
            chooseTrackForLevel: '{level} အတွက် study page မဖွင့်ခင် track တစ်ခုကိုရွေးပါ။',
            noSeparateCategory: '{level} အတွက် သီးခြား book category မလိုပါ။ Study page အဆင်သင့်ဖြစ်နေပါပြီ။',
            changeLevel: 'Level ပြောင်းမည်',
            bookCategory: 'စာအုပ်အမျိုးအစား',
            selectedTrack: 'ရွေးပြီးသော track',
            chooseCategory: '{name} ကိုရွေးမည်',
            step3: 'အဆင့် ၃',
            chooseChapter: 'Chapter ရွေးပါ',
            pickChapter: '{track} အတွက် လေ့လာလိုသော chapter ကိုရွေးပါ။',
            noChapterSplit: 'ဒီ track အတွက် chapter ခွဲရန်မလိုပါ။ Study page အဆင်သင့်ဖြစ်နေပါပြီ။',
            changeBook: 'စာအုပ်ပြောင်းမည်',
            openingStudyPage: 'Study page ဖွင့်နေပါသည်။',
            tapNextStudyPage: 'နောက် study page ဖွင့်ရန်နှိပ်ပါ။',
            categorySomatome: 'လျင်မြန်သော review အတွက် နေ့စဉ် pace သန့်ရှင်းသည့် track ဖြစ်ပါသည်။',
            categoryShinkanzen: 'ပိုနက်ရှိုင်းသော intensive practice လုပ်လိုသူများအတွက် structured track ဖြစ်ပါသည်။',
            categoryDefault: 'ဒီ level အတွက်ပြင်ထားသော kanji set ကိုဖွင့်ရန် ဒီ track ကိုရွေးပါ။',
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
const availableChapters = computed(() => [...new Set(props.items.filter((item) => selectedLevel.value && item.level.slug === selectedLevel.value && (!requiresCategory.value || item.source?.slug === selectedSource.value) && Boolean(item.chapter)).map((item) => item.chapter))].sort(compareChapters));
const requiresChapter = computed(() => availableChapters.value.length > 0);
const showChapterStep = computed(() => selectedLevel.value && (!requiresCategory.value || selectedSource.value !== ''));
const previewUrl = computed(() => props.items.find((item) => (!selectedLevel.value || item.level.slug === selectedLevel.value) && (!requiresCategory.value || !selectedSource.value || item.source?.slug === selectedSource.value) && (!selectedChapter.value || item.chapter === selectedChapter.value))?.showUrl ?? props.routes.index);

watch(selectedLevel, () => {
    if (!availableCategories.value.find((source) => source.slug === selectedSource.value)) selectedSource.value = '';
    if (!availableChapters.value.includes(selectedChapter.value)) selectedChapter.value = '';
    syncUrl();
});
watch(selectedSource, () => {
    if (!availableChapters.value.includes(selectedChapter.value)) selectedChapter.value = '';
    syncUrl();
});
watch(selectedChapter, () => syncUrl());

function replace(template, replacements = {}) {
    return Object.entries(replacements).reduce(
        (result, [key, value]) => result.replaceAll(`{${key}}`, String(value)),
        template,
    );
}
function selectLevel(levelSlug) { selectedLevel.value = levelSlug; }
function selectCategory(sourceSlug) { selectedSource.value = sourceSlug; }
function resetLevel() { selectedLevel.value = ''; selectedSource.value = ''; selectedChapter.value = ''; }
function resetAll() { resetLevel(); }
function syncUrl() {
    const url = new URL(window.location.href);
    selectedLevel.value ? url.searchParams.set('level', selectedLevel.value) : url.searchParams.delete('level');
    selectedSource.value ? url.searchParams.set('source', selectedSource.value) : url.searchParams.delete('source');
    selectedChapter.value ? url.searchParams.set('chapter', selectedChapter.value) : url.searchParams.delete('chapter');
    window.history.replaceState({}, '', `${url.pathname}${url.search}`);
}
function chapterLaunchUrl(chapter) { const url = new URL(props.routes.launch, window.location.origin); if (selectedLevel.value) url.searchParams.set('level', selectedLevel.value); if (selectedSource.value) url.searchParams.set('source', selectedSource.value); url.searchParams.set('chapter', chapter); return `${url.pathname}${url.search}`; }
function levelCardClass(levelSlug) { return ['rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5', selectedLevel.value === levelSlug ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]' : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]']; }
function categoryCardClass(sourceSlug) { return ['rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-6', selectedSource.value === sourceSlug ? 'border-slate-900 bg-[linear-gradient(135deg,rgba(15,23,42,0.97),rgba(6,78,59,0.9))] text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]' : 'border-slate-200 bg-white text-slate-950 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]']; }
function chapterCardClass(chapter) { return ['rounded-[1.4rem] border p-4 text-left transition duration-200 sm:rounded-[1.75rem] sm:p-5', selectedChapter.value === chapter ? 'border-slate-900 bg-slate-900 text-white shadow-[0_24px_70px_-36px_rgba(15,23,42,0.7)]' : 'border-slate-200 bg-white text-slate-900 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_18px_55px_-36px_rgba(15,23,42,0.35)]']; }
function categoryDescription(name) { if (name.toLowerCase().includes('somatome')) return text.value.categorySomatome; if (name.toLowerCase().includes('shinkanzen')) return text.value.categoryShinkanzen; return text.value.categoryDefault; }
function chapterLabel(chapter) { return /^\d+$/.test(chapter) ? `${common.value.chapter} ${chapter}` : chapter; }
function compareChapters(left, right) { const leftNumber = Number(left); const rightNumber = Number(right); if (Number.isFinite(leftNumber) && Number.isFinite(rightNumber)) return leftNumber - rightNumber; return left.localeCompare(right, undefined, { numeric: true, sensitivity: 'base' }); }
</script>