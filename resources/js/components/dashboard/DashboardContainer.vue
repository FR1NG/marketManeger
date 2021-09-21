<template>
  <v-container>
    <statistics></statistics>
    <chart></chart>
  </v-container>
</template>

<script>
import Chart from "./partials/chart.vue";
import statistics from "./partials/statistics.vue";
export default {
  components: { statistics, Chart },
  created() {
    this.$store.dispatch("dashboard/getData");
  },
};
</script>

<style>
</style>