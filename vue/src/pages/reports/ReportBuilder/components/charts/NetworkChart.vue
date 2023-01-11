<template>
  <v-card
    :style="{ background: backgroundStyle.backgroundColor }"
    :loading="loading"
    flat
  >
    <network
      ref="network"
      :nodes="nodes"
      :edges="edges"
      :options="options"
      style="height: 600px"
    />
  </v-card>
</template>
<script>
// import "vue-vis-network/dist/vueVisNetwork.css";

import { mapActions, mapState } from "vuex";

export default {
  components: {},
  props: {
    config: {},
  },
  data() {
    return {
      loading: false,
      backgroundStyle: { backgroundColor: "" },
      chartObject: null,
      nodes: [],
      edges: [],
      options: {
        configure: {
          enabled: false,
        },
        edges: {
          color: {
            inherit: true,
          },
          // inherit_colors: false,
          smooth: {
            enabled: true,
            type: "cubicBezier",
            roundness: 0.3,
          },
        },
        interaction: {
          dragNodes: true,
          hideEdgesOnDrag: true,
          hideNodesOnDrag: false,
          multiselect: true,
          keyboard: true,
          zoomView: true,
          navigationButtons: true,
        },
        manipulation: false,
        physics: {
          enabled: true,
          repulsion: {
            centralGravity: 0.2,
            damping: 0.09,
            nodeDistance: 330.0,
            springConstant: 0.01848,
            springLength: 200,
          },
          solver: "repulsion",
          stabilization: {
            enabled: true,
            fit: true,
            iterations: 1000,
            onlyDynamicEdges: true,
            updateInterval: 50,
          },
        },
      },
    };
  },
  destroyed() {
    if (this.chartObject) {
      this.chartObject.dispose();
    }
  },
  watch: {
    fileData() {
      let { id } = this.chart;
      this.loading = true;
      this.loadAnalytics(id)
        .then(() => {
          this.loading = false;
          this.loadChart();
        })
        .catch(() => {
          this.loading = false;
        });
    },
    chart() {
      let { id } = this.chart;
      this.loading = true;
      this.loadAnalytics(id)
        .then(() => {
          this.loading = false;
          this.loadChart();
        })
        .catch((err) => {
          console.log(err);
          this.loading = false;
        });
    },
  },
  computed: {
    ...mapState("reports", ["analytics", "chart", "fileData"]),
  },
  methods: {
    ...mapActions("reports", ["loadAnalytics"]),
    loadChart() {
      console.log(this.chart.config);
      this.nodes = this.analytics?.nodes ?? [];
      this.edges = this.analytics?.edges ?? [];
      const { config } = this.chart;
      this.nodes = this.nodes.map((item) => {
        return {
          ...item,
          font: { color: config?.font?.color ?? "red" },
        };
      });

      // Background Color

      this.backgroundStyle.backgroundColor = config?.style?.backgroundColor;
      this.options.interaction.dragNodes =
        config?.interaction?.dragNodes == "true" ||
        config?.interaction?.dragNodes == true;

      // Background Color
      // InterActions
      this.options.interaction.hideEdgesOnDrag =
        config?.interaction?.hideEdgesOnDrag == "true" ||
        config?.interaction?.hideEdgesOnDrag == true;
      this.options.interaction.hideNodesOnDrag =
        config?.interaction?.hideNodesOnDrag == "true" ||
        config?.interaction?.hideNodesOnDrag == true;
      this.options.interaction.navigationButtons =
        config?.interaction?.navigationButtons == 0;

      this.options.physics.repulsion.nodeDistance = parseInt(
        config?.physics?.repulsion?.nodeDistance
      );
      this.options.physics.repulsion.centralGravity = parseFloat(
        config?.physics?.repulsion?.centralGravity
      );
      // config.smooth.type
      // if (config?.edges?.smooth?.type == true)
      // {
      //   this.options.edges.smooth.type = "cubicBezier"
      // }
      // else {
      //   this.options.edges.smooth.type = "dynamic"
      // }
    },
  },
  mounted() {
    const { id } = this.chart;
    this.loadAnalytics(id)
      .then(() => {
        this.loading = false;
        this.loadChart();
      })
      .catch((err) => {
        console.log(err);
        this.loading = false;
      });
  },
};
</script>
