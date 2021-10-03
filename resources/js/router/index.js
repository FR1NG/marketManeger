import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import dashboard from '../components/dashboard/DashboardContainer'


const router = new VueRouter({
    routes: [
        {
            component: () => import('../components/profile/UserProfile'),
            name: 'profile',
            path: '/profile',
        },
        // ======================================[admin:begin]===========================
        {
            path: '/',
            redirect: '/dashboard'
        },

        {
            component: dashboard,
            name: "dashboard",
            path: "/dashboard",

        },
        // market routes
        {
            component: () => import('./../admin/markets/list'),
            name: 'adminMarkets',
            path: '/admin/marches',
            meta: {
                role: 'admin'
            },
        },

        {
            component: () => import('./../admin/markets/edit'),
            name: 'adminMarketsEdit',
            path: '/admin/marches/:id/config',
            redirect: { name: 'adminMarketInfo' },
            meta: {
                role: 'admin'
            },
            children: [
                {
                    component: () => import('./../admin/markets/config/info.vue'),
                    name: 'adminMarketInfo',
                    path: '#info',
                    alias: ''
                },
                {
                    component: () => import('./../admin/markets/config/articles.vue'),
                    name: 'adminMarketArticles',
                    path: '#articles'
                },
                {
                    component: () => import('./../admin/markets/config/cities.vue'),
                    name: 'adminMarketCities',
                    path: '#cities'
                },
                {
                    component: () => import('./../admin/markets/config/statistics.vue'),
                    name: 'adminMarketStatistics',
                    path: '#statistics'
                },
            ]
        },
        {
            component: () => import('./../admin/markets/create'),
            name: 'adminCreateMarkets',
            path: '/admin/marches/creer',
            meta: {
                role: 'admin'
            },
        },
        // settings routes
        {
            component: () => import('../components/parametre/index'),
            name: "parametres",
            path: "/admin/parametres",
            meta: {
                role: 'admin'
            },
        },

        // ======================================[admin:END]===========================


        // ======================================[manager:BEGIN]===========================



        // achat routers
        {
            component: () => import('../components/achat/list'),
            name: "achats",
            path: "/manager/achats",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/achat/details'),
            name: "achatDetails",
            path: "/manager/achats/:id/details",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/achat/ajouter'),
            name: "ajouterAchats",
            path: "/manager/achats/ajouter",
            meta: {
                role: 'manager'
            },
        },
        // livraison routers
        {
            component: () => import('../components/achat/livraison/details.vue'),
            name: "livraisonDetails",
            path: "/manager/livraisons/:id/details",
            meta: {
                role: 'manager'
            },
        },
        // employees routers
        {
            component: () => import('../components/employe/list'),
            name: "employes",
            path: "/manager/employes",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/employe/ajouter'),
            name: "ajouterEmploye",
            path: "/manager/employes/ajouter",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/employe/edit'),
            name: "modifierEmploye",
            path: "/manager/employes/:id/modifier",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/fournisseur/list'),
            name: "fournisseurs",
            path: "/manager/fournisseurs",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/fournisseur/ajouter'),
            name: "ajouterFournisseur",
            path: "/manager/fournisseurs/ajouter",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/fournisseur/edit'),
            name: "modifierFournisseur",
            path: "/manager/fournisseurs/:id/modifier",
            meta: {
                role: 'manager'
            },
        },
        // warehouse
        {
            component: () => import('../components/depot/list'),
            name: "depot",
            path: "/manager/depot",
            meta: {
                role: 'manager'
            },
        },
        // branchement routers
        {
            component: () => import('../components/branchement/list'),
            name: "branchements",
            path: "/manager/branchements",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/branchement/ajouter'),
            name: "ajouterBranchements",
            path: "/manager/branchements/ajouter",
            meta: {
                role: 'manager'
            },
        },
        {
            component: () => import('../components/branchement/details'),
            name: "branchementDetails",
            path: "/manager/branchements/:id/details",
            meta: {
                role: 'manager'
            },
        },

        // ======================================[manager:END]===========================

    ]
});



export default router;