<template>
  <v-container>
    <admin-dashboard
      v-if="$hasRole('admin') && !$adminVisite"
    ></admin-dashboard>
    <manager-dashboard
      v-if="$hasRole('manager') || $adminVisite"
    ></manager-dashboard>
  </v-container>
</template>

<script>
import adminDashboard from "./admin";
import managerDashboard from "./manager";
export default {
  components: {
    adminDashboard,
    managerDashboard,
  },
  created() {
    this.$store.dispatch("dashboard/getData");
  },
  mounted() {},
};
</script>

<style lang="scss">
.cursor-pointer:hover {
  cursor: pointer;
}
</style>