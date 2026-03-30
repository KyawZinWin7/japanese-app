<template>
    <main class="page-shell max-w-5xl">
        <p class="app-eyebrow">{{ quiz.level.name || t('quizTake.fallbackLevel') }}</p>
        <h1 class="app-title">{{ quiz.title }}</h1>
        <p class="app-subtitle">{{ quiz.description || t('quizTake.fallbackDescription') }}</p>

        <p v-if="errors.answers?.length" class="app-help mt-6">{{ errors.answers[0] }}</p>

        <form :action="quiz.submitUrl" method="POST" class="mt-8 space-y-5">
            <input type="hidden" name="_token" :value="csrfToken">

            <KanjiQuizQuestionCard
                v-for="(question, index) in quiz.questions"
                :key="question.id"
                :index="index + 1"
                :question="question"
                :selected-answer="oldAnswers[question.id] || ''"
            />

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="app-btn">{{ t('quizTake.submitAnswers') }}</button>
                <a :href="routes.detail" class="app-link">{{ t('quizTake.backToQuizDetail') }}</a>
            </div>
        </form>
    </main>
</template>

<script setup>
import KanjiQuizQuestionCard from '../components/quizzes/KanjiQuizQuestionCard.vue';
import { t } from '../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    oldAnswers: { type: Object, required: true },
    quiz: { type: Object, required: true },
    routes: { type: Object, required: true },
});
</script>