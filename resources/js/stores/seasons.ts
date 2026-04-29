import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/composables/useApi';

export interface Season {
    id: number;
    name: string;
    slug: string;
    start_date: string;
    end_date: string;
    price_per_night: string;
    price_per_week: string;
    color: string;
}

export const useSeasonsStore = defineStore('seasons', () => {
    const seasons = ref<Season[]>([]);
    const loaded = ref(false);

    async function fetchSeasons() {
        if (loaded.value) return;
        const { data } = await api.get('/seasons');
        seasons.value = data;
        loaded.value = true;
    }

    return { seasons, loaded, fetchSeasons };
});
