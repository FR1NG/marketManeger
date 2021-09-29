<template>
  <v-col cols="12" md="8">
    <v-card>
      <v-card-text>
        <line-chart :chartdata="chartdata"></line-chart>
      </v-card-text>
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
        labels: ["m1", "m2", "m3", "m4", "m5", "m6", "m7"],
        datasets: [
          {
            label: "My First Dataset",
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
          },
          {
            label: "My Second Dataset",
            data: [30, 45, 90, 55, 80, 87, 35],
            fill: false,
            borderColor: "rgb(75, 80, 95)",
            tension: 0.1,
          },
        ],
      },
    };
  },
};
</script>

<style>
</style>