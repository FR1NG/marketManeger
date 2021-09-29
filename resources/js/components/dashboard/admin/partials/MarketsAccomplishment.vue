<template>
  <v-col cols="12" md="4">
    <v-card>
      <v-card-text>
        <pie-chart :chartdata="chartdata"></pie-chart>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import pieChart from "../../../extra/charts/pieChart.vue";
export default {
  components: { pieChart },
  data() {
    return {
      chartdata: {
        labels: ["January", "February", "march"],
        datasets: [
          {
            label: "Data One",
            backgroundColor: ["#f87979", "#fd1123"],
            data: [40, 20, 15],
          },
        ],
      },
    };
  },
};
</script>

<style>
</style>