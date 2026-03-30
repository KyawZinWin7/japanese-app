<template>
    <form :action="action" method="POST" class="space-y-5 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="method !== 'POST'" type="hidden" name="_method" :value="method">
        <input type="hidden" name="is_active" value="0">

        <div>
            <label for="jlpt_level_id" class="app-label">JLPT Level</label>
            <select id="jlpt_level_id" name="jlpt_level_id" :value="item.jlpt_level_id" class="app-input" required>
                <option value="">Choose a level</option>
                <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
            </select>
            <p v-if="errors.jlpt_level_id?.length" class="app-help">{{ errors.jlpt_level_id[0] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="name" class="app-label">Source Name</label>
                <input id="name" name="name" type="text" :value="item.name" class="app-input" required>
                <p v-if="errors.name?.length" class="app-help">{{ errors.name[0] }}</p>
            </div>
            <div>
                <label for="slug" class="app-label">Slug</label>
                <input id="slug" name="slug" type="text" :value="item.slug" class="app-input" required>
                <p v-if="errors.slug?.length" class="app-help">{{ errors.slug[0] }}</p>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="content_type" class="app-label">Content Type</label>
                <select id="content_type" name="content_type" :value="item.content_type" class="app-input" required>
                    <option v-for="type in contentTypes" :key="type.value" :value="type.value">{{ type.label }}</option>
                </select>
                <p v-if="errors.content_type?.length" class="app-help">{{ errors.content_type[0] }}</p>
            </div>
            <div>
                <label for="sort_order" class="app-label">Sort Order</label>
                <input id="sort_order" name="sort_order" type="number" min="1" max="9999" :value="item.sort_order" class="app-input" required>
                <p v-if="errors.sort_order?.length" class="app-help">{{ errors.sort_order[0] }}</p>
            </div>
        </div>

        <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
            <input type="checkbox" name="is_active" value="1" :checked="Boolean(Number(item.is_active) || item.is_active)">
            Active source
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="app-btn">{{ submitLabel }}</button>
            <a :href="indexUrl" class="app-link">Back to sources</a>
        </div>
    </form>
</template>

<script setup>
defineProps({
    action: { type: String, required: true },
    contentTypes: { type: Array, required: true },
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    indexUrl: { type: String, required: true },
    item: { type: Object, required: true },
    levels: { type: Array, required: true },
    method: { type: String, default: 'POST' },
    submitLabel: { type: String, required: true },
});
</script>
