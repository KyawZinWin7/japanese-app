<template>
    <main class="page-shell max-w-3xl">
        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
            <p class="app-eyebrow">{{ t('passwordChange.eyebrow') }}</p>
            <h1 class="app-title">{{ t('passwordChange.title') }}</h1>
            <p class="app-subtitle">{{ t('passwordChange.subtitle', { email: user.email }) }}</p>

            <p v-if="status" class="app-status mt-5">
                {{ status }}
            </p>

            <form :action="routes.updatePassword" method="POST" class="mt-8 space-y-5">
                <input type="hidden" name="_token" :value="csrfToken">

                <div>
                    <label for="current_password" class="app-label">{{ t('passwordChange.currentPassword') }}</label>
                    <input id="current_password" name="current_password" type="password" class="app-input" autocomplete="current-password" required>
                    <p v-if="errors.current_password?.length" class="app-help">{{ errors.current_password[0] }}</p>
                </div>

                <div>
                    <label for="password" class="app-label">{{ t('passwordChange.newPassword') }}</label>
                    <input id="password" name="password" type="password" class="app-input" autocomplete="new-password" required>
                    <p v-if="errors.password?.length" class="app-help">{{ errors.password[0] }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="app-label">{{ t('passwordChange.confirmPassword') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="app-input" autocomplete="new-password" required>
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                    <button type="submit" class="app-btn">{{ t('passwordChange.submit') }}</button>
                    <a :href="routes.profile" class="app-btn-secondary">{{ t('passwordChange.back') }}</a>
                </div>
            </form>
        </section>
    </main>
</template>

<script setup>
import { t } from '../../frontendI18n';

defineProps({
    csrfToken: { type: String, required: true },
    errors: { type: Object, required: true },
    routes: { type: Object, required: true },
    status: { type: String, default: null },
    user: { type: Object, required: true },
});
</script>
