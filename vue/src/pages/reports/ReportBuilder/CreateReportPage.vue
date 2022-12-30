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
        <v-card class="pa-2" :loading="loading">
          <div class="title mb-2">
            {{ $t("reports.createReport") }}
          </div>
          <v-form @submit.prevent="createReport" enctype="multipart/form-data">
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  value=""
                  v-model="report.name"
                  :error-messages="validationError['name']"
                  :label="$t('reports.reportName')"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-autocomplete
                  v-model="report.type"
                  :items="types"
                  :label="$t('reports.reportType')"
                  item-text="name"
                  item-value="name"
                >
                  <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-item-content
                        v-text="data.item"
                      ></v-list-item-content>
                    </template>
                    <template v-else>
                      <v-list-item-avatar>
                        <img :src="data.item.image" />
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title
                          v-html="data.item.name"
                        ></v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col cols="12" md="6">
                <v-file-input
                  truncate-length="15"
                  :label="$t('reports.uploadFile')"
                  :error-messages="validationError['file']"
                  v-model="report.file"
                  accept=".xlsx, .xls"
                ></v-file-input>
              </v-col>
            </v-row>
            <div class="d-flex mt-3">
              <v-btn
                :loading="loading"
                :disabled="loading"
                color="primary"
                type="submit"
              >
                {{ $t("general.save") }}
              </v-btn>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapActions } from "vuex";

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

      types: [
        { name: "Network", image: "/visualization/network.jpg" },
        { name: "Bar", image: "/visualization/bar.jpg" },
        { name: "Line", image: "/visualization/line.jpg" },
        { name: "X Y Bubble", image: "/visualization/xybubble.jpg" },
        { name: "Pie", image: "/visualization/pie.jpg" }
      ],
      report: {
        name: null,
        type: undefined,
        file: undefined
      },
      validationError: [],
      loading: false
    };
  },
  methods: {
    ...mapActions("reports", ["storeChart"]),
    createReport() {
      let data = this.buildForm(this.report);
      this.loading = true;
      this.validationError = {};
      this.storeChart(data)
        .then(() => {
          this.loading = false;
          this.$router.push("/reports/report-builder");
        })
        .catch(error => {
          this.loading = false;

          if (error?.response?.status == 422) {
            const { errors } = error?.response?.data ?? {};
            this.validationError = errors ?? {};
          }
        });
    },
    buildForm(data) {
      let keys = Object.keys(data);
      let form = new FormData();
      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        if (data[key]) {
          form.set(key, data[key]);
        }

        // if (key == "password" && data["password"]) {
        //   form.set("confirm_password", data["confirm_password"]);
        // }
      }
      return form;
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
