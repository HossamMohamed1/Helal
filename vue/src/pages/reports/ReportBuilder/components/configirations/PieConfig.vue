<template>
  <div class="aside-config" v-if="config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال Pie Chart</div>
      <v-spacer></v-spacer>
      <v-btn icon @click="$emit('closeDraw')">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>

    <v-divider></v-divider>

    <div class="pa-2">
      <div class="font-weight-bold mt-2 mb-1">Color Palette</div>
      <div class="color-palette d-flex">
        <input
          type="color"
          class="color"
          value="#5F4690"
          v-model="config.colors[index]"
          :key="index"
          v-for="(color, index) in config.colors"
        />
      </div>

      <div class="font-weight-bold mt-3 mb-1">Inner Radius</div>
      <legend>Radius</legend>
      <v-text-field
        solo
        type="number"
        v-model="config.innerRadius"
      ></v-text-field>

      <div class="font-weight-bold mt-3 mb-1">Stroke</div>
      <v-row>
        <v-col cols="6" class="pb-0">
          <legend>Width</legend>
          <v-text-field
            solo
            type="number"
            v-model="config.strokeWidth"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="pb-0">
          <legend>Color</legend>
          <input type="color" v-model="config.stroke">
        </v-col>
      </v-row>



      <v-row>
        <v-col cols="6" class="pb-0">
          <div class="font-weight-bold mt-3 mb-1">Align Labels</div>
          <v-btn-toggle
            v-model="config.alignLabels"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col cols="6" class="pb-0">
          <div class="font-weight-bold mt-3 mb-1">Hover Shadow</div>
          <v-btn-toggle
            v-model="config.hoverShadow"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col cols="6" class="pb-0">
          <div class="font-weight-bold mt-3 mb-1">Shadow Opacity</div>
          <v-text-field
            solo
            v-model="config.shadowOpacity"
          ></v-text-field>
        </v-col>
      </v-row>


      <div class="font-weight-bold mt-3 mb-1">Chart Title</div>
      <div>
        <legend>Title</legend>

        <v-text-field
          solo
          placeholder="Enter Chart Title"
          v-model="config.title.name"
        ></v-text-field>

        <v-row v-if="config.title.name">
          <v-col cols="6" class="pb-0">
            <legend>Font Size</legend>
           <v-text-field solo type="number" v-model="config.title.fontSize"></v-text-field>

            <legend>Font Weight</legend>
            <v-text-field solo v-model="config.title.fontWeight"></v-text-field>
          </v-col>
          <v-col cols="6" class="pb-0">
            <legend>Margin Bottom</legend>
            <v-text-field solo type="number" v-model="config.title.marginBottom"></v-text-field>

            <legend>Color</legend>
            <!--        <v-color-picker v-model="config.title.fill"></v-color-picker>-->
            <input type="color" v-model="config.title.fill">
          </v-col>
        </v-row>
      </div>

      <div class="font-weight-bold mt-3 mb-1">Chart Legend</div>
      <v-row >
          <v-col cols="6" class="pb-0">
          <legend>Legend</legend>
          <v-btn-toggle
            v-model="config.legend.disabled"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
          </v-col>
<!--          <v-col cols="6" class="pb-0">-->
<!--            <legend>Align</legend>-->
<!--            <v-btn-toggle-->
<!--              v-model="config.legend.align"-->
<!--              color="primary"-->
<!--              mandatory-->
<!--              class="mb-2"-->
<!--            >-->
<!--              <v-btn>right</v-btn>-->
<!--              <v-btn>center</v-btn>-->
<!--              <v-btn>left</v-btn>-->
<!--            </v-btn-toggle>-->
<!--          </v-col>-->
          <v-col cols="6" class="pb-0">
            <legend>Position</legend>
            <v-btn-toggle
              v-model="config.legend.position"
              color="primary"
              mandatory
              class="mb-2"
            >
              <v-btn>top</v-btn>
              <v-btn>bottom</v-btn>
            </v-btn-toggle>
          </v-col>
          <v-col cols="6" class="pb-0"><legend>Padding Bottom</legend>
            <v-text-field solo type="number" v-model="config.legend.paddingBottom"></v-text-field></v-col>
          <v-col cols="6" class="pb-0">

            <legend>Padding Top</legend>
            <v-text-field solo type="number" v-model="config.legend.paddingTop"></v-text-field>
          </v-col>
        </v-row>

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
