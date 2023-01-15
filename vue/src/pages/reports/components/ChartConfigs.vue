<template>
  <v-dialog
    transition="dialog-bottom-transition"
    max-width="600"
    v-model="open"
  >
    <v-card>
      <v-card-text>
        {{ JSON.stringify(chartOptions) }}
      </v-card-text>
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
  },
};
</script>
