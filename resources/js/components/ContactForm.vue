<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import api from '@/composables/useApi';

const { t } = useI18n();

const form = reactive({
  name: '',
  email: '',
  phone: '',
  start_date: '',
  end_date: '',
  guests: '',
  message: '',
});

const errors = reactive<Record<string, string[]>>({});
const loading = ref(false);
const success = ref(false);
const serverError = ref('');

async function submit() {
  loading.value = true;
  serverError.value = '';
  Object.keys(errors).forEach((k) => delete errors[k]);

  try {
    await api.post('/contact', form);
    success.value = true;
    Object.assign(form, { name: '', email: '', phone: '', start_date: '', end_date: '', guests: '', message: '' });
  } catch (err: any) {
    if (err.response?.status === 422) {
      Object.assign(errors, err.response.data.errors);
    } else {
      serverError.value = t('contact.error');
    }
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <!-- Message de succès -->
  <div
    v-if="success"
    role="alert"
    class="p-6 bg-emerald-50 border border-emerald-200 rounded-2xl text-center"
  >
    <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <p class="text-emerald-800 font-medium text-lg">{{ t('contact.success') }}</p>
    <button
      @click="success = false"
      class="mt-4 text-sm text-emerald-600 underline hover:no-underline"
    >
      Envoyer un autre message
    </button>
  </div>

  <!-- Formulaire -->
  <form
    v-else
    @submit.prevent="submit"
    novalidate
    aria-label="Formulaire de contact"
    class="space-y-5"
  >
    <!-- Alerte erreur serveur -->
    <div v-if="serverError" role="alert" class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
      {{ serverError }}
    </div>

    <!-- Nom + Email -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1.5">
          {{ t('contact.name') }} <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input
          id="contact-name"
          v-model="form.name"
          type="text"
          autocomplete="name"
          required
          :aria-invalid="!!errors.name"
          :aria-describedby="errors.name ? 'error-name' : undefined"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.name ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
          :placeholder="t('contact.name')"
        />
        <p v-if="errors.name" id="error-name" role="alert" class="mt-1.5 text-xs text-red-600">{{ errors.name[0] }}</p>
      </div>

      <div>
        <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1.5">
          {{ t('contact.email') }} <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input
          id="contact-email"
          v-model="form.email"
          type="email"
          autocomplete="email"
          required
          :aria-invalid="!!errors.email"
          :aria-describedby="errors.email ? 'error-email' : undefined"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.email ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
          :placeholder="t('contact.email')"
        />
        <p v-if="errors.email" id="error-email" role="alert" class="mt-1.5 text-xs text-red-600">{{ errors.email[0] }}</p>
      </div>
    </div>

    <!-- Téléphone + Nb personnes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('contact.phone') }}</label>
        <input
          id="contact-phone"
          v-model="form.phone"
          type="tel"
          autocomplete="tel"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.phone ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
          placeholder="06 00 00 00 00"
        />
      </div>

      <div>
        <label for="contact-guests" class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('contact.guests') }}</label>
        <input
          id="contact-guests"
          v-model="form.guests"
          type="number"
          min="1"
          max="20"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.guests ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
          placeholder="4"
        />
      </div>
    </div>

    <!-- Dates -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label for="contact-start" class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('contact.arrival') }}</label>
        <input
          id="contact-start"
          v-model="form.start_date"
          type="date"
          :min="new Date().toISOString().split('T')[0]"
          :aria-invalid="!!errors.start_date"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.start_date ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
        />
      </div>

      <div>
        <label for="contact-end" class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('contact.departure') }}</label>
        <input
          id="contact-end"
          v-model="form.end_date"
          type="date"
          :min="form.start_date || new Date().toISOString().split('T')[0]"
          :aria-invalid="!!errors.end_date"
          :class="[
            'w-full px-4 py-3 rounded-xl border text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors',
            errors.end_date ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
          ]"
        />
      </div>
    </div>

    <!-- Message -->
    <div>
      <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-1.5">
        {{ t('contact.message') }} <span class="text-red-500" aria-hidden="true">*</span>
      </label>
      <textarea
        id="contact-message"
        v-model="form.message"
        rows="5"
        required
        :aria-invalid="!!errors.message"
        :aria-describedby="errors.message ? 'error-message' : undefined"
        :class="[
          'w-full px-4 py-3 rounded-xl border text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors resize-none',
          errors.message ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400',
        ]"
        :placeholder="`Bonjour, je souhaite obtenir des informations sur votre gîte…`"
      ></textarea>
      <p v-if="errors.message" id="error-message" role="alert" class="mt-1.5 text-xs text-red-600">{{ errors.message[0] }}</p>
    </div>

    <!-- RGPD -->
    <p class="text-xs text-gray-500">
      En soumettant ce formulaire, vous acceptez que vos données soient utilisées pour répondre à votre demande.
      Conformément au RGPD, vous disposez d'un droit d'accès et de suppression de vos données.
    </p>

    <!-- Bouton envoi -->
    <button
      type="submit"
      :disabled="loading"
      class="w-full sm:w-auto px-8 py-3.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200 flex items-center justify-center gap-2"
      :aria-busy="loading"
    >
      <svg v-if="loading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      {{ loading ? 'Envoi en cours…' : t('contact.send') }}
    </button>
  </form>
</template>
