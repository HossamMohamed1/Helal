<template>
  <v-col cols="12" lg="6">
    <v-card flat :loading="loading" height="355">
      <v-card-title class="d-flex align-center align-content-space-between">
        <div>{{ $t(report.title) }}</div>
      </v-card-title>
      <v-tabs v-model="tab" centered slider-color="yellow">
        <v-tab v-for="(type, i) in chartTypes" :key="i" :href="`#tab-${i}`">
          {{ type }}
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="(type, i) in chartTypes"
          :key="i"
          :value="`tab-${i}`"
        >
          <v-card flat>
            <mainChart :type="type" :chartData="chartData[type]" />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-col>
</template>

<script>
import { mapActions } from "vuex";
import mainChart from "./mainChart.vue";
export default {
  components: {
    mainChart,
  },
  data() {
    return {
      loading: false,
      chartData: {},
      tab: 0,
    };
  },
  props: {
    report: { type: Object, default: {} },
  },
  computed: {
    chartTypes() {
      return this.report.type;
    },
  },

  mounted() {
    let data = {
      charts: this.report.type,
      type: this.report.chart,
    };

    this.loading = true;
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
