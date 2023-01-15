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
      </div>
      <!-- <v-card-text>
        {{ JSON.stringify(chartOptions) }}
      </v-card-text> -->
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
      set(val) {
        console.log(val);
      },
    },
  },
};
</script>
