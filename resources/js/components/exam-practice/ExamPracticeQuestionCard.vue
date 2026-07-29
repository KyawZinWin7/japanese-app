<template>
    <article class="rounded-[1.6rem] border border-slate-200 bg-white p-4 shadow-sm sm:rounded-3xl sm:p-6">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">Question {{ index }}</p>
                <p v-if="question.requiredAnswerCount > 1" class="rounded-full bg-amber-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-800">
                    Choose {{ question.requiredAnswerCount }}
                </p>
            </div>
            <h2 class="mt-3 whitespace-pre-line text-[1.05rem] font-semibold leading-8 text-slate-900 sm:text-xl">
                {{ question.question }}
            </h2>
        </div>

        <div class="mt-4 space-y-2.5 sm:mt-6 sm:space-y-3">
            <label
                v-for="(option, optionIndex) in question.options"
                :key="option"
                class="flex cursor-pointer items-start gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-3.5 py-3 transition hover:border-emerald-300 hover:bg-emerald-50 sm:rounded-2xl sm:px-4 sm:py-3"
            >
                <input
                    :name="inputName"
                    :checked="isSelected(option)"
                    :value="option"
                    class="mt-1"
                    :type="question.allowsMultipleAnswers ? 'checkbox' : 'radio'"
                >
                <span class="text-sm leading-6 text-slate-700 sm:text-[15px] sm:leading-7">
                    <span class="mr-2 font-semibold text-slate-500">{{ optionLabel(optionIndex) }}.</span>{{ option }}
                </span>
            </label>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    index: { type: Number, required: true },
    question: { type: Object, required: true },
    selectedAnswer: { type: [String, Array], default: '' },
});

const inputName = computed(() => props.question.allowsMultipleAnswers
    ? `answers[${props.question.id}][]`
    : `answers[${props.question.id}]`);

function isSelected(option) {
    if (Array.isArray(props.selectedAnswer)) {
        return props.selectedAnswer.includes(option);
    }

    return props.selectedAnswer === option;
}

function optionLabel(index) {
    return String.fromCharCode(65 + index);
}
</script>

