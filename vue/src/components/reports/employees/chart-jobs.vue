<template>
  <div v-if="showChart">
    <v-card>
      <apexchart
        type="line"
        height="350"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </v-card>
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
          height: 350,
          type: "line",
          zoom: {
            enabled: false,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          width: [2, 2, 2, 2, 2],
          curve: "smooth",
          // dashArray: [0, 8, 5]
        },
        title: {
          text: "",
          align: "center",
        },
        legend: {
          tooltipHoverFormatter: function (val, opts) {
            return (
              val +
              " - " +
              opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
              ""
            );
          },
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6,
          },
        },
        xaxis: {
          categories: [],
        },
        colors: ["#1e8e49", "#c3b086"],
        tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val + " موظف ";
                },
              },
            },
            {
              title: {
                formatter: function (val) {
                  return val + " موظف ";
                },
              },
            },
            {
              title: {
                formatter: function (val) {
                  return val;
                },
              },
            },
          ],
        },
        grid: {
          borderColor: "#f1f1f1",
        },
      },
    };
  },
  mounted() {
    const data = {
      charts: ["bar"],
      type: "employee_job",
    };
    this.showChart = false;

    this.fetchChart(data)
      .then((res) => {
        const { bar } = res ?? {};
        const { labels, result } = bar ?? {};
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
