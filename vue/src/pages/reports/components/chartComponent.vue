<template>
  <v-col cols="12" lg="6">
    <v-card flat :loading="loading" height="100%">
      <v-card-title class="d-flex align-center align-content-space-between">
        <div>{{ $t(report.title) }}</div>
      </v-card-title>

      <v-tabs v-model="tab" centered slider-color="yellow">
        <v-tab v-for="(type, i) in chartTypes" :key="i" :href="`#tab-${i}`">
          {{ type.text }}
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="(type, i) in chartTypes"
          :key="i"
          :value="`tab-${i}`"
        >
          <v-card flat>
            <mainChart
              v-if="chartData[type.value] && !loading"
              :chartType="type"
              :chartData="chartData[type.value]"
              :title="report.title"
            />
            <div v-else>
              <v-card
                v-if="loading"
                flat
                height="400"
                class="d-flex flex-grow-1 align-center justify-center"
              >
                <v-progress-circular
                  indeterminate
                  size="40"
                  color="primary"
                ></v-progress-circular>
              </v-card>
              <v-card
                flat
                height="400"
                class="d-flex flex-grow-1 align-center justify-center"
                v-else
              >
                <img :src="emptyImage" height="350" />
              </v-card>
            </div>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-col>
</template>

<script>
import { mapActions } from "vuex";
const mainChart = () =>
  import(/* webpackChunkName: "main-chart" */ "./mainChart.vue");
export default {
  components: {
    mainChart,
  },
  data() {
    return {
      loading: false,
      chartData: {},
      tab: 0,
      emptyImage: require("@/assets/images/No data-pana.png"),
    };
  },
  props: {
    report: {
      type: Object,
      default: {},
    },
  },
  computed: {
    chartTypes() {
      return this.report.type;
    },
  },

  mounted() {
    let data = {
      charts: this.report.type.map((item) => item.value),
      type: this.report.chart,
    };

    this.loading = true;
    // this.chartData = {
    //   bar: {
    //     labels: [
    //       "a",
    //       "b",
    //       "c",
    //       "d",
    //       "f",
    //       "g",
    //       "h",
    //       "i",
    //       "j",
    //       "k",
    //       "l",
    //       "m",
    //       "n",
    //       "o",
    //       "p",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: [
    //           43, 74, 57, 56, 277, 256, 247, 2, 59, 124, 177, 101, 98, 151, 105,
    //         ],
    //       },
    //     ],
    //   },
    //   line: {
    //     labels: [
    //       "a",
    //       "b",
    //       "c",
    //       "d",
    //       "f",
    //       "g",
    //       "h",
    //       "i",
    //       "j",
    //       "k",
    //       "l",
    //       "m",
    //       "n",
    //       "o",
    //       "p",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: [
    //           43, 74, 57, 56, 277, 256, 247, 2, 59, 124, 177, 101, 98, 151, 105,
    //         ],
    //       },
    //     ],
    //   },
    //   pie: {
    //     labels: [
    //       "a",
    //       "b",
    //       "c",
    //       "d",
    //       "f",
    //       "g",
    //       "h",
    //       "i",
    //       "j",
    //       "k",
    //       "l",
    //       "m",
    //       "n",
    //       "o",
    //       "p",
    //     ],
    //     result: [
    //       43, 74, 57, 56, 277, 256, 247, 2, 59, 124, 177, 101, 98, 151, 105,
    //     ],
    //   },
    // };

    this.loading = false;
    // this.chartData = {
    //   bar: {
    //     labels: ["\u0630\u0643\u0631", "\u0623\u0646\u062b\u0649"],
    //     result: [
    //       { name: "\u0627\u0644\u0639\u062f\u062f", data: ["4849", "937"] },
    //     ],
    //   },
    //   line: {
    //     labels: ["\u0630\u0643\u0631", "\u0623\u0646\u062b\u0649"],
    //     result: [
    //       { name: "\u0627\u0644\u0639\u062f\u062f", data: ["4849", "937"] },
    //     ],
    //   },
    //   pie: {
    //     labels: ["\u0630\u0643\u0631", "\u0623\u0646\u062b\u0649"],
    //     result: [4849, 937],
    //   },
    // };

    // this.fetchChart(data)
    //   .then((res) => {
    //     this.loading = false;
    //     this.chartData = res;
    //   })
    //   .catch((err) => {
    //     this.loading = false;
    //     // console.log(err);
    //   });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
