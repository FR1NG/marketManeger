<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  props: {
    chartdata: {
      type: Object,
      default: null,
    },
  },
  watch: {
    chartdata: {
      handler(n, o) {
        n != o ? this.renderMe() : null;
      },
      deep: true,
    },
  },
  data() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    };
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