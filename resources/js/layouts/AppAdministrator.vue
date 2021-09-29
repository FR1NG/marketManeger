<template>
  <v-app id="inspire">
    <vue-ins-progress-bar></vue-ins-progress-bar>
    <!-- sidebar:BEGIN -->
    <side-bar :links="links"></side-bar>
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
      links: [
        {
          text: "Tableau de bord",
          icon: "mdi-monitor-dashboard",
          path: "dashboard",
        },
        {
          text: "Marchés",
          icon: "mdi-briefcase-outline",
          path: "adminMarkets",
        },
        { text: "Paramètres", icon: "mdi-tune", path: "parametres" },
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
    this.$router.beforeEach((to, from, next) => {
      if (to.meta.role) {
        Vue.prototype.$hasRole(to.meta.role) ? next() : next("/unauthorized ");
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
