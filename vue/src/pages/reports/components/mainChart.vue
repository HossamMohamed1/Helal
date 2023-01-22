<template>
  <div>
    <div class="d-flex align-center align-content-space-between">
      <v-spacer></v-spacer>
      <div >
        <div class="actions mx-1" @click.stop="dialog = true">
          <v-btn ref="button" class="drawer-button" color="#1e8e49" small dark>
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
        </div>
      </div>
    </div>
    <ChartConfigs
      :dialog="dialog"
      @close-modal="(val) => (dialog = val)"
      @applyConfig="applyConfig"
      :type="chartType"
      :chartOptions="chartOptions"
      :title="title"
    />

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
import variablePie from "highcharts/modules/variable-pie"
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
      if (typeof this.chartData.result == "undefined") {
        let keys = Object.keys(this.chartData);
        result = [];
        keys.forEach((key) => {
          const newItem = this.chartData[key].result.map((item, index) => {
            return {
              y: item,
              name: this.chartData[key].labels[index],
            };
          });
          result.push({
            name: key,
            data: newItem,
            ...options?.raduis,
          });
        });
      } else {
        result = [
          {
            name: "",
            data: this.chartData.result.map((item, index) => {
              return {
                y: item,
                name: this.chartData.labels[index],
                ...options?.raduis,
              };
            }),
          },
        ];
      }
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
  computed: {},
  mounted() {},
  methods: {
    applyConfig(val) {
      this.chartOptions = val;
    },
  },
};
</script>

<style>
.highcharts-credits {
  display: none !important;
}
</style>
