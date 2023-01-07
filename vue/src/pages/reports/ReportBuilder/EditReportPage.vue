<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("menu.reportBuilder") }}
          </div>
          <!-- <small class="mx-1">({{ $t("dashboard.thismonth") }})</small> -->
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row>
      <v-col cols="12">
        <v-card class="pa-2" :loading="loading">
          <div class="title mb-2">
            {{ $t("reports.updateReport") }}
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
import { mapActions, mapState } from "vuex";

export default {
  components: {},
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reportBuilder"),
          disabled: false,
          href: "#",
        },
        {
          text: this.$t("menu.reportBuilder"),
          to: "/reports/report-builder",
          exact: true,
        },
      ],

      types: [
        {
          name: "Network",
          image: require("@/assets/images/visualization/network.jpg"),
        },
        {
          name: "Bar",
          image: require("@/assets/images/visualization/bar.jpg"),
        },
        {
          name: "Line",
          image: require("@/assets/images/visualization/line.jpg"),
        },
        {
          name: "X Y Bubble",
          image: require("@/assets/images/visualization/xybubble.jpg"),
        },
        {
          name: "Pie",
          image: require("@/assets/images/visualization/pie.jpg"),
        },
      ],
      report: {
        name: null,
        type: undefined,
      },
      validationError: [],
      loading: false,
    };
  },
  created() {
    const { id } = this.$route.params;
    this.loading = true;
    this.getChart(id)
      .then(() => {
        this.loading = false;
        this.report = {
          name: this.chart.name,
          type: this.chart.type,
          id: this.chart.id,
          _method: "PUT",
        };
      })
      .catch(() => {
        this.loading = false;
      });
  },
  computed: {
    ...mapState("reports", ["chart"]),
  },
  methods: {
    ...mapActions("reports", ["getChart", "updateChart"]),
    createReport() {
      let data = this.report;
      this.loading = true;
      this.validationError = {};
      this.updateChart(data)
        .then(() => {
          this.loading = false;
          this.$router.push("/reports/report-builder");
        })
        .catch((error) => {
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
      }
      return form;
    },
  },
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
