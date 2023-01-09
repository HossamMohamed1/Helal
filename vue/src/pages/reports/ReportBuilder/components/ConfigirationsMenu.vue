<template>
  <div>
    <v-btn
      ref="button"
      class="drawer-button"
      color="#ee44aa"
      dark
      @click="right = true"
    >
      <v-icon class="fa-spin">mdi-cog-outline</v-icon>
    </v-btn>

    <v-navigation-drawer
      v-model="right"
      fixed
      right
      hide-overlay
      temporary
      width="310"
    >
      <line-config />
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import LineConfig from "@/pages/reports/ReportBuilder/components/configirations/LineConfig";

export default {
  components: { LineConfig },
  data() {
    return {
      right: false,
    };
  },
};
</script>

<style lang="scss" scoped>
.drawer-button {
  position: fixed;
  top: 340px;
  right: -20px;
  z-index: 1;
  box-shadow: 1px 1px 18px #ee44aa;

  .v-icon {
    margin-left: -18px;
    font-size: 1.3rem;
  }
  input {
    border-color: #ddd;
  }
}
</style>
