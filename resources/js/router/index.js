import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import dashboard from '../components/dashboard/DashboardContainer'

const routes = [
    {
        path: "/",
        redirect: "/dashboard"
    },
    {
        component: dashboard,
        name: "dashboard",
        path: "/dashboard"
    },
    {
        component: () => import('../components/achat/list'),
        name: "achats",
        path: "/achats"
    },
    {
        component: () => import('../components/achat/ajouter'),
        name: "ajouterAchats",
        path: "/achats/ajouter"
    },
    {
        component: () => import('../components/employe/list'),
        name: "employes",
        path: "/employes"
    },
    {
        component: () => import('../components/employe/ajouter'),
        name: "ajouterEmploye",
        path: "/employes/ajouter"
    },
    {
        component: () => import('../components/employe/edit'),
        name: "modifierEmploye",
        path: "/employes/:id/modifier",
    },
    {
        component: () => import('../components/fournisseur/list'),
        name: "fournisseurs",
        path: "/fournisseurs"
    },
    {
        component: () => import('../components/fournisseur/ajouter'),
        name: "ajouterFournisseur",
        path: "/fournisseurs/ajouter"
    },
    {
        component: () => import('../components/fournisseur/edit'),
        name: "modifierFournisseur",
        path: "/fournisseurs/:id/modifier",
    },
    // articles routes
    // {
    //     component : () => import('../components/article/list'),
    //     name : "articles",
    //     path : "/articles",
    // },
    // {
    //     component : () => import('../components/article/ajouter'),
    //     name : "ajouterArticles",
    //     path : "/articles/ajouter",
    // },
    // {
    //     component : () => import('../components/article/edit'),
    //     name : "modifierArticles",
    //     path : "/articles/:id/modifier",
    // },
    {
        component: () => import('../components/branchement/list'),
        name: "branchements",
        path: "/branchements"
    },
    {
        component: () => import('../components/parametre/index'),
        name: "parametres",
        path: "/parametres"
    },
];

export default new VueRouter({
    routes
});