import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import dashboard from '../components/dashboard/DashboardContainer'
import contact from '../components/contact/ContactContainer'

const routes = [
    {
        component : dashboard,
        name : "dashboard",
        path : "/dashboard"
    },
    {
        component : contact,
        name : "contact",
        path : "/contact"
    }
];

export default new VueRouter({
    routes
});