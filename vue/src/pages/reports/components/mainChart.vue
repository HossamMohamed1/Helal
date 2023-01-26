<template>
  <div>
    <div class="d-flex align-center align-content-space-between">
      <v-spacer></v-spacer>
      <div>
        <div class="actions d-flex align-item-center mx-1">
          <v-btn
            ref="button"
            class="drawer-button"
            @click.stop="dialog = true"
            color="#1e8e49"
            small
            dark
          >
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
          <v-chip
            v-if="category"
            class="d-flex mr-1"
            close
            @click:close="handleResetFilter"
          >
            {{ category }}
          </v-chip>
        </div>
      </div>
    </div>
    <ChartConfigs
      :dialog="dialog"
      @close-modal="(val) => (dialog = val)"
      @applyConfig="applyConfig"
      :type="chartType"
      :chartOptions="chartOptions"
      v-if="chartOptions.type"
      :title="title"
    />
    <highcharts v-if="chartOptions.type" :options="chartOptions"></highcharts>
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
    report: { type: Object, default: {} },
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
            ...options?.raduis,
            data: this.chartData.result.map((item, index) => {
              return {
                y: item,
                name: this.chartData.labels[index],
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
      chartOptions: {
        ...newOptions,
        plotOptions: {
          ...newOptions?.plotOptions,
          series: {
            ...newOptions?.plotOptions?.series,
            events: { click: this.handleClick },
          },
        },
      },
      hideChart: false,
      category: null,
    };
  },

  mounted() {},
  methods: {
    applyConfig(val) {
      this.chartOptions = val;
    },
    handleClick(e) {
      let category = e.point.category ?? e.point.name;
      const { filter_able } = this.report;
      if (filter_able) {
        this.category = category;
        this.$emit("filter", { category });
      }
    },
    handleResetFilter() {
      this.category = null;
      this.$emit("filter", { category: this.category });
    },
  },
};
</script>

<style>
.highcharts-credits {
  display: none !important;
}
</style>
