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
      series: [
        {
          name: "الأقسام",
          data: [44, 55, 41, 64, 22, 43, 21, 33, 37, 46],
        },
        {
          name: "الإدارات",
          data: [53, 32, 33, 52, 13, 44, 32, 34, 56, 53],
        },
      ],
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
          categories: [
            "موقع 1",
            "موقع 2",
            "موقع 3",
            "موقع 4",
            "موقع 5",
            "موقع 6",
            "موقع 7",
            "موقع 8",
            "موقع 9",
            "موقع 10",
          ],
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
        console.log("aa", labels, result);
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
