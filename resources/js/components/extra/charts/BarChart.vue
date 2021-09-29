<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  props: {
    chartdata: {
      labels: [],
      datasets: [],
    },
  },
  data() {
    return {
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              callback: function (value) {
                if (value % 1 === 0) {
                  return value;
                }
              },
            },
          },
        ],
      },
    };
  },
  watch: {
    chartdata: {
      handler() {
        this.renderMe();
      },
      deep: true,
    },
  },
  methods: {
    renderMe() {
      this.renderChart(this.chartdata, {
        maintainAspectRatio: false,
        scales: this.scales,
      });
    },
  },
  mounted() {
    this.renderMe();
  },
};
</script>
