import { createI18n } from 'vue-i18n';
import fr from './locales/fr';
import en from './locales/en';
import es from './locales/es';

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') || 'fr',
    fallbackLocale: 'fr',
    messages: { fr, en, es },
});

export default i18n;
