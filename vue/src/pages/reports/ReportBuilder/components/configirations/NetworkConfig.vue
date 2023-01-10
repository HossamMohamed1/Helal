<template>
  <div class="aside-config" v-if="config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال Network Chart</div>
      <v-spacer></v-spacer>
      <v-btn icon @click="$emit('closeDraw')">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>

    <v-divider></v-divider>

    <div class="pa-2">

      <div class="font-weight-bold mt-3 mb-1">Node Distance</div>
      <v-row>
        <v-col class="col-6 pb-0">
          <legend>Space Between Nodes</legend>
          <v-text-field
            placeholder="Enter XAxis Title"
            solo
            type="number"
            v-model="config.physics.repulsion.nodeDistance"
          ></v-text-field>
        </v-col>
        <v-col class="col-6 pb-0">
          <legend>Nodes central Gravity</legend>
          <v-text-field
            solo
            v-model="config.physics.repulsion.centralGravity"
          ></v-text-field>
        </v-col>
      </v-row>


      <div class="font-weight-bold mt-3 mb-1">Nodes Interaction</div>
      <v-row>
        <v-col class="col-6 pb-0">
          <legend>Drag Nodes</legend>
          <v-btn-toggle
            v-model="config.interaction.dragNodes"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>Active</v-btn>
            <v-btn>In Active</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col class="col-6 pb-0">
          <legend>Nodes On Drag</legend>
          <v-btn-toggle
            v-model="config.interaction.hideNodesOnDrag"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>Show</v-btn>
            <v-btn>Hide</v-btn>
          </v-btn-toggle>
        </v-col>
      </v-row>

      <div class="font-weight-bold mt-3 mb-1">Links</div>
      <v-row>
        <v-col class="col-12 pb-0">
          <legend>Type</legend>
          <v-btn-toggle
            v-model="config.edges.smooth.type"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>One Direction</v-btn> <!--cubicBezier-->
            <v-btn>Tow Direction</v-btn> <!--dynamic-->
          </v-btn-toggle>
        </v-col>
        <v-col class="col-12 pb-0">
          <legend>Links On Drag</legend>
          <v-btn-toggle
            v-model="config.interaction.hideEdgesOnDrag"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>Active</v-btn>
            <v-btn>In Active</v-btn>
          </v-btn-toggle>
        </v-col>

      </v-row>

      <div class="font-weight-bold mt-3 mb-1">Navigation Buttons</div>
      <v-row>
        <v-col class="col-12 pb-0">
<!--          <legend></legend>-->
          <v-btn-toggle
            v-model="config.interaction.navigationButtons"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>Show</v-btn>
            <v-btn>Hide</v-btn>
          </v-btn-toggle>
        </v-col>
      </v-row>

      <div class="font-weight-bold mt-3 mb-1">Font Style</div>
      <input type="color" v-model="config.color">

      <div class="font-weight-bold mt-3 mb-1">Chart background</div>
      <input type="color" v-model="config.style.backgroundColor">


    </div>

    <v-divider></v-divider>
    <div class="text-center pt-2">
      <v-btn
        :loading="loading"
        :disabled="loading"
        color="primary"
        type="submit"
        @click="editChart"
      >
        {{ $t("general.save") }}
      </v-btn>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      loading: false
    };
  },
  computed: {
    ...mapState("reports", ["chart"]),
    config() {
      return this.chart.config;
    }
  },
  methods: {
    ...mapActions("reports", ["updateChart"]),

    editChart() {
      const data = {
        ...this.chart,
        config: this.config,
        _method: "PUT"
      };
      this.loading = true;
      this.updateChart(data)
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
