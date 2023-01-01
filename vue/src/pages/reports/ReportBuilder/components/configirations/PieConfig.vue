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
