<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink, RouterView, useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';

const { t, locale } = useI18n();
const route = useRoute();

const isMenuOpen = ref(false);
const isScrolled = ref(false);
const languages = [
  { code: 'fr', label: 'FR', flag: '🇫🇷' },
  { code: 'en', label: 'EN', flag: '🇬🇧' },
  { code: 'es', label: 'ES', flag: '🇪🇸' },
];

function setLocale(lang: string) {
  locale.value = lang;
  localStorage.setItem('locale', lang);
}

function handleScroll() {
  isScrolled.value = window.scrollY > 20;
}

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));

const navLinks = [
  { name: 'home', to: '/', label: 'nav.home' },
  { name: 'gite', to: '/le-gite', label: 'nav.gite' },
  { name: 'galerie', to: '/galerie', label: 'nav.gallery' },
  { name: 'tarifs', to: '/tarifs', label: 'nav.rates' },
  { name: 'disponibilites', to: '/disponibilites', label: 'nav.availability' },
  { name: 'activites', to: '/activites', label: 'nav.activities' },
  { name: 'contact', to: '/contact', label: 'nav.contact' },
];
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navigation -->
    <header
      :class="[
        'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
        isScrolled
          ? 'bg-white/95 backdrop-blur-sm shadow-md py-3'
          : 'bg-transparent py-5',
      ]"
      role="banner"
    >
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <!-- Logo / Nom du gîte -->
          <RouterLink
            to="/"
            class="flex items-center gap-3 group"
            :aria-label="'Retour à l\'accueil'"
          >
            <div
              :class="[
                'w-10 h-10 rounded-full flex items-center justify-center transition-colors',
                isScrolled ? 'bg-emerald-600' : 'bg-white/20 backdrop-blur-sm',
              ]"
            >
              <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
            </div>
            <span
              :class="[
                'font-serif text-xl font-semibold transition-colors',
                isScrolled ? 'text-gray-900' : 'text-white',
              ]"
            >
             (DEMO) Gîte des Chênes
            </span>
          </RouterLink>

          <!-- Navigation desktop -->
          <nav class="hidden lg:flex items-center gap-1" aria-label="Navigation principale">
            <RouterLink
              v-for="link in navLinks"
              :key="link.name"
              :to="link.to"
              :class="[
                'px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200',
                isScrolled
                  ? 'text-gray-700 hover:text-emerald-600 hover:bg-emerald-50'
                  : 'text-white/90 hover:text-white hover:bg-white/10',
                route.path === link.to
                  ? (isScrolled ? 'text-emerald-600 bg-emerald-50' : 'text-white bg-white/20')
                  : '',
              ]"
            >
              {{ t(link.label) }}
            </RouterLink>
          </nav>

          <!-- Sélecteur de langue + CTA -->
          <div class="hidden lg:flex items-center gap-3">
            <div class="flex items-center gap-1">
              <button
                v-for="lang in languages"
                :key="lang.code"
                @click="setLocale(lang.code)"
                :aria-label="`Langue : ${lang.label}`"
                :aria-pressed="locale === lang.code"
                :class="[
                  'px-2 py-1 rounded text-xs font-semibold transition-all',
                  locale === lang.code
                    ? (isScrolled ? 'bg-emerald-600 text-white' : 'bg-white text-emerald-600')
                    : (isScrolled ? 'text-gray-500 hover:text-gray-700' : 'text-white/70 hover:text-white'),
                ]"
              >
                {{ lang.flag }} {{ lang.label }}
              </button>
            </div>
            <RouterLink
              to="/contact"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200',
                isScrolled
                  ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm'
                  : 'bg-white text-emerald-700 hover:bg-white/90 shadow-md',
              ]"
            >
              {{ t('home.hero_cta') }}
            </RouterLink>
          </div>

          <!-- Bouton menu mobile -->
          <button
            class="lg:hidden p-2 rounded-lg"
            :class="isScrolled ? 'text-gray-700' : 'text-white'"
            @click="isMenuOpen = !isMenuOpen"
            :aria-label="isMenuOpen ? 'Fermer le menu' : 'Ouvrir le menu'"
            :aria-expanded="isMenuOpen"
            aria-controls="mobile-menu"
          >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Menu mobile -->
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-2"
        >
          <div
            v-if="isMenuOpen"
            id="mobile-menu"
            class="lg:hidden mt-4 py-4 px-4 bg-white rounded-2xl shadow-xl border border-gray-100"
          >
            <nav class="flex flex-col gap-1" aria-label="Navigation mobile">
              <RouterLink
                v-for="link in navLinks"
                :key="link.name"
                :to="link.to"
                @click="isMenuOpen = false"
                class="px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors"
                :class="route.path === link.to ? 'text-emerald-600 bg-emerald-50' : ''"
              >
                {{ t(link.label) }}
              </RouterLink>
            </nav>
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
              <div class="flex gap-2">
                <button
                  v-for="lang in languages"
                  :key="lang.code"
                  @click="setLocale(lang.code)"
                  :aria-pressed="locale === lang.code"
                  :class="[
                    'px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors',
                    locale === lang.code ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:text-gray-700 bg-gray-50',
                  ]"
                >
                  {{ lang.flag }} {{ lang.label }}
                </button>
              </div>
              <RouterLink
                to="/contact"
                @click="isMenuOpen = false"
                class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition-colors"
              >
                Réserver
              </RouterLink>
            </div>
          </div>
        </Transition>
      </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-1" id="main-content">
      <RouterView />
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-900 text-gray-300" role="contentinfo">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Branding -->
          <div>
            <h2 class="font-serif text-xl font-semibold text-white mb-3">Gîte des Chênes</h2>
            <p class="text-sm leading-relaxed text-gray-400">
              Votre havre de paix en pleine nature. Profitez d'un séjour authentique et ressourçant en Dordogne.
            </p>
          </div>

          <!-- Navigation -->
          <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigation</h3>
            <nav class="flex flex-col gap-2" aria-label="Navigation pied de page">
              <RouterLink
                v-for="link in navLinks"
                :key="link.name"
                :to="link.to"
                class="text-sm text-gray-400 hover:text-white transition-colors"
              >
                {{ t(link.label) }}
              </RouterLink>
            </nav>
          </div>

          <!-- Contact -->
          <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h3>
            <address class="not-italic flex flex-col gap-2 text-sm text-gray-400">
              <a href="tel:+33612345678" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                06 12 34 56 78
              </a>
              <a href="mailto:contact@gite-des-chenes.fr" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                contact@gite-des-chenes.fr
              </a>
              <span class="flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                123 Chemin des Chênes<br>24000 Périgueux
              </span>
            </address>
          </div>
        </div>

        <div class="mt-10 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500">
          <p>© {{ new Date().getFullYear() }} Gîte des Chênes. {{ t('footer.rights') }}.</p>
          <nav class="flex gap-4" aria-label="Liens légaux">
            <RouterLink to="/mentions-legales" class="hover:text-white transition-colors">{{ t('footer.legal') }}</RouterLink>
            <RouterLink to="/cgv" class="hover:text-white transition-colors">{{ t('footer.cgv') }}</RouterLink>
          </nav>
        </div>
      </div>
    </footer>

    <!-- Lien d'évitement pour l'accessibilité -->
    <a
      href="#main-content"
      class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-emerald-600 text-white px-4 py-2 rounded-lg z-[100]"
    >
      Aller au contenu principal
    </a>
  </div>
</template>
