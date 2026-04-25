<template>
    <main class="page-shell max-w-5xl pb-28 sm:pb-10">
        <p class="app-eyebrow">{{ quiz.level.name || t('quizTake.fallbackLevel') }}</p>
        <h1 class="app-title">{{ quiz.title }}</h1>
        <p class="app-subtitle">{{ quiz.description || t('quizTake.fallbackDescription') }}</p>

        <p v-if="errors.answers?.length" class="app-help mt-6">{{ errors.answers[0] }}</p>

        <form id="quiz-step-form" ref="quizForm" :action="quiz.submitUrl" method="POST" class="mt-8 space-y-5" @change="handleFormChange" @submit="handleSubmit">
            <input type="hidden" name="_token" :value="csrfToken">
            <input
                v-for="([questionId, answer]) in persistedAnswerEntries"
                :key="questionId"
                :name="`answers[${questionId}]`"
                :value="answer"
                type="hidden"
            >

            <div class="flex flex-col gap-3 rounded-3xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:px-5">
                <p class="text-sm font-medium text-slate-600">
                    {{ t('quizTake.question', { index: currentQuestionIndex + 1 }) }} / {{ quiz.questions.length }}
                </p>
                <div class="flex items-center justify-between gap-3 sm:justify-end">
                    <p class="text-sm text-slate-500">{{ answeredCount }} / {{ quiz.questions.length }} answered</p>
                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100 sm:w-32 sm:flex-none">
                        <div
                            class="h-full rounded-full bg-emerald-500 transition-all"
                            :style="{ width: `${progressPercent}%` }"
                        />
                    </div>
                </div>
            </div>

            <KanjiQuizQuestionCard
                :key="currentQuestion.id"
                :index="currentQuestionIndex + 1"
                :question="currentQuestion"
                :selected-answer="selectedAnswers[currentQuestion.id] || ''"
            />

            <div class="hidden flex-wrap items-center gap-3 sm:flex">
                <button type="button" class="app-btn-secondary" :disabled="currentQuestionIndex === 0" @click="goToPrevious">
                    Previous
                </button>
                <button
                    v-if="!isLastQuestion"
                    type="button"
                    class="app-btn"
                    :disabled="!currentAnswer"
                    @click="goToNext"
                >
                    Next
                </button>
                <button v-else type="submit" class="app-btn" :disabled="!currentAnswer">{{ t('quizTake.submitAnswers') }}</button>
                <a :href="routes.detail" class="app-link">{{ t('quizTake.backToQuizDetail') }}</a>
            </div>
        </form>

        <div class="fixed inset-x-0 bottom-0 z-20 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-[0_-12px_30px_-18px_rgba(15,23,42,0.45)] backdrop-blur sm:hidden">
            <div class="mx-auto flex max-w-5xl flex-col gap-3">
                <div class="flex items-center justify-between text-sm text-slate-500">
                    <span>Question {{ currentQuestionIndex + 1 }} of {{ quiz.questions.length }}</span>
                    <span>{{ answeredCount }} answered</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="app-btn-secondary w-full justify-center" :disabled="currentQuestionIndex === 0" @click="goToPrevious">
                        Previous
                    </button>
                    <button
                        v-if="!isLastQuestion"
                        type="button"
                        class="app-btn w-full justify-center"
                        :disabled="!currentAnswer"
                        @click="goToNext"
                    >
                        Next
                    </button>
                    <button
                        v-else
                        type="submit"
                        form="quiz-step-form"
                        class="app-btn w-full justify-center"
                        :disabled="!currentAnswer"
                    >
                        {{ t('quizTake.submitAnswers') }}
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import { computed, nextTick, onMounted, ref } from 'vue';
import KanjiQuizQuestionCard from '../components/quizzes/KanjiQuizQuestionCard.vue';
import { t } from '../frontendI18n';
import { clearStudyResume, saveStudyResume, trackStudyHistory } from '../studyHistory';

const props = defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    oldAnswers: { type: Object, required: true },
    quiz: { type: Object, required: true },
    routes: { type: Object, required: true },
    studyState: { type: Object, default: () => ({}) },
});

const quizForm = ref(null);
const selectedAnswers = ref({ ...props.oldAnswers });
const currentQuestionIndex = ref(0);
const resumeId = computed(() => `quiz:${props.routes.detail}`);
const currentQuestion = computed(() => props.quiz.questions[currentQuestionIndex.value]);
const currentAnswer = computed(() => selectedAnswers.value[currentQuestion.value?.id] || '');
const isLastQuestion = computed(() => currentQuestionIndex.value === props.quiz.questions.length - 1);
const answeredCount = computed(() => Object.keys(selectedAnswers.value).filter((key) => selectedAnswers.value[key]).length);
const progressPercent = computed(() => Math.round((answeredCount.value / props.quiz.questions.length) * 100));
const persistedAnswerEntries = computed(() => Object.entries(selectedAnswers.value)
    .filter(([questionId, answer]) => answer && String(questionId) !== String(currentQuestion.value?.id)));

onMounted(async () => {
    restoreQuizState();
    await nextTick();
    syncQuizProgress();
});

function handleFormChange() {
    const data = new FormData(quizForm.value);
    const answers = {};

    for (const [key, value] of data.entries()) {
        const match = key.match(/^answers\[(.+)\]$/);

        if (match) {
            answers[match[1]] = value;
        }
    }

    selectedAnswers.value = answers;
    syncQuizProgress();
}

function handleSubmit() {
    clearStudyResume({
        id: resumeId.value,
        href: window.location.href,
        title: props.quiz.title,
        subtitle: props.quiz.level.name || t('quizTake.fallbackLevel'),
        progressLabel: `${answeredCount.value} / ${props.quiz.questions.length}`,
        state: {
            answers: selectedAnswers.value,
            currentQuestionIndex: currentQuestionIndex.value,
        },
    });
}

function restoreQuizState() {
    const savedAnswers = props.studyState?.answers;
    const savedQuestionIndex = Number(props.studyState?.currentQuestionIndex);

    if (savedAnswers && typeof savedAnswers === 'object') {
        selectedAnswers.value = {
            ...selectedAnswers.value,
            ...savedAnswers,
        };
    }

    if (Number.isInteger(savedQuestionIndex) && savedQuestionIndex >= 0 && savedQuestionIndex < props.quiz.questions.length) {
        currentQuestionIndex.value = savedQuestionIndex;
        return;
    }

    const firstUnansweredIndex = props.quiz.questions.findIndex((question) => ! selectedAnswers.value[question.id]);

    currentQuestionIndex.value = firstUnansweredIndex === -1 ? 0 : firstUnansweredIndex;
}

function goToNext() {
    if (! currentAnswer.value || isLastQuestion.value) {
        return;
    }

    currentQuestionIndex.value += 1;
    syncQuizProgress();
}

function goToPrevious() {
    if (currentQuestionIndex.value === 0) {
        return;
    }

    currentQuestionIndex.value -= 1;
    syncQuizProgress();
}

function syncQuizProgress() {
    const entry = {
        id: resumeId.value,
        href: window.location.href,
        title: props.quiz.title,
        subtitle: props.quiz.level.name || t('quizTake.fallbackLevel'),
        progressLabel: `${answeredCount.value} / ${props.quiz.questions.length}`,
        state: {
            answers: selectedAnswers.value,
            currentQuestionIndex: currentQuestionIndex.value,
        },
    };

    trackStudyHistory(entry);
    saveStudyResume(entry);
}
</script>
