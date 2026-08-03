<template>
    <main class="page-shell max-w-5xl">
        <p class="app-eyebrow">Exam Practice Result</p>
        <h1 class="app-title">{{ result.setTitle }}</h1>
        <p class="app-subtitle">You scored {{ result.score }} out of {{ result.total }}.</p>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            <section class="section-card">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Score</p>
                <p class="mt-3 text-4xl font-semibold text-slate-900">{{ result.score }}/{{ result.total }}</p>
            </section>
            <section class="section-card md:col-span-2">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Accuracy</p>
                <p class="mt-3 text-4xl font-semibold text-slate-900">{{ result.percentage }}%</p>
            </section>
        </div>

        <div class="mt-8 space-y-4">
            <article v-for="answer in result.answers" :key="answer.question_id" class="content-card">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ answer.question }}</h2>
                        <p class="mt-3 text-slate-600">Your answer: <span class="font-medium text-slate-900">{{ formatAnswer(answer.selected) }}</span></p>
                        <p class="mt-2 text-slate-600">Correct answer: <span class="font-medium text-slate-900">{{ formatAnswer(answer.correct) }}</span></p>
                        <p v-if="answer.explanation" class="mt-2 text-slate-600">{{ answer.explanation }}</p>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-2">
                        <span v-if="answer.answer_revealed" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-800">
                            Answer Revealed
                        </span>
                        <span :class="answer.is_correct ? 'app-badge' : 'rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-700'">
                            {{ answer.is_correct ? 'Correct' : 'Incorrect' }}
                        </span>
                    </div>
                </div>
            </article>
        </div>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a :href="routes.retry" class="app-btn">Try Again</a>
            <a :href="routes.detail" class="app-btn-secondary">Set Detail</a>
            <a :href="routes.index" class="app-link">Back to Exam Practice</a>
        </div>
    </main>
</template>

<script setup>
defineProps({
    result: { type: Object, required: true },
    routes: { type: Object, required: true },
});

function formatAnswer(answer) {
    if (Array.isArray(answer)) {
        return answer.length ? answer.join(', ') : 'No answer';
    }

    return answer || 'No answer';
}
</script>
