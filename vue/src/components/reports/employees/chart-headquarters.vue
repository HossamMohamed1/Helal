<template>
  <div v-if="showChart">
    <apexchart
      type="bar"
      height="350"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      showChart: false,
      series: [],
      chartOptions: {
        chart: {
          type: "bar",
          height: 430,
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "top",
            },
          },
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: "12px",
            colors: ["#fff"],
          },
        },
        stroke: {
          show: true,
          width: 1,
          colors: ["#fff"],
        },
        colors: ["#1e8e49", "#c3b086"],
        tooltip: {
          shared: true,
          intersect: false,
        },
        xaxis: {
          categories: [],
        },
      },
    };
  },
  mounted() {
    this.showChart = false;

    const data = {
      charts: ["bar"],
      type: "department_location",
    };

    this.fetchChart(data)
      .then((res) => {
        const { bar } = res;
        const { labels, result } = bar;
        this.series = result;
        this.chartOptions.xaxis.categories = labels;
        this.showChart = true;
      })
      .catch(() => {
        this.showChart = true;
      });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
