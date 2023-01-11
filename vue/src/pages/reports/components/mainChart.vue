<template>
  <div>
    <apexchart width="480" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>
<script>
export default {
  props: {
    chartType: {
      type: String,
      default: "",
    },
    chartData: {
      type: Object,
      default: {},
    },
  },
  data() {
    return { labels: [] };
  },
  computed: {
    labels() {
      return chartData?.labels ?? [];
    },
    series() {
      return chartData?.result ?? [];
    },
    chartOptions() {
      const options = this.$store.state.statistics.chartOptions[this.chartType];
      const labels = this.labels;
      if (this.chartType == "pie") {
        return { ...options, labels };
      } else {
        return { ...options, xaxis: { categories: labels } };
      }
    },
  },
  mounted() {
    console.log(this.chartType);
  },
};
</script>
