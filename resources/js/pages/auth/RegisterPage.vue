<template>
    <main class="auth-shell">
        <section class="auth-card">
            <p class="app-eyebrow">{{ t('common.app') }}</p>
            <h1 class="app-title">{{ t('auth.registerTitle') }}</h1>
            <p class="app-subtitle">{{ t('auth.registerText') }}</p>

            <div class="mt-8 space-y-3">
                <a :href="routes.google" class="flex w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">
                    <span class="text-lg">G</span>
                    <span>{{ t('auth.continueGoogle') }}</span>
                </a>
            </div>

            <div class="mt-6 flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                <span class="h-px flex-1 bg-slate-200"></span>
                <span>{{ t('auth.orEmail') }}</span>
                <span class="h-px flex-1 bg-slate-200"></span>
            </div>

            <form :action="routes.register" method="POST" class="mt-6 space-y-5">
                <input type="hidden" name="_token" :value="csrfToken">

                <div>
                    <label for="name" class="app-label">{{ t('auth.name') }}</label>
                    <input id="name" name="name" type="text" :value="old.name" class="app-input" autocomplete="name" required>
                    <p v-if="errors.name?.length" class="app-help">{{ errors.name[0] }}</p>
                </div>

                <div>
                    <label for="email" class="app-label">{{ t('auth.email') }}</label>
                    <input id="email" name="email" type="email" :value="old.email" class="app-input" autocomplete="email" required>
                    <p v-if="errors.email?.length" class="app-help">{{ errors.email[0] }}</p>
                </div>

                <div>
                    <label for="password" class="app-label">{{ t('auth.password') }}</label>
                    <input id="password" name="password" type="password" class="app-input" autocomplete="new-password" required>
                    <p v-if="errors.password?.length" class="app-help">{{ errors.password[0] }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="app-label">{{ t('auth.confirmPassword') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="app-input" autocomplete="new-password" required>
                </div>

                <button type="submit" class="app-btn w-full">{{ t('auth.registerTitle') }}</button>
            </form>

            <p class="mt-6 text-sm text-slate-600">
                {{ t('auth.alreadyAccount') }}
                <a :href="routes.login" class="font-semibold text-emerald-700 hover:text-emerald-600">{{ t('auth.signIn') }}</a>
            </p>
        </section>
    </main>
</template>

<script setup>
import { t } from '../../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    old: { type: Object, required: true },
    routes: { type: Object, required: true },
});
</script>
