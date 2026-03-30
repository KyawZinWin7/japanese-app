<template>
    <form :action="action" method="POST" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Level Name</label>
            <input
                id="name"
                name="name"
                type="text"
                :value="level.name"
                placeholder="N5"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500"
                required
            >
            <p v-if="errors.name?.length" class="mt-2 text-sm text-rose-600">{{ errors.name[0] }}</p>
        </div>

        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
            <input
                id="slug"
                name="slug"
                type="text"
                :value="level.slug"
                placeholder="n5"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500"
                required
            >
            <p v-if="errors.slug?.length" class="mt-2 text-sm text-rose-600">{{ errors.slug[0] }}</p>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700">Sort Order</label>
            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="1"
                max="99"
                :value="level.sort_order"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500"
                required
            >
            <p v-if="errors.sort_order?.length" class="mt-2 text-sm text-rose-600">{{ errors.sort_order[0] }}</p>
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500"
                placeholder="Introductory level description"
            >{{ level.description }}</textarea>
            <p v-if="errors.description?.length" class="mt-2 text-sm text-rose-600">{{ errors.description[0] }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="submit"
                class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            >
                {{ submitLabel }}
            </button>
            <a :href="indexUrl" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back to levels</a>
        </div>
    </form>
</template>

<script setup>
defineProps({
    action: { type: String, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    indexUrl: { type: String, required: true },
    level: { type: Object, required: true },
    method: { type: String, default: 'POST' },
    submitLabel: { type: String, required: true },
});
</script>
