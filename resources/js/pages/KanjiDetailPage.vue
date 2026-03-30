<template>
    <main class="page-shell max-w-7xl !px-3 sm:!px-6">
        <div class="grid gap-3 sm:gap-4 xl:grid-cols-[minmax(0,1fr)_21rem]">
            <section class="space-y-3 sm:space-y-4">
                <div class="flex flex-wrap items-center gap-2.5 rounded-[1.1rem] border border-slate-200 bg-white/90 px-3 py-2.5 shadow-[0_18px_40px_-34px_rgba(15,23,42,0.28)] sm:gap-3 sm:rounded-[1.35rem] sm:px-4 sm:py-3">
                    <a v-if="routes.previous" :href="routes.previous" class="app-btn-secondary">{{ labels.prev }}</a>
                    <a v-if="routes.next" :href="routes.next" class="app-btn-accent">{{ labels.next }}</a>
                </div>

                <div class="section-card overflow-hidden !p-0">
                    <div class="flex flex-wrap items-start justify-between gap-2.5 border-b border-slate-200 px-4 py-3 sm:px-5 sm:py-4">
                        <div>
                            <p class="app-eyebrow">{{ item.level.name }}</p>
                            <p v-if="item.source || item.chapter" class="mt-2 text-sm font-medium text-slate-500">
                                <span v-if="item.source">{{ item.source.name }}</span>
                                <span v-if="item.source && item.chapter"> / </span>
                                <span v-if="item.chapter">{{ chapterLabel(item.chapter) }}</span>
                                <span v-if="item.chapter && (item.sequence?.position || item.sort_order)"> / </span>
                                <span v-if="item.sequence?.position || item.sort_order">No. {{ item.sequence?.position || item.sort_order }}<template v-if="item.sequence?.total"> / {{ item.sequence.total }}</template></span>
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a :href="routes.index" class="app-link">{{ labels.backToList }}</a>
                            <BookmarkButton v-if="item.canBookmark" :action="item.bookmarkUrl" :csrf-token="csrfToken" :is-bookmarked="item.isBookmarked" />
                            <a v-if="!viewer.isAuthenticated" :href="viewer.loginUrl" class="app-link">{{ labels.login }}</a>
                        </div>
                    </div>

                    <div class="grid gap-3 px-4 py-3 sm:gap-4 sm:px-5 sm:py-4 lg:grid-cols-[minmax(0,0.95fr)_minmax(14rem,0.75fr)] lg:items-stretch">
                        <div class="rounded-[1.2rem] border border-emerald-100 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.92),_rgba(236,253,245,0.88))] px-4 py-4 shadow-[0_18px_40px_-34px_rgba(15,23,42,0.28)] sm:rounded-[1.6rem] sm:px-6 sm:py-8">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold uppercase tracking-[0.38em] text-slate-400">{{ labels.currentCard }}</p>
                                <p v-if="item.sequence?.position || item.sort_order" class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-700">No. {{ item.sequence?.position || item.sort_order }}</p>
                            </div>
                            <div class="mt-3 flex min-h-[8.5rem] flex-col items-center justify-center text-center sm:min-h-[15rem]">
                                <h1 class="text-[3.7rem] font-semibold leading-none text-slate-950 sm:text-[6.2rem] lg:text-[6.8rem]">{{ item.character }}</h1>
                                <p class="mt-3 text-base font-semibold leading-6 text-slate-800 sm:text-xl">{{ item.meaning }}</p>
                                <p v-if="item.meaning_mm" class="mt-1.5 text-sm leading-6 text-emerald-800 sm:text-base">{{ item.meaning_mm }}</p>
                            </div>
                        </div>

                        <div class="grid gap-2.5 content-start sm:gap-3">
                            <section class="section-card min-h-[5rem] !rounded-[1.05rem] !p-3 sm:min-h-[6.5rem] sm:!rounded-[1.3rem] sm:!p-4">
                                <p class="text-sm font-semibold uppercase tracking-[0.26em] text-slate-500">{{ labels.onyomi }}</p>
                                <p class="mt-1.5 text-lg text-slate-900 sm:mt-2 sm:text-xl">{{ item.onyomi || '-' }}</p>
                            </section>
                            <section class="section-card min-h-[5rem] !rounded-[1.05rem] !p-3 sm:min-h-[6.5rem] sm:!rounded-[1.3rem] sm:!p-4">
                                <p class="text-sm font-semibold uppercase tracking-[0.26em] text-slate-500">{{ labels.kunyomi }}</p>
                                <p class="mt-1.5 text-lg text-slate-900 sm:mt-2 sm:text-xl">{{ item.kunyomi || '-' }}</p>
                            </section>
                            <section class="section-card !rounded-[1.05rem] !p-3 sm:!rounded-[1.3rem] sm:!p-4">
                                <p class="text-sm font-semibold uppercase tracking-[0.26em] text-slate-500">{{ labels.exampleSentence }}</p>
                                <p class="mt-1.5 text-sm leading-6 text-slate-800 sm:mt-2 sm:leading-7">{{ item.example_sentence || labels.noSentence }}</p>
                            </section>
                            <section class="section-card !rounded-[1.05rem] !p-3 sm:!rounded-[1.3rem] sm:!p-4">
                                <p class="text-sm font-semibold uppercase tracking-[0.26em] text-slate-500">{{ labels.translation }}</p>
                                <p class="mt-1.5 text-sm leading-6 text-slate-800 sm:mt-2 sm:leading-7">{{ item.example_translation || labels.noTranslation }}</p>
                                <p v-if="item.example_translation_mm" class="mt-2 text-sm leading-6 text-emerald-800 sm:leading-7">{{ item.example_translation_mm }}</p>
                            </section>
                        </div>
                    </div>
                </div>

                <div v-if="status" class="app-status">{{ status }}</div>
            </section>

            <aside class="xl:sticky xl:top-6 xl:self-start">
                <section class="section-card h-full !rounded-[1.1rem] !p-3 sm:!rounded-[1.5rem] sm:!p-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="app-eyebrow">{{ labels.exampleWords }}</p>
                            <p class="mt-2 text-sm text-slate-500">{{ labels.exampleWordsText }}</p>
                        </div>
                        <div class="rounded-[1rem] border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-center sm:rounded-[1.2rem] sm:px-3 sm:py-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ labels.total }}</p>
                            <p class="mt-0.5 text-lg font-semibold text-slate-900 sm:mt-1 sm:text-xl">{{ item.exampleWords?.length || 0 }}</p>
                        </div>
                    </div>

                    <div v-if="item.exampleWords?.length" class="mt-3 grid gap-2.5 sm:mt-4 sm:gap-3 sm:grid-cols-2 xl:grid-cols-1">
                        <article v-for="word in item.exampleWords" :key="word.id" class="rounded-[1rem] border border-slate-200 bg-slate-50/85 p-2.5 sm:rounded-[1.2rem] sm:p-3">
                            <p class="text-lg font-semibold text-slate-950 sm:text-xl">{{ word.word }}</p>
                            <p class="mt-1 text-sm tracking-[0.08em] text-slate-500 sm:mt-1.5">{{ word.reading }}</p>
                            <p class="mt-1.5 text-sm font-medium leading-6 text-slate-800 sm:mt-2">{{ word.meaning }}</p>
                            <p v-if="word.meaning_mm" class="mt-1 text-sm leading-6 text-emerald-800">{{ word.meaning_mm }}</p>
                        </article>
                    </div>
                    <p v-else class="mt-3 text-sm leading-6 text-slate-700 sm:mt-4 sm:leading-7">{{ labels.noExampleWords }}</p>
                </section>
            </aside>
        </div>
    </main>
</template>

<script setup>
import { computed } from 'vue';
import BookmarkButton from '../components/bookmarks/BookmarkButton.vue';
import { getLocale } from '../frontendI18n';

const props = defineProps({
    csrfToken: { type: String, required: true },
    item: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    viewer: { type: Object, required: true },
});

const copy = {
    en: {
        prev: 'Prev',
        next: 'Next',
        total: 'Total',
        login: 'Login',
        backToList: 'Back to list',
        chapter: 'Chapter {value}',
        currentCard: 'Current Card',
        onyomi: 'Onyomi',
        kunyomi: 'Kunyomi',
        exampleSentence: 'Example Sentence',
        translation: 'Translation',
        noSentence: 'No example sentence yet.',
        noTranslation: 'No translation yet.',
        exampleWords: 'Example Words',
        exampleWordsText: 'Words that use this kanji.',
        noExampleWords: 'No example words yet.',
    },
    my: {
        prev: 'အရင်',
        next: 'နောက်',
        total: 'စုစုပေါင်း',
        login: 'လော့ဂ်အင်ဝင်မည်',
        backToList: 'စာရင်းသို့ ပြန်မည်',
        chapter: 'အခန်း {value}',
        currentCard: 'လက်ရှိ Card',
        onyomi: 'Onyomi',
        kunyomi: 'Kunyomi',
        exampleSentence: 'ဥပမာဝါကျ',
        translation: 'ဘာသာပြန်',
        noSentence: 'ဥပမာဝါကျ မရှိသေးပါ။',
        noTranslation: 'ဘာသာပြန် မရှိသေးပါ။',
        exampleWords: 'ဥပမာစကားလုံးများ',
        exampleWordsText: 'ဒီ kanji ကို အသုံးပြုသော စကားလုံးများ။',
        noExampleWords: 'ဥပမာစကားလုံး မရှိသေးပါ။',
    },
};

const locale = computed(() => getLocale());
const labels = computed(() => copy[locale.value] ?? copy.en);

function chapterLabel(value) {
    return labels.value.chapter.replace('{value}', String(value));
}
</script>