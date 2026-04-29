<script setup lang="ts">
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useReservationsStore } from '@/stores/reservations';
import BaseCalendar from '@/components/BaseCalendar.vue';

const { t } = useI18n();
const reservationsStore = useReservationsStore();

onMounted(() => reservationsStore.fetchOccupiedDates());
</script>

<template>
  <div class="pt-24 pb-12 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('availability.title') }}</h1>
      <p class="text-xl text-white/60">{{ t('availability.subtitle') }}</p>
    </div>
  </div>

  <main class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

      <!-- Skeleton -->
      <div v-if="!reservationsStore.loaded" class="max-w-lg mx-auto">
        <div class="h-96 rounded-2xl bg-gray-200 animate-pulse mb-8"></div>
        <div class="h-96 rounded-2xl bg-gray-200 animate-pulse"></div>
      </div>

      <template v-else>
        <!-- Calendrier des disponibilités -->
        <div class="max-w-lg mx-auto mb-12">
          <BaseCalendar
            :occupied-dates="reservationsStore.occupiedDates"
            :readonly="true"
          />
        </div>

        <!-- CTA réservation -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-8 text-center">
          <h2 class="font-serif text-2xl font-bold text-gray-900 mb-3">
            Une date vous convient ?
          </h2>
          <p class="text-gray-600 mb-6">
            Contactez-nous pour vérifier les disponibilités et obtenir un devis personnalisé.
          </p>
          <RouterLink
            to="/contact"
            class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Envoyer une demande
          </RouterLink>
        </div>
      </template>
    </div>
  </main>
</template>
