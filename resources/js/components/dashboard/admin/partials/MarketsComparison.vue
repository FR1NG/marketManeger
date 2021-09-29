<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <bar-chart :chartdata="chartdata"></bar-chart>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import BarChart from "../../../extra/charts/BarChart.vue";
export default {
  components: { BarChart },
  data() {
    return {
      chartdata: {
        labels: ["m1", "m2", "m3", "m4", "m5", "m6", "m7"],
        datasets: [
          {
            label: "My First Dataset",
            data: [65, 59, 55, 60, 56, 55, 40],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(255, 159, 64, 0.2)",
              "rgba(255, 205, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(201, 203, 207, 0.2)",
            ],
            borderColor: [
              "rgb(255, 99, 132)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
            ],
            borderWidth: 1,
          },
        ],
      },
    };
  },
};
</script>

<style>
</style>