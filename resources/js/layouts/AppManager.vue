<template>
  <v-app id="inspire">
    <vue-ins-progress-bar></vue-ins-progress-bar>
    <!-- sidebar:BEGIN -->
    <side-bar :links="navLinks"></side-bar>
    <!-- sidebar:END -->

    <!-- navbar:BEGIN -->
    <nav-bar></nav-bar>
    <!-- navbar:END -->

    <v-main>
      <!-- toast holder:BEGIN -->
      <toast v-if="toast"></toast>
      <!-- toast holder:END -->

      <!-- alert holder:BEGIN -->
      <alert v-if="alertd"></alert>
      <!-- alert holder:END -->

      <!--main:BEGIN-->
      <v-fade-transition leave-absolute>
        <router-view></router-view>
      </v-fade-transition>
      <!-- main:END -->
    </v-main>
  </v-app>
</template>

<script>
import colors from "vuetify/lib/util/colors";
import Vue from "vue";
import Alert from "../components/extra/alert.vue";
import Toast from "../components/extra/toast.vue";
import NavBar from "./partials/NavBar.vue";
import SideBar from "./partials/SideBar.vue";
import axios from "axios";
export default {
  props: {
    user: {},
    roles: {},
    market_id: {
      type: Number,
      default: null,
    },
  },
  components: {
    NavBar,
    SideBar,
    Alert,
    Toast,
  },
  data() {
    return {
      navLinks: [
        {
          text: "Tableau de bord",
          icon: "mdi-laptop",
          path: "dashboard",
        },
        { text: "Achat", icon: "mdi-cart-outline", path: "achats" },
        { text: "Employé", icon: "mdi-account-outline", path: "employes" },
        {
          text: "Fournisseur",
          icon: "mdi-truck-outline",
          path: "fournisseurs",
        },
        { text: "Dépot", icon: "mdi-warehouse", path: "depot" },
        { text: "Branchement", icon: "mdi-tools", path: "branchements" },
      ],
    };
  },
  computed: {
    toast() {
      return this.$store.getters["toast/toast"];
    },
    alertd() {
      return this.$store.getters["alert/alert"];
    },
  },
  mounted() {
    this.$insProgress.finish();
  },
  created() {
    Vue.prototype.$roles = this.roles;
    Vue.prototype.$user = this.user;
    Vue.prototype.$adminVisite = this.market_id != null;
    if (this.market_id != null) {
      axios.defaults.baseURL = "http://127.0.0.1:8000/market/" + this.market_id;
    }
    this.$router.beforeEach((to, from, next) => {
      if (to.meta.role) {
        Vue.prototype.$hasRole(to.meta.role) || this.market_id != null
          ? next()
          : this.$store.dispatch("alert/show", {
              text: "Cette URL n'est pas autorisée",
              type: "error",
            });
      } else {
        return next();
      }
    });

    this.$insProgress.start();

    this.$router.beforeEach((to, from, next) => {
      this.$insProgress.start();
      next();
    });

    this.$router.afterEach((to, from) => {
      this.$insProgress.finish();
    });
  },
};
</script>
<style lang="scss">
a:hover {
  text-decoration: none;
}
</style>
