<template>
  <div class="aside-config" v-if="config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال Bar Chart</div>
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

      <div class="font-weight-bold mt-2 mb-1">Columns</div>
      <legend>Column Width</legend>
      <v-text-field
        solo
        v-model="config.columnsWidth"
      ></v-text-field>
      <legend>Cell Start Location</legend>
      <v-text-field
        solo
        v-model="config.cellStartLocation"
      ></v-text-field>
      <legend>cell End Location</legend>
      <v-text-field
        solo
        v-model="config.cellEndLocation"
      ></v-text-field>

      <div class="font-weight-bold mt-2 mb-1">Labels</div>
      <legend>Labels</legend>
      <v-btn-toggle
        v-model="config.labels.disabled"
        color="primary"
        mandatory
        class="mb-2"
      >
        <v-btn>true</v-btn>
        <v-btn>false</v-btn>
      </v-btn-toggle>
      <div v-if="!config.labels.disabled">
<!--        <v-row>-->
<!--          <v-col cols="6">-->

<!--          </v-col>-->
<!--          <v-col cols="6">-->

<!--          </v-col>-->
<!--        </v-row>-->
        <v-row>
          <v-col cols="6">
            <legend>Font Size</legend>
            <v-text-field
              solo
              v-model="config.labels.fontSize"
            ></v-text-field>
            <legend>Width</legend>
            <v-text-field
              solo
              v-model="config.labels.width"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <legend>Rotation</legend>
            <v-text-field
              solo
              v-model="config.labels.rotation"
            ></v-text-field>
            <legend>Color</legend>
            <input
              type="color"
              v-model="config.labels.fill"
            ><input/>
          </v-col>
        </v-row>

      </div>

      <div class="font-weight-bold mt-3 mb-1">Axis Titles</div>
      <v-row>
        <v-col cols="6">
          <legend>X Title</legend>
          <v-text-field
            placeholder="Enter XAxis Title"
            solo
            v-model="config.xLabel.text"
          ></v-text-field>
        </v-col>
        <v-col cols="6">
          <legend>Y Title</legend>
          <v-text-field
            placeholder="Enter YAxis Title"
            solo
            v-model="config.yLabel"
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
          <v-col cols="6">
            <legend>Font Size</legend>
            <v-text-field solo v-model="config.title.fontSize"></v-text-field>

            <legend>Font Weight</legend>
            <v-text-field solo v-model="config.title.fontWeight"></v-text-field>
          </v-col>
          <v-col cols="6">
            <legend>Margin Bottom</legend>
            <v-text-field solo v-model="config.title.marginBottom"></v-text-field>

            <legend>Color</legend>
            <!--        <v-color-picker v-model="config.title.fill"></v-color-picker>-->
            <input type="color" v-model="config.title.fill">
          </v-col>
        </v-row>
      </div>

      <div class="font-weight-bold mt-3 mb-1">Zooming</div>
      <v-row v-if="config.zoom">
        <v-col cols="6">
          <legend>scrollbar X</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarX"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col cols="6">
          <legend>Position</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarXBottom"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>top</v-btn>
            <v-btn>bottom</v-btn>
          </v-btn-toggle>
        </v-col>
      </v-row>
      <v-row v-if="config.zoom">
        <v-col cols="6">
          <legend>scrollbar Y</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarY"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col cols="6">
          <legend>Position</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarYLeft"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>right</v-btn>
            <v-btn>left</v-btn>
          </v-btn-toggle>
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
        @click="editChart()"
      >
        {{ $t("general.save") }}
      </v-btn>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from "vuex";

export default {
  computed: {
    ...mapState("reports", ["chart"]),
    config() {
      return this.chart.config;
    }
  },
  data() {
    return { loading: false };
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
