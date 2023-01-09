<template>
  <v-card flat :loading="loading">
    <apexchart
      :type="chartType"
      v-if="!loading"
      width="480"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </v-card>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      chartType: "donut",
      loading: false,
      series: [0, 0],
      chartOptions: {
        chart: {
          type: "pie",
        },
        labels: [],
        stroke: {
          // colors: ["#29abe2", "#a4a8ad", "#d5d5d5"]
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: "total",
                value: 20,
              },
            },
          },
        },
        colors: ["#1e8e49", "#c3b086"],
        legend: {
          position: "bottom",
          horizontalAlign: "center",
        },
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    };
  },
  mounted() {
    this.loading = true;
    let data = {
      charts: ["pie"],
      type: "employee_gender",
    };
    this.fetchChart(data)
      .then((res) => {
        this.loading = false;
        const { pie } = res;
        this.series = pie?.series.map((item) => parseInt(item));
        this.chartOptions.labels = pie?.labels;
      })
      .catch(() => {
        this.loading = false;
      });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
