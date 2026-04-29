import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/composables/useApi';

export interface Review {
    id: number;
    author: string;
    rating: number;
    comment: string;
    date: string;
    is_active: boolean;
}

export const useReviewsStore = defineStore('reviews', () => {
    const reviews = ref<Review[]>([]);
    const loaded = ref(false);

    async function fetchReviews() {
        if (loaded.value) return;
        const { data } = await api.get('/reviews');
        reviews.value = data;
        loaded.value = true;
    }

    const averageRating = () => {
        if (!reviews.value.length) return 0;
        const sum = reviews.value.reduce((acc, r) => acc + r.rating, 0);
        return Math.round((sum / reviews.value.length) * 10) / 10;
    };

    return { reviews, loaded, fetchReviews, averageRating };
});
