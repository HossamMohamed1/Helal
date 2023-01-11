<template>
  <div>
    <apexchart width="480" :options="chartOptions" :type="chartType" :series="series"></apexchart>
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
  computed: {
    labels() {
      return this.chartData?.labels ?? [];
    },
    series() {
      return this.chartData?.result ?? [];
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
  mounted() {},
};
</script>
