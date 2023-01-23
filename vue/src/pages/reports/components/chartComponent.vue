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
              :report="report"
              @filter="filter"
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
    filters: {
      type: Object,
      default: {},
    },
  },
  computed: {
    chartTypes() {
      return this.report.type;
    },
  },

  watch: {
    filters() {
      let data = {
        charts: this.report.type.map((item) => item.value),
        type: this.report.chart,
        ...this.filters,
      };
      const { filter_able } = this.report;
      if (!filter_able) {
        this.loading = true;
        this.fetchChart(data)
          .then((res) => {
            this.loading = false;
            this.chartData = res;
          })
          .catch((err) => {
            this.loading = false;
          });
      }
    },
  },

  mounted() {
    let data = {
      charts: this.report.type.map((item) => item.value),
      type: this.report.chart,
      ...this.filters,
    };

    this.loading = true;
    // this.loading = false;

    // this.chartData = {
    //   bar: {
    //     labels: [
    //       "المستشار ومساعد الرئيس للشؤون التطويرية النسائية",
    //       "مساعد الرئيس العام لمجمع الكسوة والشؤون الاثرائية",
    //       "المستشار ومساعد الرئيس العام للشؤون النسائية",
    //       " مكتب الرئيس العام",
    //       "مساعد الرئيس للشؤون الخدمية والفنية والميدانية",
    //       "مساعد الرئيس العام لشؤون المسجد الحرام",
    //       "مساعد الرئيس العام للحوكمة والشؤون التطويرية",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: ["2", "2", "6", "17", "5", "5", "1"],
    //       },
    //     ],
    //   },
    //   line: {
    //     labels: [
    //       "المستشار ومساعد الرئيس للشؤون التطويرية النسائية",
    //       "مساعد الرئيس العام لمجمع الكسوة والشؤون الاثرائية",
    //       "المستشار ومساعد الرئيس العام للشؤون النسائية",
    //       " مكتب الرئيس العام",
    //       "مساعد الرئيس للشؤون الخدمية والفنية والميدانية",
    //       "مساعد الرئيس العام لشؤون المسجد الحرام",
    //       "مساعد الرئيس العام للحوكمة والشؤون التطويرية",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: ["2", "2", "6", "17", "5", "5", "1"],
    //       },
    //     ],
    //   },
    //   pie: {
    //     labels: [
    //       "المستشار ومساعد الرئيس للشؤون التطويرية النسائية",
    //       "مساعد الرئيس العام لمجمع الكسوة والشؤون الاثرائية",
    //       "المستشار ومساعد الرئيس العام للشؤون النسائية",
    //       " مكتب الرئيس العام",
    //       "مساعد الرئيس للشؤون الخدمية والفنية والميدانية",
    //       "مساعد الرئيس العام لشؤون المسجد الحرام",
    //       "مساعد الرئيس العام للحوكمة والشؤون التطويرية",
    //     ],
    //     result: [2, 2, 6, 17, 5, 5, 1],
    //   },
    // };
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
    filter(data) {
      this.$emit("filter", data);
    },
  },
};
</script>
