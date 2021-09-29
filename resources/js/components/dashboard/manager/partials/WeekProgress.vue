<template>
  <v-col cols="12" md="8">
    <v-card rounded class="mt-4">
      <v-container>
        <line-chart :chartdata="chartdata"></line-chart>
      </v-container>
    </v-card>
  </v-col>
</template>

<script>
import LineChart from "../../../extra/charts/LineChart.vue";
export default {
  components: { LineChart },
  data() {
    return {
      chartdata: {
        labels: [],
        datasets: [
          {
            label: "My First Dataset",
            data: [],
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
          },
        ],
      },
    };
  },
  watch: {
    data(n) {
      this.chartdata = {
        labels: n.labels,
        datasets: [
          {
            label: "My First Dataset",
            data: n.data,
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
          },
        ],
      };
    },
  },
  computed: {
    data() {
      return this.$store.getters["dashboard/weekBranchements"];
    },
  },
  methods: {},
};
</script>

<style>
</style>