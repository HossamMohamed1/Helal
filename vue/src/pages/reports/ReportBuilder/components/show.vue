<template>
  <div>
    <v-card :loading="loading" class="pa-2 mt-2">
      <v-row class="pt-2">
        <v-col>
          <!--pass config or data-->

          <LineChart v-if="chart.type == 'Line'" :config="config" />
          <bar-chart v-else-if="chart.type == 'Bar'" :config="config" />
          <pie-chart v-else-if="chart.type == 'Pie'" :config="config" />
          <x-y-bubble-chart v-else-if="chart.type == 'X Y Bubble'" :config="config"/>
        </v-col>
      </v-row>
    </v-card>

    <div>
      <v-btn
        ref="button"
        class="drawer-button"
        color="#1e8e49"
        dark
        @click="right = true"
      >
        <v-icon class="fa-spin">mdi-cog-outline</v-icon>
      </v-btn>

      <v-navigation-drawer
        v-model="right"
        fixed
        right
        hide-overlay
        temporary
        width="310"
      >
        <line-config
          v-if="chart.type && chart.type == 'Line'"
          :config="config"
          @closeDraw="right = false"
        />
        <bar-config
          v-else-if="chart.type == 'Bar'"
          :config="config"
          @closeDraw="right = false"
        />

        <pie-config
          v-else-if="chart.type == 'Pie'"
          :config="config"
          @closeDraw="right = false"/>
        <x-y-bubble-config
          v-else-if="chart.type == 'X Y Bubble'"
          :config="config"
          @closeDraw="right = false"/>

      </v-navigation-drawer>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from "vuex";

import LineChart from "@/pages/reports/ReportBuilder/components/charts/LineChart";
import BarChart from "@/pages/reports/ReportBuilder/components/charts/BarChart";
import LineConfig from "@/pages/reports/ReportBuilder/components/configirations/LineConfig";
import BarConfig from "@/pages/reports/ReportBuilder/components/configirations/BarConfig";
import PieConfig from "@/pages/reports/ReportBuilder/components/configirations/PieConfig";
import XYBubbleConfig from "@/pages/reports/ReportBuilder/components/configirations/XYBubbleConfig";
import XYBubbleChart from "@/pages/reports/ReportBuilder/components/charts/XYBubbleChart";
export default {
  components: {XYBubbleChart, XYBubbleConfig, PieConfig, BarConfig, LineConfig, BarChart, LineChart },
  data() {
    return {
      loading: false,
      right: false // Config aside
      // c/haramain.test/onfig: []
    };
  },
  created() {
    this.loadData();
  },
  watch: {},
  computed: {
    ...mapState("reports", ["chart"]),
    config() {
      return this.chart.config;
    }
  },
  methods: {
    ...mapActions("reports", ["getChart"]),
    loadData() {
      const { id } = this.$route.params;
      this.loading = true;
      this.getChart(id)
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.drawer-button {
  position: absolute;
  top: 15px;
  left: 15px;
  z-index: 6;
  //box-shadow: 1px 1px 18px #1e8e49;

  .v-icon {
    font-size: 1.3rem;
  }
  input {
    border-color: #ddd;
  }
}
// config aside
</style>
