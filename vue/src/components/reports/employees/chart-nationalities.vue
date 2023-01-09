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
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        xaxis: {
          categories: [],
          // title: {
          //   text: 'Drones'
          // }
        },
        yaxis: {
          title: {
            // text: 'Screenshots'
          },
        },
        colors: ["#1e8e49"],
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " موظف";
            },
          },
        },
      },
    };
  },
  mounted() {
    const data = {
      charts: ["bar"],
      type: "employee_nationality",
    };
    this.showChart = false;

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
