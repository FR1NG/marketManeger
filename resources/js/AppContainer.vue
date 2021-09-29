<template>
  <router-view></router-view>
</template>

<script>
export default {
  props: ["user", "roles"],
  created() {
    Vue.prototype.$roles = this.roles;
    Vue.prototype.$user = this.user;

    this.$router.beforeEach((to, from, next) => {
      if (to.meta.role) {
        Vue.prototype.$hasRole(to.meta.role) ? next() : next("/unauthorized ");
      } else {
        return next();
      }
    });
  },
};
</script>

<style>
</style>