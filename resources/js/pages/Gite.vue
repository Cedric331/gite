<script setup lang="ts">
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import { useSettingsStore } from '@/stores/settings';
import { usePhotosStore } from '@/stores/photos';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const settingsStore = useSettingsStore();
const photosStore = usePhotosStore();

onMounted(() => Promise.all([settingsStore.fetchSettings(), photosStore.fetchPhotos()]));

const equipments = [
  { cat: 'Cuisine', items: ['Cuisine équipée', 'Lave-vaisselle', 'Réfrigérateur', 'Congélateur', 'Four', 'Micro-ondes', 'Machine à café', 'Barbecue'] },
  { cat: 'Séjour', items: ['Salon confortable', 'Télévision HD', 'Lecteur DVD', 'Wi-Fi haut débit', 'Cheminée', 'Bureau de travail'] },
  { cat: 'Chambres & Salles de bain', items: ['4 chambres', '2 salles de bain', 'Linge de lit fourni', 'Sèche-cheveux', 'Fer à repasser', 'Dressing'] },
  { cat: 'Extérieur & Loisirs', items: ['Grand jardin', 'Terrasse couverte', 'Piscine privée', 'Transats & mobilier', 'Parking privatif', 'Espace jeux enfants'] },
];

const rules = [
  'Arrivée entre 16h et 19h, départ avant 10h',
  'Non-fumeur à l\'intérieur du gîte',
  'Animaux de compagnie acceptés (supplément 20€)',
  'Fêtes et soirées bruyantes interdites après 22h',
  'Le gîte est loué pour un maximum de 8 personnes',
  'Caution de 300€ encaissée à l\'arrivée',
];
</script>

<template>
  <!-- En-tête -->
  <div class="relative pt-24 pb-16 bg-gradient-to-b from-gray-900 to-gray-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
      <img
        v-if="photosStore.mainPhoto()?.url"
        :src="photosStore.mainPhoto()?.url"
        alt=""
        class="w-full h-full object-cover"
        aria-hidden="true"
        @error="($event.target as HTMLImageElement).src = 'https://picsum.photos/seed/gite-bg/1920/400'"
      />
    </div>
    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('gite.title') }}</h1>
      <p class="text-xl text-white/60">Votre maison de vacances idéale</p>
    </div>
  </div>

  <main class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 max-w-5xl">

      <!-- Description + Stats -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-20" aria-labelledby="description-title">
        <div class="lg:col-span-2">
          <h2 id="description-title" class="font-serif text-3xl font-bold text-gray-900 mb-6">Notre gîte</h2>
          <div class="prose prose-lg prose-gray max-w-none">
            <p class="text-gray-600 leading-relaxed text-lg">
              {{ settingsStore.get('gite_description', 'Notre gîte de charme peut accueillir jusqu\'à 8 personnes dans un cadre naturel exceptionnel. La maison dispose de tout le confort moderne tout en conservant le charme de l\'architecture traditionnelle.') }}
            </p>
            <p class="text-gray-600 leading-relaxed mt-4">
              Idéalement situé au cœur de la Dordogne, à deux pas des plus beaux sites de la région, le Gîte des Chênes est votre point de départ idéal pour explorer le Périgord. La terrasse avec vue sur la forêt, la piscine privée et le grand jardin feront de votre séjour un moment inoubliable.
            </p>
          </div>
        </div>

        <!-- Stats -->
        <div class="flex flex-col gap-4">
          <div
            v-for="stat in [
              { label: 'Capacité', value: settingsStore.get('gite_capacity', '8'), unit: t('gite.capacity'), icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z' },
              { label: 'Surface', value: settingsStore.get('gite_surface', '120'), unit: t('gite.surface'), icon: 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4' },
              { label: 'Chambres', value: settingsStore.get('gite_bedrooms', '4'), unit: t('gite.bedrooms'), icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
              { label: 'Salles de bain', value: settingsStore.get('gite_bathrooms', '2'), unit: t('gite.bathrooms'), icon: 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z' },
            ]"
            :key="stat.label"
            class="flex items-center gap-4 p-5 bg-gray-50 rounded-2xl"
          >
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
              <svg class="w-6 h-6 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="stat.icon" />
              </svg>
            </div>
            <div>
              <div class="text-2xl font-bold text-gray-900">{{ stat.value }}</div>
              <div class="text-sm text-gray-500">{{ stat.unit }}</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Galerie rapide -->
      <section class="mb-20 grid grid-cols-2 md:grid-cols-4 gap-3" aria-label="Photos du gîte">
        <div
          v-for="(photo, i) in photosStore.photos.slice(0, 8)"
          :key="photo.id"
          :class="['rounded-xl overflow-hidden', i === 0 ? 'col-span-2 row-span-2 aspect-square' : 'aspect-square']"
        >
          <img
            :src="photo.url"
            :alt="photo.alt || ''"
            loading="lazy"
            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
            @error="($event.target as HTMLImageElement).src = `https://picsum.photos/seed/${photo.id + 20}/600/400`"
          />
        </div>
      </section>
      <div class="text-center mb-20">
        <RouterLink to="/galerie" class="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:underline">
          Voir toutes les photos
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </RouterLink>
      </div>

      <!-- Équipements -->
      <section class="mb-20" aria-labelledby="equipment-title">
        <h2 id="equipment-title" class="font-serif text-3xl font-bold text-gray-900 mb-10 text-center">
          {{ t('gite.equipment_title') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div
            v-for="cat in equipments"
            :key="cat.cat"
            class="p-6 bg-gray-50 rounded-2xl"
          >
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
              <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
              {{ cat.cat }}
            </h3>
            <ul class="grid grid-cols-2 gap-2" role="list">
              <li
                v-for="item in cat.items"
                :key="item"
                class="flex items-center gap-2 text-sm text-gray-600"
              >
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ item }}
              </li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Règlement intérieur -->
      <section class="mb-16 p-8 bg-amber-50 border border-amber-100 rounded-2xl" aria-labelledby="rules-title">
        <h2 id="rules-title" class="font-serif text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
          <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          {{ t('gite.rules_title') }}
        </h2>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3" role="list">
          <li
            v-for="rule in rules"
            :key="rule"
            class="flex items-start gap-3 text-gray-700"
          >
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ rule }}
          </li>
        </ul>
      </section>

      <!-- CTA -->
      <div class="text-center">
        <RouterLink
          to="/contact"
          class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm"
        >
          Réserver ce gîte
        </RouterLink>
        <RouterLink
          to="/tarifs"
          class="inline-flex items-center gap-2 px-8 py-4 text-emerald-700 font-semibold hover:underline ml-4"
        >
          Voir les tarifs →
        </RouterLink>
      </div>

    </div>
  </main>
</template>
