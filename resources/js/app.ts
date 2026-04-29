import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import i18n from './i18n';

// Pinia doit être instancié AVANT le router pour que les stores
// soient accessibles dès la première navigation
const pinia = createPinia();
const app = createApp(App);

app.use(pinia);   // 1. Pinia en premier — définit l'instance active
app.use(router);  // 2. Router — démarre la navigation initiale
app.use(i18n);    // 3. i18n

app.mount('#app');
