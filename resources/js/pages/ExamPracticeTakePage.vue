<template>
    <main class="page-shell max-w-5xl pb-28 sm:pb-10">
        <section class="sm:hidden">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="app-eyebrow">{{ set.exam_code || 'Exam Practice' }}</p>
                    <h1 class="mt-2 text-[1.65rem] font-semibold leading-tight text-slate-950">{{ set.title }}</h1>
                </div>
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-600">{{ set.description || 'Answer each question before moving to the next one.' }}</p>
        </section>

        <section class="hidden sm:block">
            <p class="app-eyebrow">{{ set.exam_code || 'Exam Practice' }}</p>
            <h1 class="app-title">{{ set.title }}</h1>
            <p class="app-subtitle">{{ set.description || 'Answer each question before moving to the next one.' }}</p>
        </section>

        <p v-if="errors.answers?.length" class="app-help mt-4 sm:mt-6">{{ errors.answers[0] }}</p>

        <form id="exam-practice-form" ref="quizForm" :action="set.submitUrl" method="POST" class="mt-5 space-y-4 sm:mt-8 sm:space-y-5" @change="handleFormChange" @submit="handleSubmit">
            <input type="hidden" name="_token" :value="csrfToken">
            <input
                v-for="entry in persistedAnswerEntries"
                :key="entry.key"
                :name="entry.name"
                :value="entry.value"
                type="hidden"
            >
            <input
                v-for="questionId in revealedQuestionIds"
                :key="`revealed-${questionId}`"
                name="revealed_questions[]"
                :value="questionId"
                type="hidden"
            >

            <div class="rounded-[1.35rem] border border-slate-200 bg-white px-4 py-2.5 shadow-sm sm:rounded-3xl sm:px-5 sm:py-4">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-[13px] font-medium text-slate-700 sm:text-sm">
                        Question {{ currentQuestionIndex + 1 }} / {{ set.questions.length }}
                    </p>
                    <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500 sm:block sm:text-sm">
                        <span>{{ answeredCount }} / {{ set.questions.length }} answered</span>
                        <span class="sm:hidden">{{ progressPercent }}%</span>
                    </div>
                </div>
                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100 sm:mt-3 sm:h-2">
                    <div class="h-full rounded-full bg-emerald-500 transition-all" :style="{ width: `${progressPercent}%` }" />
                </div>
            </div>

            <div class="rounded-[1.35rem] border border-slate-200 bg-white p-3 shadow-sm sm:rounded-3xl sm:p-4">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-slate-700">Question Navigator</p>
                    <p class="text-xs text-slate-500">Choose a question</p>
                </div>
                <label class="block">
                    <span class="sr-only">Select question</span>
                    <select
                        :value="currentQuestionIndex"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 outline-none transition focus:border-emerald-500 focus:bg-white"
                        @change="handleQuestionSelect"
                    >
                        <option
                            v-for="(question, index) in set.questions"
                            :key="question.id"
                            :value="index"
                        >
                            Question {{ index + 1 }}<template v-if="isQuestionAnswered(question, selectedAnswers[question.id])"> - Answered</template>
                        </option>
                    </select>
                </label>
            </div>

            <ExamPracticeQuestionCard
                :key="currentQuestion.id"
                :index="currentQuestionIndex + 1"
                :question="currentQuestion"
                :selected-answer="selectedAnswers[currentQuestion.id] ?? defaultSelectedValue(currentQuestion)"
                :show-answer="shouldShowAnswer(currentQuestion)"
                :show-check-result="hasCheckedCurrentQuestion"
                :is-correct="currentQuestionIsCorrect"
                :can-check-answer="currentQuestionAnswered"
                :can-toggle-answer="canToggleCurrentAnswer"
                @check-answer="checkCurrentAnswer"
                @toggle-answer="toggleCurrentAnswer"
            />

            <div class="hidden flex-wrap items-center gap-3 sm:flex">
                <button type="button" class="app-btn-secondary" :disabled="currentQuestionIndex === 0" @click="goToPrevious">
                    Previous
                </button>
                <button v-if="!isLastQuestion" type="button" class="app-btn" :disabled="!canMoveNext" @click="goToNext">
                    Next
                </button>
                <button v-else type="submit" class="app-btn" :disabled="!canMoveNext">Submit Answers</button>
                <a :href="routes.detail" class="app-link">Back to Set</a>
            </div>
        </form>

        <div class="fixed inset-x-0 bottom-0 z-20 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-[0_-12px_30px_-18px_rgba(15,23,42,0.45)] backdrop-blur sm:hidden">
            <div class="mx-auto flex max-w-5xl flex-col gap-3">
                <div class="flex items-center justify-between text-sm text-slate-500">
                    <span>Question {{ currentQuestionIndex + 1 }} of {{ set.questions.length }}</span>
                    <span>{{ answeredCount }} answered</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="app-btn-secondary w-full justify-center" :disabled="currentQuestionIndex === 0" @click="goToPrevious">
                        Previous
                    </button>
                    <button v-if="!isLastQuestion" type="button" class="app-btn w-full justify-center" :disabled="!canMoveNext" @click="goToNext">
                        Next
                    </button>
                    <button v-else type="submit" form="exam-practice-form" class="app-btn w-full justify-center" :disabled="!canMoveNext">
                        Submit Answers
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import { computed, nextTick, onMounted, ref } from 'vue';
import ExamPracticeQuestionCard from '../components/exam-practice/ExamPracticeQuestionCard.vue';
import { clearStudyResume, saveStudyResume, trackStudyHistory } from '../studyHistory';

const props = defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    oldAnswers: { type: Object, required: true },
    routes: { type: Object, required: true },
    set: { type: Object, required: true },
    studyState: { type: Object, default: () => ({}) },
});

const quizForm = ref(null);
const selectedAnswers = ref(normalizeOldAnswers(props.oldAnswers, props.set.questions));
const currentQuestionIndex = ref(0);
const checkedQuestionStates = ref({});
const revealedQuestions = ref({});
const resumeId = computed(() => `quiz:${props.routes.detail}`);
const currentQuestion = computed(() => props.set.questions[currentQuestionIndex.value]);
const currentQuestionAnswered = computed(() => isQuestionAnswered(currentQuestion.value, selectedAnswers.value[currentQuestion.value?.id]));
const currentQuestionCorrectAnswers = computed(() => normalizeToArray(currentQuestion.value?.correctAnswers));
const currentQuestionIsCorrect = computed(() => answersMatch(
    normalizeToArray(selectedAnswers.value[currentQuestion.value?.id]),
    currentQuestionCorrectAnswers.value,
));
const hasCheckedCurrentQuestion = computed(() => checkedQuestionStates.value[currentQuestion.value?.id] === true);
const canToggleCurrentAnswer = computed(() => {
    if (shouldShowAnswer(currentQuestion.value)) {
        return true;
    }

    return hasCheckedCurrentQuestion.value;
});
const canMoveNext = computed(() => currentQuestionAnswered.value);
const isLastQuestion = computed(() => currentQuestionIndex.value === props.set.questions.length - 1);
const answeredCount = computed(() => props.set.questions.filter((question) => isQuestionAnswered(question, selectedAnswers.value[question.id])).length);
const progressPercent = computed(() => Math.round((answeredCount.value / props.set.questions.length) * 100));
const persistedAnswerEntries = computed(() => buildPersistedEntries(selectedAnswers.value, currentQuestion.value));
const revealedQuestionIds = computed(() => Object.keys(revealedQuestions.value).filter((questionId) => revealedQuestions.value[questionId]));

onMounted(async () => {
    restoreExamPracticeState();
    await nextTick();
    syncExamPracticeProgress();
});

function normalizeOldAnswers(oldAnswers, questions) {
    const normalized = {};

    for (const question of questions) {
        const value = oldAnswers?.[question.id];

        if (question.allowsMultipleAnswers) {
            normalized[question.id] = normalizeToArray(value);
        } else if (typeof value === 'string') {
            normalized[question.id] = value;
        }
    }

    return normalized;
}

function normalizeToArray(value) {
    if (Array.isArray(value)) {
        return value.filter((item) => String(item).trim() !== '');
    }

    return value ? [value] : [];
}

function defaultSelectedValue(question) {
    return question?.allowsMultipleAnswers ? [] : '';
}

function handleFormChange() {
    const data = new FormData(quizForm.value);
    const answers = {};

    for (const [key, value] of data.entries()) {
        const multiMatch = key.match(/^answers\[(.+)\]\[\]$/);

        if (multiMatch) {
            const questionId = multiMatch[1];
            answers[questionId] = [...(answers[questionId] ?? []), value];
            continue;
        }

        const singleMatch = key.match(/^answers\[(.+)\]$/);

        if (singleMatch) {
            answers[singleMatch[1]] = value;
        }
    }

    selectedAnswers.value = answers;
    checkedQuestionStates.value[currentQuestion.value?.id] = false;
    revealedQuestions.value[currentQuestion.value?.id] = false;
    syncExamPracticeProgress();
}

function isQuestionAnswered(question, answer) {
    if (!question) {
        return false;
    }

    if (question.allowsMultipleAnswers) {
        return Array.isArray(answer) && answer.length === question.requiredAnswerCount;
    }

    return typeof answer === 'string' && answer !== '';
}

function buildPersistedEntries(answers, activeQuestion) {
    const entries = [];

    for (const [questionId, answer] of Object.entries(answers)) {
        if (String(questionId) === String(activeQuestion?.id)) {
            continue;
        }

        if (Array.isArray(answer)) {
            answer.forEach((value, index) => {
                entries.push({
                    key: `${questionId}-${index}`,
                    name: `answers[${questionId}][]`,
                    value,
                });
            });
            continue;
        }

        if (answer) {
            entries.push({
                key: String(questionId),
                name: `answers[${questionId}]`,
                value: answer,
            });
        }
    }

    return entries;
}

function answersMatch(selected, correct) {
    return [...selected].sort().join('||') === [...correct].sort().join('||');
}

function restoreExamPracticeState() {
    const savedAnswers = props.studyState?.answers;
    const savedCheckedStates = props.studyState?.checkedQuestionStates;
    const savedRevealedQuestions = props.studyState?.revealedQuestions;
    const savedQuestionIndex = Number(props.studyState?.currentQuestionIndex);

    if (savedAnswers && typeof savedAnswers === 'object') {
        selectedAnswers.value = {
            ...selectedAnswers.value,
            ...savedAnswers,
        };
    }

    if (savedCheckedStates && typeof savedCheckedStates === 'object') {
        checkedQuestionStates.value = { ...savedCheckedStates };
    }

    if (savedRevealedQuestions && typeof savedRevealedQuestions === 'object') {
        revealedQuestions.value = { ...savedRevealedQuestions };
    }

    if (Number.isInteger(savedQuestionIndex) && savedQuestionIndex >= 0 && savedQuestionIndex < props.set.questions.length) {
        currentQuestionIndex.value = savedQuestionIndex;
        return;
    }

    const firstUnansweredIndex = props.set.questions.findIndex((question) => !isQuestionAnswered(question, selectedAnswers.value[question.id]));

    currentQuestionIndex.value = firstUnansweredIndex === -1 ? 0 : firstUnansweredIndex;
}

function syncExamPracticeProgress() {
    const entry = {
        id: resumeId.value,
        href: window.location.href,
        title: props.set.title,
        subtitle: props.set.exam_code || 'Exam Practice',
        progressLabel: `${answeredCount.value} / ${props.set.questions.length}`,
        state: {
            answers: selectedAnswers.value,
            checkedQuestionStates: checkedQuestionStates.value,
            revealedQuestions: revealedQuestions.value,
            currentQuestionIndex: currentQuestionIndex.value,
        },
    };

    trackStudyHistory(entry);
    saveStudyResume(entry);
}

function checkCurrentAnswer() {
    if (!currentQuestionAnswered.value) {
        return;
    }

    checkedQuestionStates.value[currentQuestion.value.id] = true;
    syncExamPracticeProgress();
}

function toggleCurrentAnswer() {
    if (!canToggleCurrentAnswer.value) {
        return;
    }

    const questionId = currentQuestion.value.id;
    revealedQuestions.value[questionId] = !revealedQuestions.value[questionId];
    syncExamPracticeProgress();
}

function shouldShowAnswer(question) {
    return revealedQuestions.value[question?.id] === true;
}

function goToNext() {
    if (!canMoveNext.value || isLastQuestion.value) {
        return;
    }

    currentQuestionIndex.value += 1;
    syncExamPracticeProgress();
}

function goToPrevious() {
    if (currentQuestionIndex.value === 0) {
        return;
    }

    currentQuestionIndex.value -= 1;
    syncExamPracticeProgress();
}

function goToQuestion(index) {
    if (index < 0 || index >= props.set.questions.length) {
        return;
    }

    currentQuestionIndex.value = index;
}

function handleQuestionSelect(event) {
    goToQuestion(Number(event.target.value));
}

function handleSubmit() {
    clearStudyResume({
        id: resumeId.value,
        href: window.location.href,
        title: props.set.title,
        subtitle: props.set.exam_code || 'Exam Practice',
        progressLabel: `${answeredCount.value} / ${props.set.questions.length}`,
        state: {
            answers: selectedAnswers.value,
            checkedQuestionStates: checkedQuestionStates.value,
            revealedQuestions: revealedQuestions.value,
            currentQuestionIndex: currentQuestionIndex.value,
        },
    });
}
</script>
