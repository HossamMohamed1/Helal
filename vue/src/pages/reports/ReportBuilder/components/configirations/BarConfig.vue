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
      <div class="font-weight-bold mt-2 mb-1">
        Color Palette
      </div>
      <div class="color-palette d-flex">
        <!-- {{ config }} -->
        <input
          type="color"
          v-for="(item, index) in config.colors"
          v-model="config.colors[index]"
          :key="index"
          class="color"
        />
      </div>

      <div class="font-weight-bold mt-3 mb-1">Axis Titles</div>
      <div>
        <v-text-field
          v-if="config && config.xLabel"
          v-model="config.xLabel.title"
          label="X Title"
          outlined
        ></v-text-field>
        <v-text-field
          v-model="config.yLabel"
          label="Y Title"
          outlined
        ></v-text-field>
      </div>

      <div class="font-weight-bold mt-3 mb-1">Chart Title</div>
      <div>
        <v-text-field
          v-model="config.title.name"
          label="Title"
          outlined
        ></v-text-field>
        <v-text-field
          v-model="config.title.fontSize"
          label="Font Size"
          outlined
        ></v-text-field>
        <v-text-field
          v-model="config.title.fontWeight"
          label="Font Weight"
          outlined
        ></v-text-field>
        <v-color-picker v-model="config.style.backgroundColor"></v-color-picker>
      </div>
    </div>

    <v-divider></v-divider>
    <div class="text-center" color="success">
      <v-btn
        :loading="loading"
        :disabled="loading"
        color="primary"
        type="submit"
      >
        {{ $t("general.save") }}
      </v-btn>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState("reports", ["chart"]),
    config() {
      return this.chart.config;
    }
  },
  data() {
    return { loading: false };
  }
};
</script>
