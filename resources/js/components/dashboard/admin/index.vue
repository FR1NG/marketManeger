<template>
  <div>
    <today-statistics></today-statistics>
    <v-row>
      <markets-progress></markets-progress>
      <markets-accomplishment></markets-accomplishment>
    </v-row>
    <markets-comparison></markets-comparison>
  </div>
</template>

<script>
import MarketsAccomplishment from "./partials/MarketsAccomplishment.vue";
import MarketsComparison from "./partials/MarketsComparison.vue";
import MarketsProgress from "./partials/MarketsProgress.vue";
import TodayStatistics from "./partials/TodayStatistics.vue";
export default {
  components: {
    TodayStatistics,
    MarketsAccomplishment,
    MarketsProgress,
    MarketsComparison,
  },
};
</script>

<style>
</style>
