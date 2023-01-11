<template>
  <v-col cols="12" lg="6">
    <v-card flat :loading="loading" height="350">
      <apexchart
        v-if="!loading && report.type !== 'table'"
        :type="report.type"
        width="480"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </v-card>
  </v-col>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      loading: false,
      series: [],
      labels: [],
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
      return { ...options, labels };
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
        console.log(chart);
      })
      .catch(() => {
        this.loading = false;
      });
    console.log(data);
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
