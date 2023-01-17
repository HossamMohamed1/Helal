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
    <ChartConfigs
      :dialog="dialog"
      @close-modal="(val) => (dialog = val)"
      @applyConfig="applyConfig"
      :type="chartType"
      :chartOptions="chartOptions"
      :title="title"
    />
    <apexchart
      width="100%"
      v-if="!hideChart"
      height="400"
      :options="chartOptions"
      :type="chartType.text"
      :series="series"
    ></apexchart>
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
      default: "",
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
    let newOptions = {};
    if (this.chartType.text == "pie" || this.chartType.text == "donut") {
      newOptions = { ...options, labels };
    } else {
      newOptions = {
        ...options,
        xaxis: { ...options.xaxis, categories: labels },
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
    series() {
      return this.chartData?.result ?? [];
    },
  },
  mounted() {},
  methods: {
    applyConfig(val) {
      this.hideChart = true;
      setTimeout(() => {
        this.chartOptions = val;
        setTimeout(() => {
          this.hideChart = false;
          this.dialog = false;
        }, 200);
      }, 200);
    },
  },
};
</script>
