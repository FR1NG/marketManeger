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
        path : "/ajouterFournisseur"
    },
    {
        component : () => import('../components/employe/list'),
        name : "employe",
        path : "/employe"
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