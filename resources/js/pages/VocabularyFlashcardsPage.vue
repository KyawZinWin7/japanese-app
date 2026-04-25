<template>
    <main class="page-shell max-w-7xl !px-3 sm:!px-6">
        <div v-if="cards.length" ref="studyStage">
            <section class="space-y-4">
                <div class="section-card overflow-hidden !p-0">
                    <div class="flex flex-wrap items-start justify-between gap-2 border-b border-slate-200 px-4 py-3 sm:px-5 sm:py-4">
                        <div>
                            <p class="app-eyebrow">{{ t('flashcardStudy.vocabularyFlashcards') }}</p>
                            <p class="mt-2 text-sm font-medium text-slate-500">
                                {{ activeIndex + 1 }} / {{ orderedCards.length }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <a :href="routes.vocabulary" class="app-link">{{ t('common.backToList') }}</a>
                            <a :href="viewer.isAuthenticated ? viewer.dashboardUrl : viewer.loginUrl" class="app-link">
                                {{ viewer.isAuthenticated ? t('common.studyHome') : t('common.login') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-3 px-4 py-3 sm:gap-4 sm:px-5 sm:py-4 lg:grid-cols-[minmax(0,1fr)_minmax(14rem,0.72fr)] lg:items-stretch">
                        <button
                            type="button"
                            class="rounded-[1.3rem] border border-emerald-100 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.92),_rgba(236,253,245,0.88))] px-4 py-4 text-left shadow-[0_18px_40px_-34px_rgba(15,23,42,0.28)] transition hover:border-emerald-200 sm:rounded-[1.6rem] sm:px-6 sm:py-6"
                            @click="handleCardClick"
                            @touchstart="handleTouchStart"
                            @touchend="handleTouchEnd"
                            @touchcancel="resetTouchState"
                        >
                            <template v-if="!showBack">
                                <div class="mt-1 flex min-h-[8.5rem] flex-col items-center justify-center text-center sm:mt-4 sm:min-h-[13rem]">
                                    <h1 class="text-[2.7rem] font-semibold leading-none text-slate-950 sm:text-[4rem] lg:text-[4.5rem]">
                                        {{ currentCard.word }}
                                    </h1>
                                    <p class="mt-3 rounded-[1rem] border border-slate-200 bg-white/85 px-3 py-2 text-sm font-medium text-slate-600 sm:mt-4 sm:rounded-[1.2rem] sm:px-4 sm:py-3">
                                        {{ t('flashcardStudy.tapVocabularyReveal') }}
                                    </p>
                                </div>
                            </template>

                            <template v-else>
                                <div class="space-y-3 sm:space-y-4">
                                    <p class="text-lg font-semibold leading-7 text-slate-800 sm:text-2xl">{{ currentCard.reading || '-' }}</p>
                                    <p class="text-lg font-semibold leading-7 text-slate-800 sm:text-2xl">{{ currentCard.meaning }}</p>
                                    <p class="text-sm leading-6 text-emerald-900 sm:text-lg">
                                        {{ currentCard.meaning_mm || t('flashcardStudy.meaningMyanmarMissing') }}
                                    </p>
                                </div>
                            </template>
                        </button>

                        <div v-if="showBack" class="grid content-start gap-2.5 sm:gap-3">
                            <section class="section-card min-h-[5.25rem] !rounded-[1.1rem] !p-3 sm:min-h-[6.5rem] sm:!rounded-[1.4rem] sm:!p-4">
                                <p class="hidden text-sm font-semibold uppercase tracking-[0.26em] text-slate-500 md:block">{{ t('flashcardStudy.reading') }}</p>
                                <p class="text-xl text-slate-900 md:mt-2">{{ currentCard.reading || '-' }}</p>
                            </section>
                            <a :href="currentCard.detailUrl" class="section-card !rounded-[1.1rem] !p-3 text-sm text-slate-700 sm:!rounded-[1.4rem] sm:!p-4 sm:text-base">
                                {{ t('flashcardStudy.openDetailPage') }}
                            </a>
                        </div>

                        <div v-else class="flex items-center justify-center rounded-[1.1rem] border border-dashed border-slate-200 bg-slate-50/70 p-3.5 text-center sm:rounded-[1.6rem] sm:p-5">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-400">{{ t('flashcardStudy.hiddenUntilReveal') }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:leading-7">
                                    {{ t('flashcardStudy.vocabularyHiddenHelp') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 rounded-[1.1rem] border border-slate-200 bg-white/90 px-2.5 py-2.5 shadow-[0_18px_40px_-34px_rgba(15,23,42,0.28)] sm:gap-3 sm:rounded-[1.4rem] sm:px-4 sm:py-3">
                    <button type="button" class="app-btn-secondary hidden sm:inline-flex sm:grow-0" @click="previousCard" :disabled="activeIndex === 0">{{ t('common.prev') }}</button>
                    <button type="button" class="app-btn grow sm:grow-0" @click="showBack = !showBack">
                        {{ showBack ? t('flashcardStudy.showFront') : t('flashcardStudy.revealAnswer') }}
                    </button>
                    <button type="button" class="app-btn-accent hidden sm:inline-flex sm:grow-0" @click="nextCard" :disabled="activeIndex === orderedCards.length - 1">{{ t('common.next') }}</button>
                    <button type="button" class="app-btn-secondary grow sm:grow-0" @click="shuffleCards">{{ t('flashcardStudy.shuffle') }}</button>
                </div>
            </section>
        </div>

        <p v-else class="section-card text-slate-600">{{ t('flashcardStudy.noVocabularyCards') }}</p>
    </main>
</template>

<script setup>
import { computed, nextTick, onMounted, ref, watch } from 'vue';
import { t } from '../frontendI18n';
import { saveStudyResume, trackStudyHistory } from '../studyHistory';

const props = defineProps({
    cards: { type: Array, required: true },
    filters: { type: Object, required: true },
    levels: { type: Array, required: true },
    routes: { type: Object, required: true },
    studyState: { type: Object, default: () => ({}) },
    viewer: { type: Object, required: true },
});

const orderedCards = ref([...props.cards]);
const activeIndex = ref(0);
const showBack = ref(false);
const studyStage = ref(null);
const touchStartX = ref(0);
const touchStartY = ref(0);
const suppressTap = ref(false);

const currentCard = computed(() => orderedCards.value[activeIndex.value] ?? {});

watch(activeIndex, syncStudyProgress);
watch(showBack, syncStudyProgress);

onMounted(() => {
    restoreStudyProgress();
    syncStudyProgress();
});

function handleCardClick() {
    if (suppressTap.value) {
        suppressTap.value = false;
        return;
    }

    showBack.value = !showBack.value;
}

function previousCard() {
    if (activeIndex.value > 0) {
        activeIndex.value -= 1;
        showBack.value = false;
        scrollToStudyStage();
    }
}

function nextCard() {
    if (activeIndex.value < orderedCards.value.length - 1) {
        activeIndex.value += 1;
        showBack.value = false;
        scrollToStudyStage();
    }
}

function shuffleCards() {
    orderedCards.value = [...orderedCards.value].sort(() => Math.random() - 0.5);
    activeIndex.value = 0;
    showBack.value = false;
    scrollToStudyStage();
}

function handleTouchStart(event) {
    const touch = event.changedTouches?.[0];

    if (!touch) {
        return;
    }

    touchStartX.value = touch.clientX;
    touchStartY.value = touch.clientY;
    suppressTap.value = false;
}

function handleTouchEnd(event) {
    const touch = event.changedTouches?.[0];

    if (!touch) {
        return;
    }

    const deltaX = touch.clientX - touchStartX.value;
    const deltaY = touch.clientY - touchStartY.value;

    if (Math.abs(deltaX) < 48 || Math.abs(deltaX) <= Math.abs(deltaY)) {
        return;
    }

    suppressTap.value = true;

    if (deltaX < 0) {
        nextCard();
        return;
    }

    previousCard();
}

function resetTouchState() {
    touchStartX.value = 0;
    touchStartY.value = 0;
    suppressTap.value = false;
}

function restoreStudyProgress() {
    const savedIndex = Number(props.studyState?.activeIndex ?? 0);

    if (Number.isInteger(savedIndex) && savedIndex >= 0 && savedIndex < orderedCards.value.length) {
        activeIndex.value = savedIndex;
    }

    showBack.value = Boolean(props.studyState?.showBack);
}

function syncStudyProgress() {
    const entry = {
        id: `vocabulary-flashcards:${window.location.pathname}${window.location.search}`,
        href: window.location.href,
        title: t('study.vocabulary'),
        subtitle: t('study.flashcards'),
        progressLabel: `${activeIndex.value + 1} / ${orderedCards.value.length}`,
        state: {
            activeIndex: activeIndex.value,
            showBack: showBack.value,
        },
    };

    trackStudyHistory(entry);
    saveStudyResume(entry);
}

async function scrollToStudyStage() {
    await nextTick();
    studyStage.value?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
