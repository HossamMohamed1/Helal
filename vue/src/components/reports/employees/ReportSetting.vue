<template>
  <v-row justify="center">
    <!-- <v-btn
      ref="button"
      class="drawer-button"
      @click.stop="setting = true"
      color="#1e8e49"
      small
      dark
    >
      <v-icon>mdi-cog-outline</v-icon>
    </v-btn> -->
    <v-dialog v-model="setting" persistent>
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ $t("general.controlSetting") }} </span>
          <v-spacer></v-spacer>
          <v-btn color="dark" icon @click="setting = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-tabs v-model="tab" centered>
          <!-- <v-tabs-slider></v-tabs-slider> -->
          <v-tab v-for="(item, index) in chartOptions" :href="`#${index}`">
            {{ index }}
          </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item v-for="(item, index) in chartOptions" :value="`${index}`">
            <v-card flat>
              <v-card-text>{{ tab }} </v-card-text>
            </v-card>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data() {
    return {
      setting: false,
      tab: null,
    };
  },
  computed: {
    chartOptions() {
      let options = this.$store.state?.statistics?.chartOptions ?? {};

      return options;
    },
  },
};
</script>
<style lang="scss" scoped>
.drawer-button {
  position: fixed;
  top: 50vh;
  z-index: 1;
  margin: 5px;
  justify-content: center;
  .v-icon {
    display: flex;
    font-size: 1.3rem;
  }
}
</style>
