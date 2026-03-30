<template>
    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">{{ t('quizTake.question', { index }) }}</p>
                <h2 class="mt-3 text-xl font-semibold text-slate-900">{{ question.prompt }}</h2>
                <p v-if="question.kanji" class="mt-4 text-5xl font-semibold text-slate-900">{{ question.kanji }}</p>
            </div>
            <span class="app-badge">{{ question.question_type }}</span>
        </div>

        <div class="mt-6 space-y-3">
            <label
                v-for="option in question.options"
                :key="option"
                class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-emerald-300 hover:bg-emerald-50"
            >
                <input
                    :name="`answers[${question.id}]`"
                    :checked="selectedAnswer === option"
                    :value="option"
                    class="mt-1"
                    type="radio"
                >
                <span class="text-[15px] leading-7 text-slate-700">{{ option }}</span>
            </label>
        </div>
    </article>
</template>

<script setup>
import { t } from '../../frontendI18n';

defineProps({
    index: { type: Number, required: true },
    question: { type: Object, required: true },
    selectedAnswer: { type: String, default: '' },
});
</script>