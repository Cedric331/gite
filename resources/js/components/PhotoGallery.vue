<script setup lang="ts">
import { ref, computed } from 'vue';
import type { Photo } from '@/stores/photos';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
  photos: Photo[];
}>();

const activeCategory = ref('all');
const lightboxIndex = ref(-1);

const categories = [
  { key: 'all', label: computed(() => t('gallery.all')) },
  { key: 'exterieur', label: computed(() => t('gallery.exterior')) },
  { key: 'chambre', label: computed(() => t('gallery.bedroom')) },
  { key: 'salon', label: computed(() => t('gallery.living')) },
  { key: 'cuisine', label: computed(() => t('gallery.kitchen')) },
];

const filteredPhotos = computed(() =>
  activeCategory.value === 'all'
    ? props.photos
    : props.photos.filter((p) => p.category === activeCategory.value),
);

function openLightbox(index: number) {
  lightboxIndex.value = index;
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  lightboxIndex.value = -1;
  document.body.style.overflow = '';
}

function prevPhoto() {
  lightboxIndex.value =
    lightboxIndex.value > 0 ? lightboxIndex.value - 1 : filteredPhotos.value.length - 1;
}

function nextPhoto() {
  lightboxIndex.value =
    lightboxIndex.value < filteredPhotos.value.length - 1 ? lightboxIndex.value + 1 : 0;
}

function handleKeydown(e: KeyboardEvent) {
  if (lightboxIndex.value === -1) return;
  if (e.key === 'ArrowLeft') prevPhoto();
  if (e.key === 'ArrowRight') nextPhoto();
  if (e.key === 'Escape') closeLightbox();
}
</script>

<template>
  <div @keydown="handleKeydown" tabindex="-1">
    <!-- Filtres de catégorie -->
    <div class="flex flex-wrap gap-2 mb-8" role="group" aria-label="Filtrer les photos par catégorie">
      <button
        v-for="cat in categories"
        :key="cat.key"
        @click="activeCategory = cat.key"
        :aria-pressed="activeCategory === cat.key"
        :class="[
          'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
          activeCategory === cat.key
            ? 'bg-emerald-600 text-white shadow-sm'
            : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
        ]"
      >
        {{ cat.label.value }}
      </button>
    </div>

    <!-- Grille photos -->
    <div
      v-if="filteredPhotos.length"
      class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3"
      role="list"
      :aria-label="`Galerie : ${filteredPhotos.length} photos`"
    >
      <button
        v-for="(photo, index) in filteredPhotos"
        :key="photo.id"
        @click="openLightbox(index)"
        class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
        role="listitem"
        :aria-label="`Ouvrir la photo : ${photo.alt || 'Photo ' + (index + 1)}`"
      >
        <img
          :src="photo.url"
          :alt="photo.alt || ''"
          loading="lazy"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
          @error="($event.target as HTMLImageElement).src = `https://picsum.photos/seed/${photo.id}/600/400`"
        />
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300 flex items-center justify-center">
          <svg
            class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
          </svg>
        </div>
      </button>
    </div>

    <p v-else class="text-center text-gray-500 py-16">Aucune photo dans cette catégorie.</p>

    <!-- Lightbox -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-200"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="lightboxIndex >= 0"
          class="fixed inset-0 z-[200] bg-black/95 flex items-center justify-center"
          role="dialog"
          :aria-label="`Photo ${lightboxIndex + 1} sur ${filteredPhotos.length}`"
          aria-modal="true"
          @click.self="closeLightbox"
        >
          <!-- Fermer -->
          <button
            @click="closeLightbox"
            class="absolute top-4 right-4 p-2 text-white/70 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded-lg"
            aria-label="Fermer la galerie"
          >
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <!-- Navigation précédent -->
          <button
            @click="prevPhoto"
            class="absolute left-4 top-1/2 -translate-y-1/2 p-3 text-white/70 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded-xl bg-white/10 hover:bg-white/20 transition-colors"
            aria-label="Photo précédente"
          >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          <!-- Image principale -->
          <div class="max-w-5xl max-h-[85vh] px-16">
            <img
              :src="filteredPhotos[lightboxIndex]?.url"
              :alt="filteredPhotos[lightboxIndex]?.alt || ''"
              class="max-w-full max-h-[80vh] object-contain rounded-xl"
              @error="($event.target as HTMLImageElement).src = `https://picsum.photos/seed/${filteredPhotos[lightboxIndex]?.id}/1200/800`"
            />
            <p class="text-center text-white/60 text-sm mt-3">
              {{ filteredPhotos[lightboxIndex]?.alt }} — {{ lightboxIndex + 1 }} / {{ filteredPhotos.length }}
            </p>
          </div>

          <!-- Navigation suivant -->
          <button
            @click="nextPhoto"
            class="absolute right-4 top-1/2 -translate-y-1/2 p-3 text-white/70 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded-xl bg-white/10 hover:bg-white/20 transition-colors"
            aria-label="Photo suivante"
          >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>
