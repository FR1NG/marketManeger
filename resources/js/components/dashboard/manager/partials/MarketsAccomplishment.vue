<template>
  <v-col cols="12" md="4">
    <v-card :loading="loading">
      <v-card-text>
        <pie-chart :chartdata="chartdata"></pie-chart>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import pieChart from "../../../extra/charts/pieChart.vue";
import { mapGetters } from "vuex";
export default {
  components: { pieChart },
  data() {
    return {
      article: null,
      loading: false,
      chartdata: {
        labels: ["Complété", "Incomplet"],
        datasets: [
          {
            backgroundColor: ["#f87979"],
            data: this.accomplishement,
          },
        ],
      },
    };
  },
  watch: {
    article() {
      this.getData();
    },
    accomplishement() {
      this.chartdata = {
        labels: ["Complété", "Incomplet"],
        datasets: [
          {
            backgroundColor: ["#f87979"],
            data: this.accomplishement,
          },
        ],
      };
    },
  },
  computed: {
    ...mapGetters({
      accomplishement: "dashboard/accomplishement",
    }),
  },
};
</script>

<style>
</style>