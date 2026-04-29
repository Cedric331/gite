import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/composables/useApi';

export interface Photo {
    id: number;
    filename: string;
    alt: string;
    category: string;
    order: number;
    is_main: boolean;
    url: string;
}

export const usePhotosStore = defineStore('photos', () => {
    const photos = ref<Photo[]>([]);
    const loaded = ref(false);

    async function fetchPhotos(category?: string) {
        const params = category && category !== 'all' ? { category } : {};
        const { data } = await api.get('/photos', { params });
        photos.value = data;
        loaded.value = true;
    }

    const mainPhoto = () => photos.value.find((p) => p.is_main) ?? photos.value[0];

    return { photos, loaded, fetchPhotos, mainPhoto };
});
