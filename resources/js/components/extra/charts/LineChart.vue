<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false,
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
      this.renderChart(this.chartdata, this.options);
    },
  },
  mounted() {
    this.renderMe();
  },
};
</script>