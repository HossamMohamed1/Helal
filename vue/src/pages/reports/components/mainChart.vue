<template>
  <div>
    <apexchart
      width="100%"
      height="400"
      :options="chartOptions"
      :type="chartType.text"
      :series="series"
    ></apexchart>
  </div>
</template>
<script>
export default {
  props: {
    chartType: {
      type: Object,
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
      const options =
        this.$store.state.statistics.chartOptions[this.chartType.text];
      const labels = this.labels;
      if (this.chartType.text == "pie" || this.chartType.text == "donut") {
        return { ...options, labels };
      } else {
        return { ...options, xaxis: { categories: labels } };
      }
    },
  },
};
</script>
