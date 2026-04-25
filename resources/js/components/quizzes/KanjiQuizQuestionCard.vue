<template>
    <article class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">{{ t('quizTake.question', { index }) }}</p>
                <h2 class="mt-3 text-lg font-semibold leading-8 text-slate-900 sm:text-xl">{{ question.prompt }}</h2>
                <p v-if="question.kanji" class="mt-4 text-4xl font-semibold text-slate-900 sm:text-5xl">{{ question.kanji }}</p>
            </div>
            <span class="app-badge self-start">{{ question.question_type }}</span>
        </div>

        <div class="mt-5 space-y-3 sm:mt-6">
            <label
                v-for="option in question.options"
                :key="option"
                class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 transition hover:border-emerald-300 hover:bg-emerald-50 sm:py-3"
            >
                <input
                    :name="`answers[${question.id}]`"
                    :checked="selectedAnswer === option"
                    :value="option"
                    class="mt-1"
                    type="radio"
                >
                <span class="text-sm leading-7 text-slate-700 sm:text-[15px]">{{ option }}</span>
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
