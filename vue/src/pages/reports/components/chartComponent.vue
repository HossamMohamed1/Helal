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

    // this.loading = false;
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

    // this.chartData = {
    //   bar: {
    //     labels: [
    //       "Jan 1, 2023",
    //       "Jan 2, 2023",
    //       "Jan 3, 2023",
    //       "Jan 4, 2023",
    //       "Jan 5, 2023",
    //       "Jan 6, 2023",
    //       "Jan 7, 2023",
    //       "Jan 8, 2023",
    //       "Jan 9, 2023",
    //       "Jan 10, 2023",
    //       "Jan 11, 2023",
    //       "Jan 12, 2023",
    //       "Jan 13, 2023",
    //       "Jan 14, 2023",
    //       "Jan 15, 2023",
    //       "Jan 16, 2023",
    //       "Jan 17, 2023",
    //       "Jan 18, 2023",
    //       "Jan 19, 2023",
    //     ],
    //     result: [
    //       {
    //         name: "attendance",
    //         data: [
    //           "482",
    //           "631",
    //           "520",
    //           "570",
    //           "502",
    //           "182",
    //           "125",
    //           "449",
    //           "480",
    //           "467",
    //           "457",
    //           "468",
    //           "154",
    //           "127",
    //           "430",
    //           "460",
    //           "501",
    //           "479",
    //           "543",
    //         ],
    //       },
    //       {
    //         name: "late",
    //         data: [
    //           "339",
    //           "430",
    //           "379",
    //           "427",
    //           "356",
    //           "157",
    //           "116",
    //           "331",
    //           "353",
    //           "337",
    //           "335",
    //           "313",
    //           "127",
    //           "115",
    //           "309",
    //           "336",
    //           "351",
    //           "311",
    //           "293",
    //         ],
    //       },
    //       {
    //         name: "no_late",
    //         data: [
    //           "143",
    //           "201",
    //           "141",
    //           "143",
    //           "146",
    //           "25",
    //           "9",
    //           "118",
    //           "127",
    //           "130",
    //           "122",
    //           "155",
    //           "27",
    //           "12",
    //           "121",
    //           "124",
    //           "150",
    //           "168",
    //           "250",
    //         ],
    //       },
    //       {
    //         name: "early",
    //         data: [
    //           "49",
    //           "60",
    //           "42",
    //           "49",
    //           "48",
    //           "9",
    //           "2",
    //           "41",
    //           "38",
    //           "44",
    //           "36",
    //           "43",
    //           "6",
    //           "3",
    //           "39",
    //           "31",
    //           "42",
    //           "46",
    //           "50",
    //         ],
    //       },
    //     ],
    //   },
    //   line: {
    //     labels: [
    //       "Jan 1, 2023",
    //       "Jan 2, 2023",
    //       "Jan 3, 2023",
    //       "Jan 4, 2023",
    //       "Jan 5, 2023",
    //       "Jan 6, 2023",
    //       "Jan 7, 2023",
    //       "Jan 8, 2023",
    //       "Jan 9, 2023",
    //       "Jan 10, 2023",
    //       "Jan 11, 2023",
    //       "Jan 12, 2023",
    //       "Jan 13, 2023",
    //       "Jan 14, 2023",
    //       "Jan 15, 2023",
    //       "Jan 16, 2023",
    //       "Jan 17, 2023",
    //       "Jan 18, 2023",
    //       "Jan 19, 2023",
    //     ],
    //     result: [
    //       {
    //         name: "attendance",
    //         data: [
    //           "482",
    //           "631",
    //           "520",
    //           "570",
    //           "502",
    //           "182",
    //           "125",
    //           "449",
    //           "480",
    //           "467",
    //           "457",
    //           "468",
    //           "154",
    //           "127",
    //           "430",
    //           "460",
    //           "501",
    //           "479",
    //           "543",
    //         ],
    //       },
    //       {
    //         name: "late",
    //         data: [
    //           "339",
    //           "430",
    //           "379",
    //           "427",
    //           "356",
    //           "157",
    //           "116",
    //           "331",
    //           "353",
    //           "337",
    //           "335",
    //           "313",
    //           "127",
    //           "115",
    //           "309",
    //           "336",
    //           "351",
    //           "311",
    //           "293",
    //         ],
    //       },
    //       {
    //         name: "no_late",
    //         data: [
    //           "143",
    //           "201",
    //           "141",
    //           "143",
    //           "146",
    //           "25",
    //           "9",
    //           "118",
    //           "127",
    //           "130",
    //           "122",
    //           "155",
    //           "27",
    //           "12",
    //           "121",
    //           "124",
    //           "150",
    //           "168",
    //           "250",
    //         ],
    //       },
    //       {
    //         name: "early",
    //         data: [
    //           "49",
    //           "60",
    //           "42",
    //           "49",
    //           "48",
    //           "9",
    //           "2",
    //           "41",
    //           "38",
    //           "44",
    //           "36",
    //           "43",
    //           "6",
    //           "3",
    //           "39",
    //           "31",
    //           "42",
    //           "46",
    //           "50",
    //         ],
    //       },
    //     ],
    //   },
    //   pie: {
    //     attendance: {
    //       labels: [
    //         "Jan 1, 2023",
    //         "Jan 2, 2023",
    //         "Jan 3, 2023",
    //         "Jan 4, 2023",
    //         "Jan 5, 2023",
    //         "Jan 6, 2023",
    //         "Jan 7, 2023",
    //         "Jan 8, 2023",
    //         "Jan 9, 2023",
    //         "Jan 10, 2023",
    //         "Jan 11, 2023",
    //         "Jan 12, 2023",
    //         "Jan 13, 2023",
    //         "Jan 14, 2023",
    //         "Jan 15, 2023",
    //         "Jan 16, 2023",
    //         "Jan 17, 2023",
    //         "Jan 18, 2023",
    //         "Jan 19, 2023",
    //       ],
    //       result: [
    //         482, 631, 520, 570, 502, 182, 125, 449, 480, 467, 457, 468, 154,
    //         127, 430, 460, 501, 479, 543,
    //       ],
    //     },
    //     late: {
    //       labels: [
    //         "Jan 1, 2023",
    //         "Jan 2, 2023",
    //         "Jan 3, 2023",
    //         "Jan 4, 2023",
    //         "Jan 5, 2023",
    //         "Jan 6, 2023",
    //         "Jan 7, 2023",
    //         "Jan 8, 2023",
    //         "Jan 9, 2023",
    //         "Jan 10, 2023",
    //         "Jan 11, 2023",
    //         "Jan 12, 2023",
    //         "Jan 13, 2023",
    //         "Jan 14, 2023",
    //         "Jan 15, 2023",
    //         "Jan 16, 2023",
    //         "Jan 17, 2023",
    //         "Jan 18, 2023",
    //         "Jan 19, 2023",
    //       ],
    //       result: [
    //         339, 430, 379, 427, 356, 157, 116, 331, 353, 337, 335, 313, 127,
    //         115, 309, 336, 351, 311, 293,
    //       ],
    //     },
    //     no_late: {
    //       labels: [
    //         "Jan 1, 2023",
    //         "Jan 2, 2023",
    //         "Jan 3, 2023",
    //         "Jan 4, 2023",
    //         "Jan 5, 2023",
    //         "Jan 6, 2023",
    //         "Jan 7, 2023",
    //         "Jan 8, 2023",
    //         "Jan 9, 2023",
    //         "Jan 10, 2023",
    //         "Jan 11, 2023",
    //         "Jan 12, 2023",
    //         "Jan 13, 2023",
    //         "Jan 14, 2023",
    //         "Jan 15, 2023",
    //         "Jan 16, 2023",
    //         "Jan 17, 2023",
    //         "Jan 18, 2023",
    //         "Jan 19, 2023",
    //       ],
    //       result: [
    //         143, 201, 141, 143, 146, 25, 9, 118, 127, 130, 122, 155, 27, 12,
    //         121, 124, 150, 168, 250,
    //       ],
    //     },
    //     early: {
    //       labels: [
    //         "Jan 1, 2023",
    //         "Jan 2, 2023",
    //         "Jan 3, 2023",
    //         "Jan 4, 2023",
    //         "Jan 5, 2023",
    //         "Jan 6, 2023",
    //         "Jan 7, 2023",
    //         "Jan 8, 2023",
    //         "Jan 9, 2023",
    //         "Jan 10, 2023",
    //         "Jan 11, 2023",
    //         "Jan 12, 2023",
    //         "Jan 13, 2023",
    //         "Jan 14, 2023",
    //         "Jan 15, 2023",
    //         "Jan 16, 2023",
    //         "Jan 17, 2023",
    //         "Jan 18, 2023",
    //         "Jan 19, 2023",
    //       ],
    //       result: [
    //         49, 60, 42, 49, 48, 9, 2, 41, 38, 44, 36, 43, 6, 3, 39, 31, 42, 46,
    //         50,
    //       ],
    //     },
    //   },
    // };

    // this.loading = false;
    this.fetchChart(data)
      .then((res) => {
        this.loading = false;
        this.chartData = res;
      })
      .catch((err) => {
        this.loading = false;
      });
  },
  methods: {
    ...mapActions("statistics", ["fetchChart"]),
  },
};
</script>
