<script setup lang="ts">
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const activities = [
  {
    category: 'Nature & Randonnée',
    icon: '🌲',
    color: 'emerald',
    items: [
      { name: 'Forêt de la Bessède', distance: '2 km', detail: 'Sentiers balisés, faune sauvage' },
      { name: 'Gorges de la Vézère', distance: '8 km', detail: 'Randonnées, escalade, kayak' },
      { name: 'Lac de Gurson', distance: '15 km', detail: 'Baignade, pêche, pique-nique' },
    ],
  },
  {
    category: 'Culture & Patrimoine',
    icon: '🏰',
    color: 'amber',
    items: [
      { name: 'Château de Beynac', distance: '12 km', detail: 'Monument historique classé' },
      { name: 'Grotte de Lascaux', distance: '25 km', detail: 'Art pariétal préhistorique' },
      { name: 'Périgueux (centre-ville)', distance: '15 km', detail: 'Marché, cathédrale, musées' },
    ],
  },
  {
    category: 'Gastronomie',
    icon: '🍴',
    color: 'red',
    items: [
      { name: 'Marché de Périgueux', distance: '15 km', detail: 'Mercredi et samedi matin' },
      { name: 'Ferme foie gras Bertrand', distance: '5 km', detail: 'Visite et dégustation' },
      { name: 'Restaurant La Terrasse', distance: '3 km', detail: 'Cuisine périgourdine' },
    ],
  },
  {
    category: 'Activités & Loisirs',
    icon: '🎯',
    color: 'violet',
    items: [
      { name: 'Canoe-kayak Périgord', distance: '8 km', detail: 'Descentes de rivière guidées' },
      { name: 'Parc accrobranche', distance: '10 km', detail: 'Tyroliennes, via ferrata' },
      { name: 'Golf de Périgueux', distance: '18 km', detail: '18 trous, école de golf' },
    ],
  },
];

const colorClasses: Record<string, { bg: string; text: string; badge: string }> = {
  emerald: { bg: 'bg-emerald-50', text: 'text-emerald-700', badge: 'bg-emerald-100 text-emerald-800' },
  amber: { bg: 'bg-amber-50', text: 'text-amber-700', badge: 'bg-amber-100 text-amber-800' },
  red: { bg: 'bg-red-50', text: 'text-red-700', badge: 'bg-red-100 text-red-800' },
  violet: { bg: 'bg-violet-50', text: 'text-violet-700', badge: 'bg-violet-100 text-violet-800' },
};
</script>

<template>
  <div class="pt-24 pb-12 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('activities.title') }}</h1>
      <p class="text-xl text-white/60">{{ t('activities.subtitle') }}</p>
    </div>
  </div>

  <main class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

      <!-- Introduction -->
      <div class="text-center mb-16">
        <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Le Gîte des Chênes est idéalement situé pour explorer les richesses de la Dordogne.
          À quelques kilomètres, vous découvrirez des paysages époustouflants, des monuments historiques
          remarquables et une gastronomie d'exception.
        </p>
      </div>

      <!-- Grille d'activités -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <section
          v-for="cat in activities"
          :key="cat.category"
          :aria-labelledby="`activity-${cat.category}`"
          class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100"
        >
          <div :class="['px-6 py-5', colorClasses[cat.color].bg]">
            <h2
              :id="`activity-${cat.category}`"
              :class="['font-serif text-xl font-semibold flex items-center gap-3', colorClasses[cat.color].text]"
            >
              <span role="img" :aria-label="cat.category">{{ cat.icon }}</span>
              {{ cat.category }}
            </h2>
          </div>
          <ul class="divide-y divide-gray-50" role="list">
            <li
              v-for="item in cat.items"
              :key="item.name"
              class="px-6 py-4 flex items-start justify-between gap-4 hover:bg-gray-50 transition-colors"
            >
              <div>
                <div class="font-medium text-gray-900">{{ item.name }}</div>
                <div class="text-sm text-gray-500 mt-0.5">{{ item.detail }}</div>
              </div>
              <span
                :class="['shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full', colorClasses[cat.color].badge]"
              >
                {{ item.distance }}
              </span>
            </li>
          </ul>
        </section>
      </div>

      <!-- Note carte -->
      <div class="mt-12 p-6 bg-blue-50 border border-blue-100 rounded-2xl text-center">
        <p class="text-gray-700">
          📍 <strong>Localisation :</strong> 123 Chemin des Chênes, 24000 Périgueux (Dordogne, France)
        </p>
        <p class="text-sm text-gray-500 mt-2">
          À 1h30 de Bordeaux, 2h30 de Toulouse et 5h30 de Paris en voiture
        </p>
      </div>
    </div>
  </main>
</template>
