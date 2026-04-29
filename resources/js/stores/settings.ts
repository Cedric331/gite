import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/composables/useApi';

export const useSettingsStore = defineStore('settings', () => {
    const settings = ref<Record<string, string>>({});
    const loaded = ref(false);

    async function fetchSettings() {
        if (loaded.value) return;
        const { data } = await api.get('/settings');
        settings.value = data;
        loaded.value = true;
    }

    function get(key: string, fallback = ''): string {
        return settings.value[key] ?? fallback;
    }

    return { settings, loaded, fetchSettings, get };
});
