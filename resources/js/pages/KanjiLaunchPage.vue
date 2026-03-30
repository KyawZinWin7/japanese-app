<template>
    <main class="page-shell">
        <section class="rounded-[1.5rem] border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5 md:rounded-[2rem] md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="app-eyebrow">{{ text.step4 }}</p>
                    <h1 class="mt-4 text-2xl font-semibold text-slate-950 sm:text-3xl">{{ text.title }}</h1>
                    <p class="mt-4 text-[15px] leading-7 text-slate-600">{{ replace(text.intro, { label: selectedStudyLabel }) }}</p>
                    <p class="mt-3 text-[15px] leading-7 text-slate-600">{{ text.helper }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-5 py-4 text-center ring-1 ring-slate-200">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ text.cardsReady }}</p>
                    <p class="mt-3 text-4xl font-semibold text-slate-950">{{ items.length }}</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a :href="studyUrl" class="app-btn-accent">{{ text.studySet }}</a>
                <a :href="previewUrl" class="app-link">{{ text.previewFirst }}</a>
                <a :href="routes.index" class="app-btn-secondary">{{ text.backToChapter }}</a>
            </div>

            <div class="mt-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ text.order }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ text.searchHelp }}</p>
                    </div>
                    <div class="w-full max-w-md">
                        <label for="kanji-search" class="app-label">{{ text.search }}</label>
                        <div class="mt-2 flex items-center gap-3">
                            <input id="kanji-search" v-model.trim="searchQuery" type="search" class="app-input" :placeholder="text.searchPlaceholder" autocomplete="off">
                            <button v-if="searchQuery" type="button" class="app-btn-secondary shrink-0" @click="searchQuery = ''">{{ common.clear }}</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3 text-sm text-slate-500">
                    <p><span class="font-semibold text-slate-900">{{ filteredItems.length }}</span><span>{{ searchQuery ? text.matches : text.inSet }}</span></p>
                    <div class="rounded-[1rem] border border-slate-200 bg-slate-50 px-3 py-2 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">{{ text.set }}</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">{{ items.length }}</p>
                    </div>
                </div>

                <div v-if="searchQuery && filteredItems.length" class="mt-4 max-h-[16rem] space-y-2 overflow-y-auto pr-1">
                    <a v-for="entry in filteredItems" :key="entry.id" :href="entry.showUrl" class="block rounded-[1rem] border border-slate-200 bg-slate-50/85 px-3 py-2.5 transition hover:-translate-y-0.5 hover:border-emerald-200 hover:bg-white sm:rounded-[1.2rem] sm:px-3.5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">No. {{ itemNumber(entry) }}</p>
                                <p class="mt-1 text-2xl font-semibold text-slate-950">{{ entry.character }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-800">{{ entry.meaning || '-' }}</p>
                                <p class="mt-1 text-xs tracking-[0.08em] text-slate-500">{{ entry.onyomi || entry.kunyomi || '-' }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <p v-else-if="searchQuery" class="mt-4 text-sm leading-6 text-slate-700">{{ text.noMatches }}</p>

                <div v-if="!searchQuery" class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    <a v-for="item in filteredItems" :key="item.id" :href="item.showUrl" class="rounded-[1.25rem] border border-slate-200 bg-slate-50/90 px-4 py-3 transition hover:-translate-y-0.5 hover:border-emerald-200 hover:bg-white">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-700">No. {{ item.sort_order }}</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-950">{{ item.character }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-700">{{ item.meaning }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ item.onyomi || item.kunyomi || '-' }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { computed, ref } from 'vue';
import { getLocale } from '../frontendI18n';

const props = defineProps({
    filters: { type: Object, required: true },
    items: { type: Array, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    sources: { type: Array, default: () => [] },
});

const copy = {
    en: {
        common: {
            clear: 'Clear',
            chapter: 'Chapter',
        },
        page: {
            step4: 'Step 4',
            title: 'Open Your Study Page',
            intro: 'Start a one-by-one study session for {label}.',
            helper: 'The next page will open the first kanji detail page in this set. Then you can move one by one with the next button.',
            cardsReady: 'Cards Ready',
            studySet: 'Study This Kanji Set',
            previewFirst: 'Preview first kanji',
            backToChapter: 'Back to Chapter Select',
            order: 'Kanji Order',
            searchHelp: 'Search this kanji set by character, meaning, or reading.',
            search: 'Search Kanji',
            searchPlaceholder: 'Search kanji, meaning, onyomi, kunyomi',
            matches: ' matches',
            inSet: ' in this set',
            set: 'Set',
            noMatches: 'No kanji matched this search in the current set.',
        },
    },
    my: {
        common: {
            clear: 'ရှင်းမည်',
            chapter: 'အခန်း',
        },
        page: {
            step4: 'အဆင့် ၄',
            title: 'သင်၏ Study Page ကို ဖွင့်ပါ',
            intro: '{label} အတွက် တစ်လုံးချင်း study session ကို စတင်ပါ။',
            helper: 'နောက်စာမျက်နှာတွင် ဒီ set ထဲက ပထမ kanji detail page ကိုဖွင့်ပါမည်။ ထို့နောက် next button ဖြင့် တစ်လုံးချင်းရွှေ့ပြီး လေ့လာနိုင်ပါသည်။',
            cardsReady: 'အသင့်ရှိသော Card များ',
            studySet: 'ဒီ Kanji Set ကို လေ့လာမည်',
            previewFirst: 'ပထမ kanji ကို ကြည့်မည်',
            backToChapter: 'Chapter ရွေးချယ်မှုသို့ ပြန်မည်',
            order: 'Kanji အစဉ်',
            searchHelp: 'ဒီ kanji set ထဲမှ character, meaning သို့မဟုတ် reading ဖြင့် ရှာနိုင်ပါသည်။',
            search: 'Kanji ရှာမည်',
            searchPlaceholder: 'kanji, meaning, onyomi, kunyomi ရှာမည်',
            matches: ' ခုတွေ့သည်',
            inSet: ' ခု ဒီ set ထဲတွင်ရှိသည်',
            set: 'Set',
            noMatches: 'လက်ရှိ set ထဲမှာ ဒီ search နဲ့ ကိုက်ညီတဲ့ kanji မတွေ့ပါ။',
        },
    },
};

const locale = computed(() => getLocale());
const common = computed(() => copy[locale.value]?.common ?? copy.en.common);
const text = computed(() => copy[locale.value]?.page ?? copy.en.page);

const searchQuery = ref('');
const selectedLevelName = computed(() => props.levels.find((level) => level.slug === props.filters.level)?.name ?? '');
const selectedSourceName = computed(() => props.sources.find((source) => source.slug === props.filters.source)?.name ?? '');
const selectedChapterLabel = computed(() => props.filters.chapter ? chapterLabel(props.filters.chapter) : '');
const selectedStudyLabel = computed(() => [selectedLevelName.value, selectedSourceName.value, selectedChapterLabel.value].filter(Boolean).join(' / '));
const previewUrl = computed(() => props.items[0]?.showUrl ?? props.routes.kanji);
const studyUrl = computed(() => previewUrl.value);
const normalizedSearchQuery = computed(() => searchQuery.value.trim().toLowerCase());
const filteredItems = computed(() => !normalizedSearchQuery.value ? props.items : props.items.filter((entry) => searchableText(entry).includes(normalizedSearchQuery.value)));

function replace(template, replacements = {}) {
    return Object.entries(replacements).reduce(
        (result, [key, value]) => result.replaceAll(`{${key}}`, String(value)),
        template,
    );
}
function chapterLabel(chapter) {
    return /^\d+$/.test(chapter) ? `${common.value.chapter} ${chapter}` : chapter;
}
function searchableText(entry) {
    return [entry.character, entry.meaning, entry.onyomi, entry.kunyomi, itemNumber(entry), entry.sort_order]
        .filter(Boolean)
        .join(' ')
        .toLowerCase();
}
function itemNumber(entry) {
    const index = props.items.findIndex((item) => item.id === entry.id);
    return index >= 0 ? index + 1 : entry.sort_order;
}
</script>