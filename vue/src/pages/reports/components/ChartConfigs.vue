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
        <div v-if="chartOptions.type == 'line'">
          <!--          <div>-->
          <!--            <div class="font-weight-bold mb-1">Line Dashed</div>-->
          <!--            <v-text-field-->
          <!--              solo-->
          <!--              type="number"-->
          <!--              v-model="config.stroke.dashArray"-->
          <!--            ></v-text-field>-->
          <!--          </div>-->

          <div class="row pt-4">
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Curve Type</div>
              <v-select
                :items="lineType"
                label="Curve"
                solo
                v-model="config.chart.type"
              ></v-select>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Chart inverted</div>
              <v-btn-toggle
                v-model="config.chart.inverted"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Invert</v-btn>
                <v-btn :value="false">Non Invert</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">xAxis inverted</div>
              <v-btn-toggle
                v-model="config.xAxis.reversed"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Invert</v-btn>
                <v-btn :value="false">Non Invert</v-btn>
              </v-btn-toggle>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Marker Shape</div>
              <v-select
                :items="lineMarkersShape"
                label="Curve"
                solo
                v-model="config.plotOptions.line.marker.symbol"
              ></v-select>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Marker Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.plotOptions.line.marker.radius"
              ></v-text-field>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Marker color</div>
              <input
                type="color"
                v-model="config.plotOptions.line.marker.fillColor"
              />
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Marker Stroke Width</div>
              <v-text-field
                solo
                type="number"
                v-model="config.plotOptions.line.marker.lineWidth"
              ></v-text-field>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Marker Stroke color</div>
              <input
                type="color"
                v-model="config.plotOptions.line.marker.lineColors"
              />
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-lg-8 py-0 d-flex align-center">
              <div class="font-weight-bold mb-1">xAxis Labels Rotation</div>
              <v-slider
                min="-90"
                max="90"
                thumb-label="always"
                v-model="config.xAxis.labels.rotation"
                class="mt-3"
              ></v-slider>
            </div>
            <div class="col-lg-8 py-0 d-flex align-center">
              <div class="font-weight-bold mb-1">YAxis Labels Rotation</div>
              <v-slider
                min="-90"
                max="90"
                thumb-label="always"
                v-model="config.yAxis.labels.rotation"
                class="mt-3"
              ></v-slider>
            </div>
          </div>
        </div>

        <!--for Bar -->
        <div v-else-if="chartOptions.type == 'bar'" class="pb-2">
          <div class="row pt-4">
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Chart Type</div>
              <v-select
                :items="barType"
                solo
                v-model="config.chart.type"
              ></v-select>
            </div>
            <div class="col-lg-3 py-0">
              <div class="font-weight-bold mb-1">Column Width</div>
              <v-text-field
                solo
                type="number"
                v-model="config.plotOptions.series.pointWidth"
              ></v-text-field>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">xAxis inverted</div>
              <v-btn-toggle
                v-model="config.xAxis.reversed"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Invert</v-btn>
                <v-btn :value="false">Non Invert</v-btn>
              </v-btn-toggle>
            </div>

            <!--            <div class="col-lg-3 py-0">-->
            <!--              <div class="font-weight-bold mb-1">Bar Radius</div>-->
            <!--              <v-text-field-->
            <!--                solo-->
            <!--                type="number"-->
            <!--                v-model="config.plotOptions.bar.borderRadius"-->
            <!--              ></v-text-field>-->
            <!--            </div>-->

            <!--            <div class="col-lg-3 py-0">-->
            <!--              <div class="font-weight-bold mb-1">Labels</div>-->
            <!--              <v-btn-toggle-->
            <!--                v-model="config.dataLabels.enabled"-->
            <!--                color="primary"-->
            <!--                mandatory-->
            <!--              >-->
            <!--                <v-btn :value="true">Show</v-btn>-->
            <!--                <v-btn :value="false">Hide</v-btn>-->
            <!--              </v-btn-toggle>-->
            <!--            </div>-->
            <!--            <div class="col-lg-3 py-0">-->
            <!--              <div class="font-weight-bold mb-1">Labels Position</div>-->
            <!--              <v-select-->
            <!--                :items="barDataLabels"-->
            <!--                solo-->
            <!--                v-model="config.plotOptions.bar.dataLabels.position"-->
            <!--              ></v-select>-->
            <!--            </div>-->
            <!--            <div class="col-lg-3 py-0">-->
            <!--              <div class="font-weight-bold mb-1">Labels Font Size</div>-->
            <!--              <v-text-field-->
            <!--                solo-->
            <!--                type="number"-->
            <!--                v-model="config.dataLabels.style.fontSize"-->
            <!--              ></v-text-field>-->
            <!--            </div>-->
            <!--            <div class="col-lg-3 py-0">-->
            <!--              <div class="font-weight-bold mb-1">Labels Color</div>-->
            <!--              <input-->
            <!--                solo-->
            <!--                type="color"-->
            <!--                v-for="(color, key) in config.dataLabels.style.colors"-->
            <!--                :key="color"-->
            <!--                v-model="config.dataLabels.style.colors[key]"-->
            <!--              />-->
            <!--            </div>-->
          </div>
          <div class="row pt-2">
            <div class="col-lg-8 py-0 d-flex align-center">
              <div class="font-weight-bold mb-1">xAxis Labels Rotation</div>
              <v-slider
                min="-90"
                max="90"
                thumb-label="always"
                v-model="config.xAxis.labels.rotation"
                class="mt-3"
              ></v-slider>
            </div>
            <div class="col-lg-8 py-0 d-flex align-center">
              <div class="font-weight-bold mb-1">YAxis Labels Rotation</div>
              <v-slider
                min="-90"
                max="90"
                thumb-label="always"
                v-model="config.yAxis.labels.rotation"
                class="mt-3"
              ></v-slider>
            </div>
          </div>
        </div>

        <!--for bie or donut -->
        <div v-else class="pb-2">
          <div class="row pt-3">
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Chart Type</div>
              <v-select
                :items="pieType"
                solo
                v-model="config.chart.type"
              ></v-select>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Inner Radius</div>
              <v-text-field
                solo
                type="text"
                v-model="config.series.innerSize"
              ></v-text-field>
            </div>
          </div>
          <div class="row pt-2">
            <div
              class="col-lg-4 py-0"
              v-if="config.plotOptions && config.plotOptions.pie"
            >
              <div class="font-weight-bold mb-1">Legend</div>
              <v-btn-toggle
                v-model="config.plotOptions.pie.showInLegend"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
            <div
              v-if="config.plotOptions && config.plotOptions.pie"
              class="col-lg-4 py-0"
            >
              <div class="font-weight-bold mb-1">Labels</div>
              <v-btn-toggle
                v-model="config.plotOptions.pie.dataLabels.enabled"
                color="primary"
                mandatory
              >
                <v-btn :value="true">Show</v-btn>
                <v-btn :value="false">Hide</v-btn>
              </v-btn-toggle>
            </div>
          </div>
          <div class="row pt-5">
            <div
              v-if="config.plotOptions && config.plotOptions.pie"
              class="col-lg-4 py-0"
            >
              <div class="font-weight-bold mb-1">Stroke Size</div>
              <v-text-field
                solo
                type="number"
                v-model="config.plotOptions.pie.borderWidth"
              ></v-text-field>
            </div>
            <div class="col-lg-4 py-0">
              <div class="font-weight-bold mb-1">Stroke Color</div>
              <input
                solo
                type="color"
                v-model="config.plotOptions.pie.borderColor"
              />
            </div>
          </div>
        </div>
      </div>
      <v-card-actions>
        <v-btn color="primary" @click="applyConfig">
          {{ $t("common.save") }}
        </v-btn>
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
      lineType: ["line", "spline", "area"],
      lineMarkersShape: [
        "circle",
        "square",
        "triangle",
        "triangle-down",
        "diamond",
      ],
      barType: ["bar", "column"],
      barDataLabels: ["top", "center", "bottom"],
      pieType: ["pie", "variablepie"],
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
      // this.dialog = false
    },
  },
};
</script>
