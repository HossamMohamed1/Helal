<template>
  <v-dialog
    transition="dialog-bottom-transition"
    max-width="600"
    v-model="open"
  >
    <v-toolbar>
      {{ $t("general.setting") }} {{ $t(title) }} ({{ type.text }})
    </v-toolbar>
    <v-card flat>
      <div class="pa-2">
        <div class="font-weight-bold mb-1">Color Palette</div>
        <div class="color-palette d-flex mb-2">
          <input
            type="color"
            class="color"
            value="#5F4690"
            v-model="config.colors[index]"
            :key="index"
            v-for="(color, index) in config.colors"
          />
        </div>

        <!--for line -->
        <div v-if="chartOptions.chart.type == 'line'">
          <div>
            <div class="font-weight-bold mb-1">Curve Type</div>
            <v-select
              :items="lineCurve"
              label="Curve"
              solo
              v-model="config.stroke.curve"
            ></v-select>
          </div>

          <div>
            <div class="font-weight-bold mb-1">Line Dashed</div>
            <v-text-field
              solo
              type="number"
              v-model="config.stroke.dashArray"
            ></v-text-field>
          </div>

          <div>
            <div class="font-weight-bold mb-1">Markers Size</div>
            <v-text-field
              solo
              type="number"
              v-model="config.markers.size"
            ></v-text-field>
          </div>

          <div>
            <div class="font-weight-bold mb-1">Markers Shape</div>
            <v-select
              :items="lineMarkersShape"
              label="Curve"
              solo
              v-model="config.markers.shape"
            ></v-select>
          </div>
        </div>

        <!--for Bar -->
        <div v-else-if="chartOptions.chart.type == 'bar'" class="pb-2">
          <div class="row pt-3">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Column Width</div>
              <v-text-field
                solo
                type="text"
                v-model="config.plotOptions.bar.columnWidth"
              ></v-text-field>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Bar Radius</div>
              <v-text-field
                solo
                type="number"
                v-model="config.plotOptions.bar.borderRadius"
              ></v-text-field>
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels</div>
              <v-btn-toggle
                v-model="config.dataLabels.enabled"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels Position</div>
              <v-select
                :items="barDataLabels"
                solo
                v-model="config.plotOptions.bar.dataLabels.position"
              ></v-select>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels Font Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.dataLabels.style.fontSize"
              ></v-text-field>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels Color</div>
              <input
                solo
                type="color"
                v-for="(color, key) in config.dataLabels.style.colors"
                :key="color"
                v-model="config.dataLabels.style.colors[key]"
              />
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke</div>
              <v-btn-toggle
                v-model="config.stroke.show"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.stroke.width"
              ></v-text-field>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke Color</div>
              <input
                v-for="(color, index) in config.stroke.colors"
                :key="color"
                solo
                type="color"
                v-model="config.stroke.colors[index]"
              />
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Horizontal</div>
              <v-btn-toggle
                v-model="config.plotOptions.bar.horizontal"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-3 pt-0">
              <div class="font-weight-bold mb-1">Y Axis</div>
              <v-btn-toggle
                v-model="config.yaxis.reversed"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
          </div>
        </div>

        <!--for bie or donut -->
        <div v-else class="pb-2">
          <div class="row pt-3">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels</div>
              <v-btn-toggle
                v-model="config.dataLabels.enabled"
                color="primary"
                mandatory
              >
                <v-btn>Show</v-btn>
                <v-btn>Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels Font Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.dataLabels.style.fontSize"
              ></v-text-field>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Labels Color</div>
              <input
                solo
                type="color"
                v-model="config.dataLabels.style.colors"
              />
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke</div>
              <v-btn-toggle
                v-model="config.stroke.show"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false"> Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.stroke.width"
              ></v-text-field>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Stroke Color</div>
              <input solo type="color" v-model="config.stroke.colors" />
            </div>
          </div>
        </div>
      </div>
      <v-card-actions>
        <v-btn color="primary" @click="applyConfig">Apply</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: {
    dialog: {
      type: Boolean,
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
    chartOptions: {
      type: Object,
      required: true,
    },
    title: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      lineCurve: ["smooth", "straight", "stepline"],
      lineMarkersShape: ["circle", "square", "rect"],
      barDataLabels: ["top", "center", "bottom"],
    };
  },
  mounted() {},
  computed: {
    open: {
      get() {
        return this.dialog;
      },
      set(val) {
        this.$emit("close-modal", val);
      },
    },
    config: {
      get() {
        return this.chartOptions;
      },
    },
  },
  methods: {
    applyConfig() {
      this.$emit("applyConfig", this.config);
      // console.log(this.config);
    },
  },
};
</script>
