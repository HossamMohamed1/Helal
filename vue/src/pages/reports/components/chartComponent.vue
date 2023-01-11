<template>
  <v-col cols="12" lg="6">
    <v-card flat :loading="loading" height="355">
      <apexchart
        v-if="!loading && report.type !== 'table'"
        :type="report.type"
        width="480"
        height="350"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </v-card>
  </v-col>
</template>

<script>
import { options } from "@amcharts/amcharts4/core";
import { mapActions } from "vuex";
export default {
  data() {
    return {
      loading: false,
      series: [],
      labels: ["males", "females"],
    };
  },
  props: {
    report: { type: Object, default: {} },
  },
  computed: {
    chartOptions() {
      const options =
        this.$store.state.statistics.chartOptions[this.report.type];
      const labels = this.labels;
      if (this.report.type == "pie") {
        // console.log(labels);
        return { ...options, labels };
      } else {
        return { ...options, xaxis: { categories: labels } };
      }
    },
  },

  mounted() {
    // console.log(this.chartOptions);
    let data = {
      charts: [this.report.type],
      type: this.report.chart,
    };
    this.loading = true;
    this.fetchChart(data)
      .then((res) => {
        this.loading = false;
        const chart = res[this.report.type];
        console.log(chart)
        this.labels = chart?.labels ?? [];
        this.series = chart?.result ?? [];
      })
      .catch((err) => {
        this.loading = false;
      });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
