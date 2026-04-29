<script setup lang="ts">
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useSeasonsStore } from '@/stores/seasons';

const { t } = useI18n();
const seasonsStore = useSeasonsStore();

onMounted(() => seasonsStore.fetchSeasons());

const options = [
  { label: 'Linge de lit', price: '30', detail: 'Par personne' },
  { label: 'Ménage de fin de séjour', price: '80', detail: 'Forfait unique' },
  { label: 'Taxe de séjour', price: '1', detail: 'Par personne / nuit' },
  { label: 'Animaux acceptés', price: '20', detail: 'Par séjour' },
];
</script>

<template>
  <div class="pt-24 pb-12 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('rates.title') }}</h1>
      <p class="text-xl text-white/60">{{ t('rates.subtitle') }}</p>
    </div>
  </div>

  <main class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

      <!-- Saisons et tarifs -->
      <section aria-labelledby="seasons-title">
        <h2 id="seasons-title" class="font-serif text-3xl font-bold text-gray-900 mb-8 text-center">
          Tarifs par saison
        </h2>

        <!-- Skeleton -->
        <div v-if="!seasonsStore.loaded" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
          <div v-for="i in 3" :key="i" class="h-56 rounded-2xl bg-gray-200 animate-pulse"></div>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
          <article
            v-for="(season, index) in seasonsStore.seasons"
            :key="season.id"
            :class="[
              'relative rounded-2xl p-8 text-center overflow-hidden transition-transform hover:-translate-y-1',
              index === 2
                ? 'bg-emerald-700 text-white shadow-xl shadow-emerald-200 scale-105'
                : 'bg-white border-2 border-gray-100 shadow-sm',
            ]"
            :aria-labelledby="`season-${season.id}-name`"
          >
            <div
              v-if="index === 2"
              class="absolute top-4 right-4 px-3 py-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded-full"
              aria-label="Recommandé"
            >
              ★ Populaire
            </div>

            <h3
              :id="`season-${season.id}-name`"
              :class="['font-serif text-xl font-semibold mb-2', index === 2 ? 'text-white' : 'text-gray-900']"
            >
              {{ season.name }}
            </h3>

            <p :class="['text-sm mb-6', index === 2 ? 'text-emerald-200' : 'text-gray-500']">
              {{
                new Date(season.start_date).toLocaleDateString('fr-FR', { month: 'short', day: 'numeric' })
              }} –
              {{
                new Date(season.end_date).toLocaleDateString('fr-FR', { month: 'short', day: 'numeric' })
              }}
            </p>

            <div class="mb-4">
              <div :class="['text-5xl font-bold mb-1', index === 2 ? 'text-white' : 'text-emerald-700']">
                {{ Number(season.price_per_night).toFixed(0) }}€
              </div>
              <div :class="['text-sm', index === 2 ? 'text-emerald-200' : 'text-gray-500']">
                {{ t('rates.per_night') }}
              </div>
            </div>

            <div
              :class="[
                'py-3 px-4 rounded-xl mb-6',
                index === 2 ? 'bg-white/10' : 'bg-gray-50',
              ]"
            >
              <div :class="['text-2xl font-bold', index === 2 ? 'text-white' : 'text-gray-900']">
                {{ Number(season.price_per_week).toFixed(0) }}€
              </div>
              <div :class="['text-xs', index === 2 ? 'text-emerald-200' : 'text-gray-500']">
                {{ t('rates.per_week') }}
              </div>
            </div>

            <RouterLink
              to="/contact"
              :class="[
                'block w-full py-3 px-6 rounded-xl font-semibold text-sm transition-all duration-200',
                index === 2
                  ? 'bg-white text-emerald-700 hover:bg-emerald-50'
                  : 'bg-emerald-600 text-white hover:bg-emerald-700',
              ]"
            >
              {{ t('rates.book_cta') }}
            </RouterLink>
          </article>
        </div>
      </section>

      <!-- Options et suppléments -->
      <section aria-labelledby="options-title">
        <h2 id="options-title" class="font-serif text-3xl font-bold text-gray-900 mb-8 text-center">
          {{ t('rates.options_title') }}
        </h2>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <table class="w-full" aria-label="Tableau des options et suppléments">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-700" scope="col">Option</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-gray-700" scope="col">Tarif</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-gray-700" scope="col">Détail</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr
                v-for="option in options"
                :key="option.label"
                class="hover:bg-gray-50 transition-colors"
              >
                <td class="px-6 py-4 text-gray-900">{{ option.label }}</td>
                <td class="px-6 py-4 text-right font-semibold text-emerald-700">{{ option.price }}€</td>
                <td class="px-6 py-4 text-right text-gray-500 text-sm">{{ option.detail }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Note -->
        <p class="mt-6 text-sm text-gray-500 text-center">
          Tarifs TTC · Caution de 300€ demandée à l'arrivée · Animaux de compagnie acceptés sous conditions
        </p>
      </section>
    </div>
  </main>
</template>
