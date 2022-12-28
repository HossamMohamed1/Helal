<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("menu.reportBuilder") }}
          </div>
          <small class="mx-1">({{ $t("dashboard.thismonth") }})</small>
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row>
      <v-col cols="12">
        <v-card class="pa-2">
          <div class="title mb-2">
            {{ $t("reports.createReport") }}
          </div>
          <v-form>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  value=""
                  v-model="report.name"
                  :label="$t('reports.reportName')"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  :items="types"
                  :label="$t('reports.reportType')"
                  v-model="report.type"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-file-input
                  truncate-length="15"
                  :label="$t('reports.uploadFile')"
                  v-model="report.file"
                ></v-file-input>
              </v-col>
            </v-row>
            <div class="d-flex mt-3">
              <v-btn color="primary">{{ $t("general.save") }}</v-btn>
              <!-- to="/reports/report-builder" -->
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reportBuilder"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("menu.reportBuilder"),
          to: "/reports/report-builder",
          exact: true
        }
      ],

      types: ["Network", "BarChart", "Line", "X Y Bubble", " Pie"],
      report: {
        name: null,
        type: undefined,
        file: null
      }
    };
  }
};
</script>
<style>
.vue-daterange-picker {
  margin: 0;
}

.reportrange-text {
  padding: 8px 10px !important;
}
</style>
