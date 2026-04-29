import { createRouter, createWebHistory } from 'vue-router';
import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        // Import lazy pour que le layout ne s'évalue pas avant app.use(pinia)
        component: () => import('@/layouts/PublicLayout.vue'),
        children: [
            {
                path: '',
                name: 'home',
                component: () => import('@/pages/Home.vue'),
                meta: { title: 'Accueil' },
            },
            {
                path: 'le-gite',
                name: 'gite',
                component: () => import('@/pages/Gite.vue'),
                meta: { title: 'Le Gîte' },
            },
            {
                path: 'galerie',
                name: 'galerie',
                component: () => import('@/pages/Galerie.vue'),
                meta: { title: 'Galerie Photos' },
            },
            {
                path: 'tarifs',
                name: 'tarifs',
                component: () => import('@/pages/Tarifs.vue'),
                meta: { title: 'Tarifs' },
            },
            {
                path: 'disponibilites',
                name: 'disponibilites',
                component: () => import('@/pages/Disponibilites.vue'),
                meta: { title: 'Disponibilités' },
            },
            {
                path: 'activites',
                name: 'activites',
                component: () => import('@/pages/Activites.vue'),
                meta: { title: 'Activités & Alentours' },
            },
            {
                path: 'contact',
                name: 'contact',
                component: () => import('@/pages/Contact.vue'),
                meta: { title: 'Contact & Réservation' },
            },
            {
                path: 'mentions-legales',
                name: 'mentions-legales',
                component: () => import('@/pages/MentionsLegales.vue'),
                meta: { title: 'Mentions légales' },
            },
            {
                path: 'cgv',
                name: 'cgv',
                component: () => import('@/pages/Cgv.vue'),
                meta: { title: "Conditions générales de vente" },
            },
        ],
    },
    // Page 404
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@/pages/NotFound.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    // Retour en haut de page à chaque navigation
    scrollBehavior(to, _from, savedPosition) {
        if (savedPosition) return savedPosition;
        if (to.hash) return { el: to.hash, behavior: 'smooth' };
        return { top: 0, behavior: 'smooth' };
    },
});

// Mise à jour du titre de la page
router.afterEach((to) => {
    const siteTitle = 'Gîte des Chênes';
    document.title = to.meta.title
        ? `${to.meta.title} — ${siteTitle}`
        : siteTitle;
});

export default router;
