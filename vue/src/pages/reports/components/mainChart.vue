<template>
  <div>
    <div class="d-flex align-center align-content-space-between">
      <v-spacer></v-spacer>
      <div style="height: 30px">
        <div class="actions mx-1" @click.stop="dialog = true">
          <v-btn ref="button" class="drawer-button" color="#1e8e49" dark>
            <v-icon class="fa-spin">mdi-cog-outline</v-icon>
          </v-btn>
        </div>
      </div>
    </div>
    <ChartConfigs
      :dialog="dialog"
      @close-modal="(val) => (dialog = val)"
      :type="chartType"
      :chartOptions="chartOptions"
      :title="title"
    />
    <apexchart
      width="100%"
      height="400"
      :options="chartOptions"
      :type="chartType.text"
      :series="series"
    ></apexchart>
  </div>
</template>
<script>
import ChartConfigs from "./ChartConfigs.vue";
import { getColorsRange } from "@/helpers";
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
    return {
      dialog: false,
    };
  },
  computed: {
    labels() {
      return this.chartData?.labels ?? [];
    },
    series() {
      return this.chartData?.result ?? [];
    },
    chartOptions() {
      const options =
        this.$store.state.statistics.chartOptions[this.chartType.text];
      const labels = this.labels;

      if (this.chartType.text == "pie" || this.chartType.text == "donut") {
        return { ...options, labels };
      } else {
        return { ...options, xaxis: { categories: labels } };
      }
    },
  },
  mounted() {},
};
</script>
