<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { RouterLink } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useSettingsStore } from '@/stores/settings';
import { useReviewsStore } from '@/stores/reviews';
import { usePhotosStore } from '@/stores/photos';
import RatingStars from '@/components/RatingStars.vue';

const { t } = useI18n();
const settingsStore = useSettingsStore();
const reviewsStore = useReviewsStore();
const photosStore = usePhotosStore();

onMounted(async () => {
  await Promise.all([
    settingsStore.fetchSettings(),
    reviewsStore.fetchReviews(),
    photosStore.fetchPhotos(),
  ]);
});

const heroPhoto = computed(() => photosStore.mainPhoto());

const features = [
  {
    icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    titleKey: 'home.feature_comfort',
    descKey: 'home.feature_comfort_desc',
    color: 'emerald',
  },
  {
    icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
    titleKey: 'home.feature_nature',
    descKey: 'home.feature_nature_desc',
    color: 'green',
  },
  {
    icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
    titleKey: 'home.feature_calm',
    descKey: 'home.feature_calm_desc',
    color: 'sky',
  },
  {
    icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
    titleKey: 'home.feature_family',
    descKey: 'home.feature_family_desc',
    color: 'violet',
  },
];

const colorMap: Record<string, string> = {
  emerald: 'bg-emerald-100 text-emerald-700',
  green: 'bg-green-100 text-green-700',
  sky: 'bg-sky-100 text-sky-700',
  violet: 'bg-violet-100 text-violet-700',
};
</script>

<template>
  <!-- HERO -->
  <section
    class="relative min-h-screen flex items-center"
    aria-labelledby="hero-title"
  >
    <!-- Image de fond -->
    <div class="absolute inset-0 z-0">
      <img
        v-if="heroPhoto?.url"
        :src="heroPhoto.url"
        :alt="heroPhoto.alt || 'Vue du gîte'"
        class="w-full h-full object-cover"
        @error="($event.target as HTMLImageElement).src = 'https://picsum.photos/seed/gite-hero/1920/1080'"
      />
      <div
        v-else
        class="w-full h-full bg-gradient-to-br from-emerald-900 via-emerald-800 to-green-900"
      ></div>
      <!-- Overlay dégradé -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
    </div>

    <!-- Contenu hero -->
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 pt-24">
      <div class="max-w-3xl">
        <span class="inline-block px-4 py-1.5 bg-emerald-500/30 backdrop-blur-sm text-emerald-200 text-sm font-medium rounded-full mb-6 border border-emerald-400/30">
          Dordogne, France
        </span>
        <h1
          id="hero-title"
          class="font-serif text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6"
        >
          {{ settingsStore.get('hero_title', 'Bienvenue au Gîte des Chênes') }}
        </h1>
        <p class="text-xl text-white/80 leading-relaxed mb-10 max-w-2xl">
          {{ settingsStore.get('hero_subtitle', 'Découvrez un séjour exceptionnel au cœur de la nature.') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <RouterLink
            to="/contact"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-500 transition-all duration-200 shadow-lg hover:shadow-emerald-500/25 hover:-translate-y-0.5"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ t('home.hero_cta') }}
          </RouterLink>
          <RouterLink
            to="/le-gite"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/15 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/25 transition-all duration-200 border border-white/30"
          >
            {{ t('home.hero_cta_discover') }}
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </div>

        <!-- Indicateurs clés -->
        <div class="mt-16 grid grid-cols-3 gap-6 max-w-sm">
          <div class="text-center">
            <div class="text-3xl font-bold text-white">8</div>
            <div class="text-white/60 text-xs mt-1">Personnes max</div>
          </div>
          <div class="text-center border-x border-white/20">
            <div class="text-3xl font-bold text-white">4</div>
            <div class="text-white/60 text-xs mt-1">Chambres</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-white">★ 5</div>
            <div class="text-white/60 text-xs mt-1">Note clients</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Indicateur scroll -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce" aria-hidden="true">
      <svg class="w-6 h-6 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>
  </section>

  <!-- SECTION POINTS FORTS -->
  <section class="py-24 bg-white" aria-labelledby="features-title">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 id="features-title" class="font-serif text-4xl font-bold text-gray-900 mb-4">
          {{ t('home.features_title') }}
        </h2>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
          Tout ce dont vous avez besoin pour un séjour parfait
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div
          v-for="feature in features"
          :key="feature.titleKey"
          class="group text-center p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
        >
          <div
            :class="[
              'w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 transition-transform group-hover:scale-110',
              colorMap[feature.color],
            ]"
          >
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="feature.icon" />
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 text-lg mb-3">{{ t(feature.titleKey) }}</h3>
          <p class="text-gray-500 leading-relaxed">{{ t(feature.descKey) }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION PRÉSENTATION -->
  <section class="py-24 bg-gray-50" aria-labelledby="about-title">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Photos -->
        <div class="grid grid-cols-2 gap-4">
          <div
            v-for="(photo, i) in photosStore.photos.slice(0, 4)"
            :key="photo.id"
            :class="['rounded-2xl overflow-hidden', i === 0 ? 'col-span-2 aspect-video' : 'aspect-square']"
          >
            <img
              :src="photo.url"
              :alt="photo.alt || ''"
              loading="lazy"
              class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
              @error="($event.target as HTMLImageElement).src = `https://picsum.photos/seed/${photo.id + 10}/800/600`"
            />
          </div>
        </div>

        <!-- Texte -->
        <div>
          <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wider">Notre gîte</span>
          <h2 id="about-title" class="font-serif text-4xl font-bold text-gray-900 mt-3 mb-6">
            {{ settingsStore.get('site_name', 'Le Gîte des Chênes') }}
          </h2>
          <p class="text-gray-600 text-lg leading-relaxed mb-8">
            {{ settingsStore.get('site_description', 'Niché au cœur de la forêt, notre gîte vous accueille pour des séjours inoubliables.') }}
          </p>

          <!-- Caractéristiques -->
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div
              v-for="item in [
                { label: 'Capacité', value: `${settingsStore.get('gite_capacity', '8')} pers.` },
                { label: 'Surface', value: `${settingsStore.get('gite_surface', '120')} m²` },
                { label: 'Chambres', value: settingsStore.get('gite_bedrooms', '4') },
                { label: 'Salles de bain', value: settingsStore.get('gite_bathrooms', '2') },
              ]"
              :key="item.label"
              class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100"
            >
              <div class="w-2 h-2 bg-emerald-500 rounded-full shrink-0"></div>
              <div>
                <div class="text-xs text-gray-500">{{ item.label }}</div>
                <div class="font-semibold text-gray-900">{{ item.value }}</div>
              </div>
            </div>
          </div>

          <RouterLink
            to="/le-gite"
            class="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:gap-4 transition-all duration-200"
          >
            En savoir plus sur le gîte
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION AVIS CLIENTS -->
  <section
    v-if="reviewsStore.reviews.length"
    class="py-24 bg-emerald-900"
    aria-labelledby="reviews-title"
  >
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 id="reviews-title" class="font-serif text-4xl font-bold text-white mb-4">
          {{ t('home.reviews_title') }}
        </h2>
        <div class="flex items-center justify-center gap-2">
          <RatingStars :rating="Math.round(reviewsStore.averageRating())" size="lg" />
          <span class="text-white/80 text-lg">{{ reviewsStore.averageRating() }}/5</span>
          <span class="text-white/50 text-sm">({{ reviewsStore.reviews.length }} avis)</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <article
          v-for="review in reviewsStore.reviews.slice(0, 3)"
          :key="review.id"
          class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/10"
        >
          <RatingStars :rating="review.rating" class="mb-4" />
          <blockquote class="text-white/80 leading-relaxed mb-6 italic">
            "{{ review.comment }}"
          </blockquote>
          <footer class="flex items-center justify-between">
            <cite class="text-emerald-300 font-semibold not-italic">{{ review.author }}</cite>
            <time
              :datetime="review.date"
              class="text-white/40 text-sm"
            >
              {{ new Date(review.date).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }) }}
            </time>
          </footer>
        </article>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="py-24 bg-white" aria-labelledby="cta-title">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="max-w-2xl mx-auto">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-8">
          <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <h2 id="cta-title" class="font-serif text-4xl font-bold text-gray-900 mb-6">
          {{ t('home.cta_title') }}
        </h2>
        <p class="text-lg text-gray-500 mb-10">{{ t('home.cta_desc') }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <RouterLink
            to="/disponibilites"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all duration-200 shadow-sm"
          >
            {{ t('home.cta_button') }}
          </RouterLink>
          <RouterLink
            to="/tarifs"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-emerald-300 hover:text-emerald-700 transition-all duration-200"
          >
            Voir les tarifs
          </RouterLink>
        </div>
      </div>
    </div>
  </section>
</template>
