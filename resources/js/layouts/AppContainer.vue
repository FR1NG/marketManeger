<template>
  <v-app id="inspire">
    <vue-ins-progress-bar></vue-ins-progress-bar>
    <!-- sidebar:BEGIN -->
    <side-bar></side-bar>
    <!-- sidebar:END -->

    <!-- navbar:BEGIN -->
    <nav-bar :user="user"></nav-bar>
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
  components: {
    NavBar,
    SideBar,
    Alert,
    Toast,
  },
  props: ["user", "roles"],
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
