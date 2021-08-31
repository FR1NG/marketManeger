import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import dashboard from '../components/dashboard/DashboardContainer'

const routes = [
    {
        component : dashboard,
        name : "dashboard",
        path : "/dashboard"
    },
    {
        component : () => import('../components/fournisseur/list'),
        name : "fournisseur",
        path : "/fournisseur"
    },
    {
        component : () => import('../components/fournisseur/ajouter'),
        name : "ajouterFournisseur",
        path : "/fournisseur/ajouter"
    },
    {
        component : () => import('../components/fournisseur/edit'),
        name : "modifierFournisseur",
        path : "/fournisseur/:id/modifier",
    },
    {
        component : () => import('../components/employe/list'),
        name : "employe",
        path : "/employe"
    },
    {
        component : () => import('../components/employe/ajouter'),
        name : "ajouterEmploye",
        path : "/employe/ajouter"
    },
    {
        component : () => import('../components/employe/edit'),
        name : "modifierEmploye",
        path : "/employe/:id/modifier",
    },
    {
        component : () => import('../components/achat/list'),
        name : "achat",
        path : "/achat"
    },
    {
        component : () => import('../components/branchement/list'),
        name : "branchement",
        path : "/branchement"
    },
    {
        component : () => import('../components/parametre/index'),
        name : "parametre",
        path : "/parametre"
    },
];

export default new VueRouter({
    routes
});