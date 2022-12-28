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
          <v-form @submit.prevent="createReport" enctype="multipart/form-data">
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field value="" v-model="report.name" :error-messages="validationError['name']"
                              :label="$t('reports.reportName')" required></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-select :items="types" :label="$t('reports.reportType')" v-model="report.type"
                          :error-messages="validationError['type']"></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-file-input truncate-length="15" :label="$t('reports.uploadFile')"
                              :error-messages="validationError['file']" v-model="report.file"></v-file-input>
              </v-col>
            </v-row>
            <div class="d-flex mt-3">
              <v-btn color="primary" type="submit">{{ $t("general.save") }}
              </v-btn>
              <!-- to="/reports/report-builder" -->
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import axios from "axios";

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

      types: ["Network", "Bar", "Line", "X Y Bubble", " Pie"],
      report: {
        name: null,
        type: undefined,
        file: undefined
      },
      validationError: []
    };
  },
  methods: {
    async createReport() {
      try {
        this.$axios
          .post("charts/create", this.report, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            // console.log(response)
            this.$router.push("/reports/report-builder");
          })
          .catch(error => {
            this.validationError = error.response.data.errors;
            console.log(error.response.data.errors);
          });
      } catch (e) {
        // if (e.response.status == 442) {
        //   this.validationError = e.resonse.data.errors
        //   console.log(this.validationError)
        // }
      }
    }
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
