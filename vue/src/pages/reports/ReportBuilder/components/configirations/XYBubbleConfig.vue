<template>
  <div class="aside-config" v-if="config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال X Y Bubble Chart</div>
      <v-spacer></v-spacer>
      <v-btn icon @click="$emit('closeDraw')">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>

    <v-divider></v-divider>

    <div class="pa-2">
      <div class="font-weight-bold mt-3 mb-1">Bubbles On Hover</div>
      <v-row>
        <v-col cols="6" class="pb-0">
          <legend>Strok Width</legend>
          <v-text-field
            type="number"
            solo
            v-model="config.bullets.strokeWidth"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="pb-0">
          <legend>Stroke Fill</legend>
          <input type="color" v-model="config.bullets.fill">
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="6" class="pb-0">
          <legend>Stroke Opacity</legend>
          <v-text-field
            solo
            v-model="config.bullets.strokeOpacity"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="pb-0">
          <legend>Fill Opacity</legend>
          <v-text-field
            solo
            v-model="config.bullets.fillOpacity"
          ></v-text-field>
        </v-col>
      </v-row>
      <div class="font-weight-bold mt-3 mb-1">Axis Titles</div>
      <v-row>
        <v-col cols="6" class="pb-0">
          <legend>X Title</legend>
          <v-text-field
            placeholder="Enter XAxis Title"
            solo
            v-model="config.xLabel.text"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="pb-0">
          <legend>Y Title</legend>
          <v-text-field
            placeholder="Enter YAxis Title"
            solo
            v-model="config.yLabel.text"
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


<!--      <div class="font-weight-bold mt-3 mb-1">Zooming</div>-->
<!--      <v-row v-if="config.zoom">-->
<!--        <v-col cols="6" class="pb-0">-->
<!--          <legend>scrollbar X</legend>-->
<!--          <v-btn-toggle-->
<!--            v-model="config.zoom.scrollbarX"-->
<!--            color="primary"-->
<!--            mandatory-->
<!--            class="mb-2"-->
<!--          >-->
<!--            <v-btn>true</v-btn>-->
<!--            <v-btn>false</v-btn>-->
<!--          </v-btn-toggle>-->
<!--        </v-col>-->
<!--        <v-col cols="6" class="pb-0">-->
<!--          <legend>Position</legend>-->
<!--          <v-btn-toggle-->
<!--            v-model="config.zoom.scrollbarXBottom"-->
<!--            color="primary"-->
<!--            mandatory-->
<!--            class="mb-2"-->
<!--          >-->
<!--            <v-btn>top</v-btn>-->
<!--            <v-btn>bottom</v-btn>-->
<!--          </v-btn-toggle>-->
<!--        </v-col>-->
<!--      </v-row>-->
<!--      <v-row v-if="config.zoom">-->
<!--        <v-col cols="6" class="pb-0">-->
<!--          <legend>scrollbar Y</legend>-->
<!--          <v-btn-toggle-->
<!--            v-model="config.zoom.scrollbarY"-->
<!--            color="primary"-->
<!--            mandatory-->
<!--            class="mb-2"-->
<!--          >-->
<!--            <v-btn>true</v-btn>-->
<!--            <v-btn>false</v-btn>-->
<!--          </v-btn-toggle>-->
<!--        </v-col>-->
<!--        <v-col cols="6" class="pb-0">-->
<!--          <legend>Position</legend>-->
<!--          <v-btn-toggle-->
<!--            v-model="config.zoom.scrollbarYLeft"-->
<!--            color="primary"-->
<!--            mandatory-->
<!--            class="mb-2"-->
<!--          >-->
<!--            <v-btn>right</v-btn>-->
<!--            <v-btn>left</v-btn>-->
<!--          </v-btn-toggle>-->
<!--        </v-col>-->
<!--      </v-row>-->

     <v-row>
       <v-col cols="6">
         <div class="font-weight-bold mt-3 mb-1">Font Size</div>
         <v-text-field
           type="number"
           solo
           v-model="config.fontSize"
         ></v-text-field>
       </v-col>
       <v-col cols="6">
         <div class="font-weight-bold mt-3 mb-1">Chart background</div>
         <input type="color" v-model="config.style.backgroundColor">
       </v-col>
     </v-row>


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
import {mapState, mapActions} from "vuex";

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
