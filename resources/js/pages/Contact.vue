<script setup lang="ts">
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useSettingsStore } from '@/stores/settings';
import ContactForm from '@/components/ContactForm.vue';

const { t } = useI18n();
const settingsStore = useSettingsStore();

onMounted(() => settingsStore.fetchSettings());

const contactItems = [
  {
    icon: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
    label: 'Téléphone',
    valueKey: 'contact_phone',
    href: 'tel:',
    hrefPrefix: 'tel:',
  },
  {
    icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    label: 'Email',
    valueKey: 'contact_email',
    hrefPrefix: 'mailto:',
  },
  {
    icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
    label: 'Adresse',
    valueKey: 'contact_address',
    hrefPrefix: null,
  },
];
</script>

<template>
  <div class="pt-24 pb-12 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="font-serif text-5xl font-bold text-white mb-4">{{ t('contact.title') }}</h1>
      <p class="text-xl text-white/60">{{ t('contact.subtitle') }}</p>
    </div>
  </div>

  <main class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

        <!-- Colonne gauche : infos contact + carte -->
        <aside class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <h2 class="font-serif text-xl font-bold text-gray-900 mb-6">Nos coordonnées</h2>
            <div class="space-y-5">
              <address
                v-for="item in contactItems"
                :key="item.label"
                class="not-italic flex items-start gap-4"
              >
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                  <svg class="w-5 h-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="item.icon" />
                  </svg>
                </div>
                <div>
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ item.label }}</div>
                  <component
                    :is="item.hrefPrefix ? 'a' : 'span'"
                    :href="item.hrefPrefix ? `${item.hrefPrefix}${settingsStore.get(item.valueKey)}` : undefined"
                    class="text-gray-900 hover:text-emerald-600 transition-colors"
                  >
                    {{ settingsStore.get(item.valueKey, '—') }}
                  </component>
                </div>
              </address>
            </div>
          </div>

          <!-- Horaires -->
          <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
            <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Horaires d'accueil
            </h2>
            <dl class="space-y-2 text-sm text-gray-700">
              <div class="flex justify-between">
                <dt>Arrivée</dt>
                <dd class="font-medium">à partir de 16h00</dd>
              </div>
              <div class="flex justify-between">
                <dt>Départ</dt>
                <dd class="font-medium">avant 10h00</dd>
              </div>
              <div class="flex justify-between">
                <dt>Disponibilité téléphonique</dt>
                <dd class="font-medium">9h–19h</dd>
              </div>
            </dl>
          </div>

          <!-- Carte Google Maps (iframe) -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100" aria-label="Carte de localisation du gîte">
            <iframe
              src="https://maps.google.com/maps?q=Périgueux,France&output=embed"
              width="100%"
              height="220"
              style="border:0"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Localisation du Gîte des Chênes"
              class="grayscale hover:grayscale-0 transition-all duration-300"
            ></iframe>
          </div>
        </aside>

        <!-- Colonne droite : formulaire -->
        <div class="lg:col-span-3">
          <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-8">
              Envoyer une demande
            </h2>
            <ContactForm />
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
