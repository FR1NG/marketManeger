<template>
  <v-app id="inspire">
    <!-- sidebar:BEGIN -->
    <side-bar></side-bar>
    <!-- sidebar:END -->

    <!-- navbar:BEGIN -->
    <nav-bar></nav-bar>
    <!-- navbar:END -->


    <v-main>
      <!-- alert holder:BEGIN -->
      <alert></alert>
      <!-- alert holder:END -->

      <!--main:BEGIN-->
      <router-view></router-view>
      <!-- main:END -->
    </v-main>
  </v-app>
</template>

<script>
import Alert from '../components/extra/alert.vue';
import NavBar from './partials/NavBar.vue';
import SideBar from './partials/SideBar.vue';
  export default {
    components : {
      NavBar,
      SideBar,
      Alert,
    }, 
  }
</script>
