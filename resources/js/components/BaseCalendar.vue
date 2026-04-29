<script setup lang="ts">
import { ref, computed } from 'vue';

const props = defineProps<{
  occupiedDates: string[];
  readonly?: boolean;
  monthOffset?: number;
}>();

const today = new Date();
const initialDate = new Date(today.getFullYear(), today.getMonth() + (props.monthOffset ?? 0), 1);
const currentYear = ref(initialDate.getFullYear());
const currentMonth = ref(initialDate.getMonth());

const monthNames = [
  'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
];

const dayNames = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

// Jours du mois affiché (avec padding pour aligner sur le bon jour de semaine)
const calendarDays = computed(() => {
  const year = currentYear.value;
  const month = currentMonth.value;
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);

  // 0 = dimanche, on décale pour lundi en premier
  let startDayOfWeek = firstDay.getDay();
  startDayOfWeek = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1;

  const days: Array<{ date: Date | null; dateStr: string }> = [];

  // Cellules vides de début
  for (let i = 0; i < startDayOfWeek; i++) {
    days.push({ date: null, dateStr: '' });
  }

  // Jours du mois
  for (let d = 1; d <= lastDay.getDate(); d++) {
    const date = new Date(year, month, d);
    const dateStr = date.toISOString().split('T')[0];
    days.push({ date, dateStr });
  }

  return days;
});

function prevMonth() {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else {
    currentMonth.value--;
  }
}

function nextMonth() {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else {
    currentMonth.value++;
  }
}

function isToday(dateStr: string): boolean {
  return dateStr === today.toISOString().split('T')[0];
}

function isPast(date: Date | null): boolean {
  if (!date) return false;
  const d = new Date(date);
  d.setHours(0, 0, 0, 0);
  const t = new Date();
  t.setHours(0, 0, 0, 0);
  return d < t;
}

function isOccupied(dateStr: string): boolean {
  return props.occupiedDates.includes(dateStr);
}

const canGoPrev = computed(() => {
  return (
    currentYear.value > today.getFullYear() ||
    (currentYear.value === today.getFullYear() && currentMonth.value > today.getMonth())
  );
});
</script>

<template>
  <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
    <!-- En-tête navigation mois -->
    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
      <button
        @click="prevMonth"
        :disabled="!canGoPrev"
        class="p-2 rounded-lg hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
        :aria-label="'Mois précédent'"
      >
        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <h2 class="font-semibold text-gray-900 text-lg" aria-live="polite">
        {{ monthNames[currentMonth] }} {{ currentYear }}
      </h2>

      <button
        @click="nextMonth"
        class="p-2 rounded-lg hover:bg-gray-200 transition-colors"
        :aria-label="'Mois suivant'"
      >
        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>

    <!-- Jours de la semaine -->
    <div class="grid grid-cols-7 border-b border-gray-200">
      <div
        v-for="day in dayNames"
        :key="day"
        class="py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide"
        :aria-label="day"
      >
        {{ day }}
      </div>
    </div>

    <!-- Grille du calendrier -->
    <div class="grid grid-cols-7 p-2 gap-1">
      <div
        v-for="(day, index) in calendarDays"
        :key="index"
        :class="[
          'aspect-square flex items-center justify-center rounded-lg text-sm transition-colors',
          !day.date ? 'cursor-default' : '',
          day.date && isPast(day.date) ? 'text-gray-300 cursor-default' : '',
          day.date && !isPast(day.date) && isOccupied(day.dateStr)
            ? 'bg-red-100 text-red-600 font-medium cursor-not-allowed'
            : '',
          day.date && !isPast(day.date) && !isOccupied(day.dateStr)
            ? 'bg-emerald-100 text-emerald-800 cursor-default'
            : '',
          isToday(day.dateStr) ? 'ring-2 ring-emerald-500 font-semibold' : '',
        ]"
        :aria-label="day.date
          ? `${day.date.getDate()} ${monthNames[currentMonth]} : ${isOccupied(day.dateStr) ? 'occupé' : 'disponible'}`
          : undefined"
        :aria-disabled="isOccupied(day.dateStr) || undefined"
      >
        <span v-if="day.date">{{ day.date.getDate() }}</span>
      </div>
    </div>

    <!-- Légende -->
    <div class="px-6 py-4 border-t border-gray-100 flex flex-wrap gap-4 text-sm">
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded bg-emerald-100 border border-emerald-200"></div>
        <span class="text-gray-600">Disponible</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded bg-red-100 border border-red-200"></div>
        <span class="text-gray-600">Occupé</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded border-2 border-emerald-500"></div>
        <span class="text-gray-600">Aujourd'hui</span>
      </div>
    </div>
  </div>
</template>
