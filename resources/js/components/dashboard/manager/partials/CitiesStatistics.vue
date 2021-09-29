<template>
  <v-col cols="12">
    <v-card class="pa-4">
      <bar-chart :height="500" :chartdata="chartdata"></bar-chart>
    </v-card>
  </v-col>
</template>

<script>
import BarChart from "../../../extra/charts/BarChart.vue";
export default {
  components: { BarChart },
  data() {
    return {
      chartdata: {
        labels: [],
        datasets: [
          {
            label: "",
            data: [],
            backgroundColor: [],
          },
        ],
      },
    };
  },
  watch: {
    byCities(n) {
      this.setData(n);
    },
  },
  computed: {
    byCities() {
      return this.$store.getters["dashboard/byCities"];
    },
  },
  methods: {
    setData(data) {
      this.chartdata = {
        labels: data.labels,
        datasets: [
          {
            label: "My First Dataset",
            data: data.data,
            backgroundColor: data.backgroundColors,
          },
        ],
      };
    },
  },
};
</script>
