<template>
  <div>
    <!-- <div class="d-flex align-center align-content-space-between">
      <v-spacer></v-spacer>
      <div style="height: 30px">
        <div class="actions mx-1" @click.stop="dialog = true">
          <v-btn ref="button" class="drawer-button" color="#1e8e49" dark>
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
        </div>
      </div>
    </div> -->
    <!-- <ChartConfigs
      :dialog="dialog"
      @close-modal="(val) => (dialog = val)"
      @applyConfig="applyConfig"
      :type="chartType"
      :chartOptions="chartOptions"
      :title="title"
    /> -->

    <highcharts :options="chartOptions"></highcharts>

    <!-- <apexchart
      width="100%"
      v-if="!hideChart"
      height="400"
      :options="chartOptions"
      :type="chartType.text"
      :series="series"
    ></apexchart> -->
  </div>
</template>
<script>
import ChartConfigs from "./ChartConfigs.vue";
export default {
  components: {
    ChartConfigs,
  },
  props: {
    chartType: {
      type: Object,
      default: {},
    },
    chartData: {
      type: Object,
      default: {},
    },
    title: {
      type: String,
      default: "",
    },
  },
  data() {
    // create instance for each component
    const labels = this.chartData?.labels;
    const options =
      this.$store.state.statistics.chartOptions[this.chartType.text];
    let newOptions = options ?? {};
    let result = this.chartData?.result;

    if (this.chartType.text == "pie" || this.chartType.text == "donut") {
      // newOptions = { ...options, labels };
      result = [
        {
          name: "",
          data: this.chartData.result.map((item, index) => {
            return {
              y: item,
              name: this.chartData.labels[index],
            };
          }),
        },
      ];
      newOptions = { ...options, series: result };
    } else {
      newOptions = {
        ...options,
        xAxis: { ...(options?.xAxis ?? {}), categories: labels },
        series: result.map((item) => ({
          ...item,
          data: item.data.map((item) => parseFloat(item)),
        })),
      };
    }

    // end get new instance for chart option for each component
    return {
      dialog: false,
      chartOptions: newOptions,
      hideChart: false,
    };
  },
  computed: {
    // series() {
    //   return this.chartData?.result ?? [];
    // },
    // chart() {
    //   // console.log(this.chartType);
    //   // let result = this.chartData?.result;
    //   // // console.log(res);
    //   // if (this.chartType.text == "pie") {
    //   //   result = [
    //   //     {
    //   //       name: "",
    //   //       data: this.chartData.result.map((item, index) => {
    //   //         return {
    //   //           y: item,
    //   //           name: this.chartData.labels[index],
    //   //         };
    //   //       }),
    //   //     },
    //   //   ];
    //   //   // result = this.chartData?.result.map((item, index) => {
    //   //   //   return { name: this.chartData?.labels[index], y: item };
    //   //   // });
    //   // } else {
    //   //   console.log(this.chartData?.labels);
    //   // }
    //   return {
    //     chart: {
    //       type: this.chartType.text,
    //     },
    //     title: {
    //       text: null,
    //       align: "left",
    //     },
    //     subtitle: {
    //       text: "",
    //       align: "left",
    //     },
    //     xAxis: {
    //       categories: this.chartData?.labels,
    //       title: {
    //         text: null,
    //       },
    //     },
    //     yAxis: {
    //       min: 0,
    //       title: {
    //         text: "",
    //         align: "high",
    //       },
    //       labels: {
    //         overflow: "justify",
    //       },
    //     },
    //     tooltip: {
    //       valueSuffix: "",
    //     },
    //     plotOptions: {
    //       bar: {
    //         dataLabels: {
    //           enabled: true,
    //         },
    //       },
    //       pie: {
    //         allowPointSelect: true,
    //         cursor: "pointer",
    //         dataLabels: {
    //           enabled: true,
    //           format: "<b>{point.name}</b>: {point.percentage:.1f} %",
    //         },
    //       },
    //       series: {
    //         label: {
    //           connectorAllowed: false,
    //         },
    //         pointStart: 2010,
    //       },
    //     },
    //     legend: {
    //       layout: "horizontal",
    //       align: "right",
    //       verticalAlign: "top",
    //       x: -40,
    //       y: 80,
    //       floating: true,
    //       borderWidth: 1,
    //       backgroundColor: "#FFFFFF",
    //       shadow: true,
    //     },
    //     credits: {
    //       enabled: false,
    //     },
    //     series: result,
    //     colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
    //   };
    // },
  },
  mounted() {},
  methods: {
    applyConfig(val) {
      // this.hideChart = true;
      // setTimeout(() => {
      this.chartOptions = val;
      //   setTimeout(() => {
      //     this.hideChart = false;
      //     this.dialog = false;
      //   }, 200);
      // }, 200);
    },
  },
};
</script>

<style>
.highcharts-credits {
  display: none !important;
}
</style>
