<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
      <div class="text-8xl font-bold text-emerald-200 mb-6" aria-hidden="true">404</div>
      <h1 class="font-serif text-3xl font-bold text-gray-900 mb-4">Page introuvable</h1>
      <p class="text-gray-500 mb-8 leading-relaxed">
        La page que vous recherchez n'existe pas ou a été déplacée.
        Retournez à l'accueil pour continuer votre visite.
      </p>
      <RouterLink
        to="/"
        class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors"
      >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Retour à l'accueil
      </RouterLink>
    </div>
  </div>
</template>
