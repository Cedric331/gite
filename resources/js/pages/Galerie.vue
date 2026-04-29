<script setup lang="ts">
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePhotosStore } from '@/stores/photos';
import PhotoGallery from '@/components/PhotoGallery.vue';

const { t } = useI18n();
const photosStore = usePhotosStore();

onMounted(() => photosStore.fetchPhotos());
</script>

<template>
  <!-- En-tête page -->
  <div class="pt-24 pb-12 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('gallery.title') }}</h1>
      <p class="text-xl text-white/60">{{ t('gallery.subtitle') }}</p>
    </div>
  </div>

  <main class="py-16 bg-gray-50" id="gallery-content">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Skeleton loader -->
      <div v-if="!photosStore.loaded" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <div
          v-for="i in 12"
          :key="i"
          class="aspect-square rounded-xl bg-gray-200 animate-pulse"
        ></div>
      </div>

      <PhotoGallery v-else :photos="photosStore.photos" />
    </div>
  </main>
</template>
