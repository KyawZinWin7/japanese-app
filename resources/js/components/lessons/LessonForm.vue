<template>
    <form :action="action" method="POST" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
        <input type="hidden" name="is_published" value="0">

        <div>
            <label for="jlpt_level_id" class="mb-2 block text-sm font-medium text-slate-700">JLPT Level</label>
            <select
                id="jlpt_level_id"
                name="jlpt_level_id"
                :value="lesson.jlpt_level_id"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500"
                required
            >
                <option value="">Choose a level</option>
                <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
            </select>
            <p v-if="errors.jlpt_level_id?.length" class="mt-2 text-sm text-rose-600">{{ errors.jlpt_level_id[0] }}</p>
        </div>

        <div>
            <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
            <input id="title" name="title" type="text" :value="lesson.title" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
            <p v-if="errors.title?.length" class="mt-2 text-sm text-rose-600">{{ errors.title[0] }}</p>
        </div>

        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
            <input id="slug" name="slug" type="text" :value="lesson.slug" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
            <p v-if="errors.slug?.length" class="mt-2 text-sm text-rose-600">{{ errors.slug[0] }}</p>
        </div>

        <div>
            <label for="excerpt" class="mb-2 block text-sm font-medium text-slate-700">Excerpt</label>
            <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500">{{ lesson.excerpt }}</textarea>
            <p v-if="errors.excerpt?.length" class="mt-2 text-sm text-rose-600">{{ errors.excerpt[0] }}</p>
        </div>

        <div>
            <label for="content" class="mb-2 block text-sm font-medium text-slate-700">Content</label>
            <textarea id="content" name="content" rows="12" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>{{ lesson.content }}</textarea>
            <p v-if="errors.content?.length" class="mt-2 text-sm text-rose-600">{{ errors.content[0] }}</p>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" min="1" max="9999" :value="lesson.sort_order" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500" required>
            <p v-if="errors.sort_order?.length" class="mt-2 text-sm text-rose-600">{{ errors.sort_order[0] }}</p>
        </div>

        <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
            <input type="checkbox" name="is_published" value="1" :checked="Boolean(Number(lesson.is_published) || lesson.is_published)">
            Publish this lesson
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">{{ submitLabel }}</button>
            <a :href="indexUrl" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back to lessons</a>
        </div>
    </form>
</template>

<script setup>
defineProps({
    action: { type: String, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    indexUrl: { type: String, required: true },
    lesson: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, default: 'POST' },
    submitLabel: { type: String, required: true },
});
</script>
