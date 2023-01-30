<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("reports.showReport") }}
          </div>
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row>
      <v-col cols="12">
        <!-- <div class="title mb-2">
          {{ $t("reports.showReport") }}
        </div> -->
        <v-tabs
          v-model="tab"
          :show-arrows="false"
          background-color="transparent"
        >
          <v-tab to="#tabs-edit">{{ $t("editchart") }}</v-tab>
          <v-tab to="#tabs-show">{{ $t("showchart") }}</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <v-tab-item value="tabs-edit">
            <Edit />
          </v-tab-item>

          <v-tab-item value="tabs-show">
            <show />
          </v-tab-item>
        </v-tabs-items>

        <!--          <v-tabs color="deep-purple accent-4" >-->
        <!--              <v-tab>{{ $t("editchart") }}</v-tab>-->
        <!--              <v-tab>{{ $t("showchart") }}</v-tab>-->

        <!--              <v-tab-item :key="2">-->
        <!--                <Edit />-->
        <!--              </v-tab-item>-->
        <!--              <v-tab-item :key="1">-->
        <!--                <v-container fluid>-->
        <!--                  <v-row>-->
        <!--                    AAAA-->
        <!--                  </v-row>-->
        <!--                </v-container>-->
        <!--              </v-tab-item>-->
        <!--            </v-tabs>-->
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Edit from "./components/edit.vue";
import Show from "./components/show.vue";

export default {
  components: { Edit, Show },
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reportBuilder"),
          to: "/reports/report-builder",
          exact: true,
        },
        {
          text: this.$t("reports.showReport"),
          disabled: true,
          href: "#",
        },
      ],
      tab: null,
      chartData: [],
      chartAnalysis: {},
    };
  },
  mounted() {},
  methods: {},
};
</script>
<style scoped>
.vue-daterange-picker {
  margin: 0;
}

.v-sheet.v-card:not(.v-sheet--outlined) {
  box-shadow: none !important;
}

.reportrange-text {
  padding: 8px 10px !important;
}
</style>
