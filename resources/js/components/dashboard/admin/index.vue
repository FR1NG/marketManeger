<template>
  <div>
    <today-statistics></today-statistics>
    <v-row>
      <markets-progress></markets-progress>
    </v-row>
    <markets-comparison></markets-comparison>
  </div>
</template>

<script>
import MarketsAccomplishment from "./partials/MarketsAccomplishment.vue";
import MarketsComparison from "./partials/ByMarket.vue";
import MarketsProgress from "./partials/WeekStatistics.vue";
import TodayStatistics from "./partials/TodayStatistics.vue";
export default {
  components: {
    TodayStatistics,
    MarketsAccomplishment,
    MarketsProgress,
    MarketsComparison,
  },
  methods: {
    getData() {
      this.$store.dispatch("admin/dashboard/getData");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>
