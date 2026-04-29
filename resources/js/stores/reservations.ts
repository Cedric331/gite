import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/composables/useApi';

export const useReservationsStore = defineStore('reservations', () => {
    const occupiedDates = ref<string[]>([]);
    const loaded = ref(false);

    async function fetchOccupiedDates() {
        if (loaded.value) return;
        const { data } = await api.get('/reservations/occupied-dates');
        occupiedDates.value = data;
        loaded.value = true;
    }

    function isOccupied(date: string): boolean {
        return occupiedDates.value.includes(date);
    }

    return { occupiedDates, loaded, fetchOccupiedDates, isOccupied };
});
