<template>
    <main class="page-shell max-w-5xl">
        <p class="app-eyebrow">{{ quiz.level.name || t('quizTake.fallbackLevel') }}</p>
        <h1 class="app-title">{{ quiz.title }}</h1>
        <p class="app-subtitle">{{ quiz.description || t('quizTake.fallbackDescription') }}</p>

        <p v-if="errors.answers?.length" class="app-help mt-6">{{ errors.answers[0] }}</p>

        <form ref="quizForm" :action="quiz.submitUrl" method="POST" class="mt-8 space-y-5" @change="handleFormChange" @submit="handleSubmit">
            <input type="hidden" name="_token" :value="csrfToken">

            <KanjiQuizQuestionCard
                v-for="(question, index) in quiz.questions"
                :key="question.id"
                :index="index + 1"
                :question="question"
                :selected-answer="selectedAnswers[question.id] || ''"
            />

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="app-btn">{{ t('quizTake.submitAnswers') }}</button>
                <a :href="routes.detail" class="app-link">{{ t('quizTake.backToQuizDetail') }}</a>
            </div>
        </form>
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
const resumeId = computed(() => `quiz:${props.routes.detail}`);

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
        progressLabel: `${Object.keys(selectedAnswers.value).length} / ${props.quiz.questions.length}`,
        state: {
            answers: selectedAnswers.value,
        },
    });
}

function restoreQuizState() {
    const savedAnswers = props.studyState?.answers;

    if (savedAnswers && typeof savedAnswers === 'object') {
        selectedAnswers.value = {
            ...selectedAnswers.value,
            ...savedAnswers,
        };
    }
}

function syncQuizProgress() {
    const answeredCount = Object.keys(selectedAnswers.value).filter((key) => selectedAnswers.value[key]).length;
    const entry = {
        id: resumeId.value,
        href: window.location.href,
        title: props.quiz.title,
        subtitle: props.quiz.level.name || t('quizTake.fallbackLevel'),
        progressLabel: `${answeredCount} / ${props.quiz.questions.length}`,
        state: {
            answers: selectedAnswers.value,
        },
    };

    trackStudyHistory(entry);
    saveStudyResume(entry);
}
</script>
