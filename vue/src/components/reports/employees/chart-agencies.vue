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
          name: "",
          data: [44, 55, 60, 70, 120, 100, 50, 60, 30],
        },
      ],
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
          categories: [
            this.$t("employees.administration1"),
            this.$t("employees.administration2"),
            this.$t("employees.administration3"),
            this.$t("employees.administration4"),
            this.$t("employees.administration5"),
            this.$t("employees.administration6"),
            this.$t("employees.administration7"),
            this.$t("employees.administration8"),
            this.$t("employees.administration9"),
          ],
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
              return +val + " موظف";
            },
          },
        },
      },
    };
  },
  mounted() {
    const data = {
      charts: ["bar"],
      type: "employee_department",
    };
    this.fetchChart(data)
      .then((res) => {
        console.log(res);
      })
      .catch();
    this.showChart = true;
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
