<template>
  <v-card
    class="d-flex flex-column flex-grow-1"
    :style="{ 'min-height': '115px' }"
    :loading="loading"
  >
    <div v-if="loading" class="d-flex flex-grow-1 align-center justify-center">
      <v-progress-circular indeterminate color="primary"></v-progress-circular>
    </div>
    <div v-else class="d-flex flex-column flex-grow-1">
      <v-card-title>
        {{ label }}
      </v-card-title>

      <div class="d-flex flex-column flex-grow-1">
        <div class="px-2 pb-2">
          <div class="d-flex align-center">
            <div class="text-h4">{{ value }}</div>
            <v-spacer></v-spacer>
          </div>
        </div>
      </div>
    </div>
  </v-card>
</template>

<script>
import moment from "moment";
import TrendPercent from "../common/TrendPercent";

function formatDate(date) {
  return date ? moment(date).format("D MMM") : "";
}

/*
|---------------------------------------------------------------------
| DEMO Dashboard Card Component
|---------------------------------------------------------------------
|
| Demo card component to be used to gather some ideas on how to build
| your own dashboard component
|
*/
export default {
  components: {
    TrendPercent,
  },
  props: {
    label: {
      type: String,
      default: "",
    },
    color: {
      type: String,
      default: "#333333",
    },
    value: {
      type: Number,
      default: 0,
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  computed: {},
};
</script>
