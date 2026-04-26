<template>
    <form :action="action" method="POST" class="space-y-6 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
        <input type="hidden" name="is_published" value="0">

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="jlpt_level_id" class="app-label">JLPT Level</label>
                <select id="jlpt_level_id" v-model="selectedLevelId" name="jlpt_level_id" class="app-input" required>
                    <option value="">Choose a level</option>
                    <option v-for="level in levels" :key="level.id" :value="String(level.id)">{{ level.name }}</option>
                </select>
                <p v-if="errors.jlpt_level_id?.length" class="app-help">{{ errors.jlpt_level_id[0] }}</p>
            </div>

            <label class="mt-7 flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                <input type="checkbox" name="is_published" value="1" :checked="Boolean(Number(quiz.is_published) || quiz.is_published)">
                Publish this quiz
            </label>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="title" class="app-label">Quiz Title</label>
                <input id="title" v-model="titleValue" name="title" type="text" class="app-input" required>
                <p v-if="errors.title?.length" class="app-help">{{ errors.title[0] }}</p>
            </div>
            <div>
                <label for="slug" class="app-label">Slug</label>
                <input id="slug" v-model="slugValue" name="slug" type="text" class="app-input" @input="handleSlugInput">
                <p class="app-help">Auto-generated from the title. Example: <code>n5-basic-kanji-quiz</code>.</p>
                <p v-if="errors.slug?.length" class="app-help">{{ errors.slug[0] }}</p>
            </div>
        </div>

        <div>
            <label for="description" class="app-label">Description</label>
            <textarea id="description" v-model="descriptionValue" name="description" rows="3" class="app-input" placeholder="Short summary for learners"></textarea>
            <p v-if="errors.description?.length" class="app-help">{{ errors.description[0] }}</p>
        </div>

        <section class="rounded-3xl border border-slate-200 bg-slate-50/70 p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Questions</h2>
                    <p class="mt-1 text-sm text-slate-500">Add kanji, grammar, or vocabulary questions and set multiple-choice answers.</p>
                </div>
                <button type="button" class="app-btn" @click="addQuestion">Add Question</button>
            </div>

            <div class="mt-6 space-y-5">
                <article v-for="(question, index) in questions" :key="question.uid" class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <input v-if="question.id" :name="`questions[${index}][id]`" :value="question.id" type="hidden">

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">Question {{ index + 1 }}</p>
                            <p class="mt-2 text-sm text-slate-500">Set the quiz type, question text, and answer choices.</p>
                        </div>
                        <button type="button" class="app-link text-rose-600 hover:text-rose-500" @click="removeQuestion(index)" :disabled="questions.length === 1">Remove</button>
                    </div>

                    <div class="mt-5 grid gap-5 md:grid-cols-[minmax(0,1fr),140px]">
                        <div>
                            <label :for="`quiz-type-${question.uid}`" class="app-label">Quiz Type</label>
                            <select :id="`quiz-type-${question.uid}`" v-model="question.quiz_type" :name="`questions[${index}][quiz_type]`" class="app-input" required>
                                <option value="kanji">Kanji</option>
                                <option value="grammar">Grammar</option>
                                <option value="vocab">Vocab</option>
                            </select>
                        </div>
                        <div>
                            <label :for="`sort-order-${question.uid}`" class="app-label">Order</label>
                            <input :id="`sort-order-${question.uid}`" v-model="question.sort_order" :name="`questions[${index}][sort_order]`" type="number" min="1" max="9999" class="app-input" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label :for="`question-${question.uid}`" class="app-label">Question</label>
                        <input :id="`question-${question.uid}`" v-model="question.question" :name="`questions[${index}][question]`" type="text" class="app-input" required>
                    </div>

                    <div class="mt-5">
                        <label :for="`highlight-${question.uid}`" class="app-label">Highlight Text</label>
                        <input :id="`highlight-${question.uid}`" v-model="question.highlight_text" :name="`questions[${index}][highlight_text]`" type="text" class="app-input" placeholder="Optional text to show in red inside the question">
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div v-for="(option, optionIndex) in question.options" :key="`${question.uid}-${optionIndex}`">
                            <label :for="`option-${question.uid}-${optionIndex}`" class="app-label">Option {{ optionIndex + 1 }}</label>
                            <input :id="`option-${question.uid}-${optionIndex}`" v-model="question.options[optionIndex]" :name="`questions[${index}][options][]`" type="text" class="app-input" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label :for="`correct-answer-${question.uid}`" class="app-label">Correct Answer</label>
                        <select :id="`correct-answer-${question.uid}`" v-model="question.correct_answer" :name="`questions[${index}][correct_answer]`" class="app-input" required>
                            <option value="">Choose the correct answer</option>
                            <option v-for="option in filledOptions(question.options)" :key="option" :value="option">{{ option }}</option>
                        </select>
                    </div>

                    <div class="mt-5">
                        <label :for="`explanation-${question.uid}`" class="app-label">Explanation</label>
                        <textarea :id="`explanation-${question.uid}`" v-model="question.explanation" :name="`questions[${index}][explanation]`" rows="3" class="app-input" placeholder="Optional feedback shown after submission"></textarea>
                    </div>

                    <p v-if="questionErrorSummary(index)" class="app-help mt-4">{{ questionErrorSummary(index) }}</p>
                </article>
            </div>
        </section>

        <div v-if="generalErrors.length" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p v-for="error in generalErrors" :key="error">{{ error }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="app-btn">{{ submitLabel }}</button>
            <a :href="indexUrl" class="app-link">Back to quizzes</a>
        </div>
    </form>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    action: { type: String, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    existingQuizzes: { type: Array, default: () => [] },
    indexUrl: { type: String, required: true },
    levels: { type: Array, required: true },
    method: { type: String, default: 'POST' },
    quiz: { type: Object, required: true },
    submitLabel: { type: String, required: true },
});

const selectedLevelId = ref(props.quiz.jlpt_level_id ? String(props.quiz.jlpt_level_id) : '');
const titleValue = ref(props.quiz.title ?? '');
const slugValue = ref(props.quiz.slug ?? '');
const descriptionValue = ref(props.quiz.description ?? '');
const slugEditedManually = ref(Boolean(props.quiz.slug));
const currentQuizId = props.quiz.id ?? null;
const nextUid = ref(1);
const questions = ref((props.quiz.questions ?? []).map((question, index) => buildQuestion(question, index + 1)));

const existingSlugs = computed(() => new Set(
    props.existingQuizzes
        .filter((item) => item.id !== currentQuizId)
        .map((item) => item.slug),
));

const generalErrors = computed(() => Object.entries(props.errors)
    .filter(([key]) => key === 'questions' || (! key.startsWith('questions.') && key !== 'jlpt_level_id' && key !== 'title' && key !== 'slug' && key !== 'description'))
    .flatMap(([, value]) => value));

watch(titleValue, () => {
    if (! slugEditedManually.value) {
        slugValue.value = buildSuggestedSlug();
    }
}, { immediate: true });

function buildQuestion(question = {}, fallbackOrder = 1) {
    const options = Array.isArray(question.options) ? [...question.options] : [];

    while (options.length < 4) {
        options.push('');
    }

    return {
        uid: nextUid.value++,
        id: question.id ?? null,
        quiz_type: question.quiz_type || 'kanji',
        question: question.question || '',
        highlight_text: question.highlight_text || '',
        options: options.slice(0, 6),
        correct_answer: question.correct_answer || '',
        explanation: question.explanation || '',
        sort_order: String(question.sort_order || fallbackOrder),
    };
}

function addQuestion() {
    questions.value.push(buildQuestion({}, questions.value.length + 1));
}

function removeQuestion(index) {
    if (questions.value.length === 1) {
        return;
    }

    questions.value.splice(index, 1);
    questions.value.forEach((question, currentIndex) => {
        question.sort_order = String(currentIndex + 1);
    });
}

function buildSuggestedSlug() {
    const normalized = String(titleValue.value)
        .toLowerCase()
        .trim()
        .replace(/['"]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    const base = normalized ? (normalized.endsWith('-quiz') ? normalized : `${normalized}-quiz`) : 'kanji-quiz';

    if (! existingSlugs.value.has(base)) {
        return base;
    }

    let suffix = 2;
    let candidate = `${base}-${suffix}`;

    while (existingSlugs.value.has(candidate)) {
        suffix += 1;
        candidate = `${base}-${suffix}`;
    }

    return candidate;
}

function handleSlugInput(event) {
    slugEditedManually.value = event.target.value !== '';
}

function filledOptions(options) {
    return options.filter((option) => String(option).trim() !== '');
}

function questionErrorSummary(index) {
    const prefix = `questions.${index}.`;
    const messages = Object.entries(props.errors)
        .filter(([key]) => key.startsWith(prefix))
        .flatMap(([, value]) => value);

    return messages[0] || '';
}
</script>
