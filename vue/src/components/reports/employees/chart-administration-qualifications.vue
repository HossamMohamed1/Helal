<template>
  <div v-if="showChart">
    <apexchart
      type="line"
      height="372"
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
      series: [
        // {
        //   name: this.$t("employees.administration1"),
        //   data: [20, 44, 40, 35, 28, 42],
        // },
        // {
        //   name: this.$t("employees.administration2"),
        //   data: [35, 36, 21, 25, 13, 18],
        // },
      ],
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
          categories: [
            // this.$t("employees.qualifications1"),
            // this.$t("employees.qualifications2"),
            // this.$t("employees.qualifications3"),
            // this.$t("employees.qualifications4"),
            // this.$t("employees.qualifications5"),
            // this.$t("employees.qualifications6"),
          ],
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
      charts: ["line"],
      type: "employee_qualification",
    };
    this.showChart = false;
    this.fetchChart(data)
      .then((res) => {
        this.showChart = true;
        // console.log(re);
        const { line } = res;
        const { labels, result } = line;
        // console.log(labels, result);
        this.series = result;
        this.chartOptions.xaxis.categories = labels;
      })
      .catch(() => {
        this.showChart = false;
      });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
