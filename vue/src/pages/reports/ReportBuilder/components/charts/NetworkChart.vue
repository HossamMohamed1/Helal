<template>
  <v-card
    :style="{ background: backgroundStyle.backgroundColor }"
    :loading="loading"
    flat
  >
    <network ref="network"
             :nodes="nodes"
             :edges="edges"
             :options="options"
             style="height: 550px"
    />
    <div>

    </div>
  </v-card>
</template>
<script>
// import "vue-vis-network/dist/vueVisNetwork.css";

import {mapActions, mapState} from "vuex";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";

export default {
  components: {},
  props: {
    config: {},
  },
  data() {
    return {
      loading: false,
      backgroundStyle: {backgroundColor: ""},
      chartObject: null,
      nodes: [
        {id: 1, label: 'circle', shape: 'circle'},
        {id: 2, label: 'ellipse', shape: 'ellipse'},
        {id: 3, label: 'database', shape: 'database'},
        {id: 4, label: 'box', shape: 'box'},
        {id: 5, label: 'diamond', shape: 'diamond'},
        {id: 6, label: 'dot', shape: 'dot'},
        {id: 7, label: 'square', shape: 'square'},
        {id: 8, label: 'triangle', shape: 'triangle'},
      ],
      edges: [
        {from: 1, to: 2},
        {from: 2, to: 3},
        {from: 2, to: 4},
        {from: 2, to: 5},
        {from: 5, to: 6},
        {from: 5, to: 7},
        {from: 6, to: 8}
      ],
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
            onlyDynamicEdges: false,
            updateInterval: 50,
          },
        },
      }
    }
  },
  destroyed() {
    if (this.chartObject) {
      this.chartObject.dispose();
    }
  },
  watch: {
    fileData() {
      let {id} = this.chart;
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
      let {id} = this.chart;
      this.loading = true;
      this.loadAnalytics(id)
        .then(() => {
          this.loading = false;
          this.loadChart();
        })
        .catch(err => {
          console.log(err);
          this.loading = false;
        });
    }
  },
  computed: {
    ...mapState("reports", ["analytics", "chart", "fileData"])
  },
  methods: {
    ...mapActions("reports", ["loadAnalytics"]),
    loadChart() {
      if (this.chartObject) {
        this.chartObject.dispose();
      }


      this.nodes = line.map(item => {
        let keys = Object.keys(item);
        keys = keys.filter(item => item != "date");

        for (let index = 0; index < keys.length; index++) {
          const key = keys[index];
          item[key] = item[key];
        }
        return item;
      });
      const {config} = this.chart;


      // Label Font
      this.nodes = this.nodes.map((item) => {
        return {
          ...item,
          font: {color: config?.font?.color ?? "red"},
        };
      });

      // this.nodes.map((node) => (node.font.color = config?.font?.color));

      // Background Color
      this.backgroundStyle.backgroundColor =
        config?.style?.backgroundColor;

      //InterActions
      this.options.interaction.dragNodes =
        config?.interaction?.dragNodes == "true" ||
        config?.interaction?.dragNodes == true;
      this.options.interaction.hideEdgesOnDrag =
        config?.interaction?.hideEdgesOnDrag == "true" ||
        config?.interaction?.hideEdgesOnDrag == true;
      this.options.interaction.hideNodesOnDrag =
        config?.interaction?.hideNodesOnDrag == "true" ||
        config?.interaction?.hideNodesOnDrag == true;
      this.options.interaction.navigationButtons =
        config?.interaction?.navigationButtons == "true" ||
        config?.interaction?.navigationButtons == true;
        //
      this.options.physics.repulsion.nodeDistance = parseInt(
        config?.physics?.repulsion?.nodeDistance
      );
      this.options.physics.repulsion.centralGravity = parseFloat(
        config?.physics?.repulsion?.centralGravity
      );

      //config.smooth.type
      this.options.edges.smooth.type = config?.edges?.smooth?.type;


    }
  },
  mounted() {
    const {id} = this.chart;
    this.loadAnalytics(id)
      .then(() => {
        this.loading = false;
        this.loadChart();
      })
      .catch(() => {
        this.loading = false;
      });
  }
};
</script>
