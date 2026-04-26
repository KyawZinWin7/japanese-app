<template>
    <article class="rounded-[1.6rem] border border-slate-200 bg-white p-4 shadow-sm sm:rounded-3xl sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">{{ t('quizTake.question', { index }) }}</p>
                <h2 class="mt-2 text-[1.05rem] font-semibold leading-8 text-slate-900 sm:mt-3 sm:text-xl">
                    <template v-for="(segment, segmentIndex) in highlightedSegments" :key="`${segment.text}-${segmentIndex}`">
                        <span :class="segment.highlight ? 'text-rose-500' : ''">{{ segment.text }}</span>
                    </template>
                </h2>
            </div>
            <span class="hidden self-start app-badge sm:inline-flex">{{ question.quiz_type }}</span>
        </div>

        <div class="mt-4 space-y-2.5 sm:mt-6 sm:space-y-3">
            <label
                v-for="option in question.options"
                :key="option"
                class="flex cursor-pointer items-start gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-3.5 py-3 transition hover:border-emerald-300 hover:bg-emerald-50 sm:rounded-2xl sm:px-4 sm:py-3"
            >
                <input
                    :name="`answers[${question.id}]`"
                    :checked="selectedAnswer === option"
                    :value="option"
                    class="mt-1"
                    type="radio"
                >
                <span class="text-sm leading-6 text-slate-700 sm:text-[15px] sm:leading-7">{{ option }}</span>
            </label>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue';
import { t } from '../../frontendI18n';

const props = defineProps({
    index: { type: Number, required: true },
    question: { type: Object, required: true },
    selectedAnswer: { type: String, default: '' },
});

const highlightedSegments = computed(() => {
    const questionText = String(props.question?.question || '');
    const highlightText = String(props.question?.highlight_text || '');

    if (! highlightText) {
        return [{ text: questionText, highlight: false }];
    }

    const startIndex = questionText.indexOf(highlightText);

    if (startIndex === -1) {
        return [{ text: questionText, highlight: false }];
    }

    const segments = [];
    const before = questionText.slice(0, startIndex);
    const after = questionText.slice(startIndex + highlightText.length);

    if (before) {
        segments.push({ text: before, highlight: false });
    }

    segments.push({ text: highlightText, highlight: true });

    if (after) {
        segments.push({ text: after, highlight: false });
    }

    return segments;
});
</script>
