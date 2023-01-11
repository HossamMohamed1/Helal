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
        <v-spacer></v-spacer>
        <div class="d-flex align-center">
          <div class="mx-1">
            <v-btn
              color="primary"
              to="/reports/report-builder/create"
              class="h-38"
            >
              {{ $t("reports.createReport") }}
            </v-btn>
          </div>

          <div class="h-38">
            <template>
              <div class="date-picker position-relative">
                <i aria-hidden="true" class="v-icon mdi mdi-calendar"></i>
                <date-range-picker v-model="dateRange" direction="rtl">
                </date-range-picker>
              </div>
            </template>
          </div>
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row dense style="margin: 10px" class="builder-cards">
      <v-col cols="12" sm="6" lg="3" v-if="loading && reports.length == 0">
        <v-card :loading="loading">
          <v-img
            class="white--text align-end"
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            height="200px"
          >
            <v-card-title v-text="''"></v-card-title>
          </v-img>
        </v-card>
      </v-col>
      <v-col
        v-for="report in reports"
        :key="report.id"
        cols="12"
        sm="6"
        lg="3"
        xl="2"
      >
        <router-link
          :to="{ name: 'show-report-builder', params: { id: report.id } }"
        >
          <v-card :loading="loading">
            <v-img
              v-bind:src="
                require('@/assets/images/visualization/' + report.img)
              "
              class="white--text align-end"
              height="200px"
              style="background-size: contain"
            >
              <v-card-title
                style="
                  background: linear-gradient(to top, #167e3e, transparent);
                "
              >
                {{ report.name | capitalize }}
                <div>
                  <v-btn
                    x-small
                    icon
                    class="mr-1"
                    title="تعديل"
                    :to="{
                      name: 'edit-report-builder',
                      params: { id: report.id },
                    }"
                  >
                    <v-icon small> mdi-pen </v-icon>
                  </v-btn>
                  <v-btn
                    x-small
                    icon
                    class="mr-1"
                    title="حذف"
                    @click.prevent="deleteReport(report.id)"
                  >
                    <v-icon small> mdi-delete </v-icon>
                  </v-btn>
                </div>
              </v-card-title>
            </v-img>
          </v-card>
        </router-link>
      </v-col>
    </v-row>
  </div>
</template>

<script>
// DEMO Cards for dashboard
import TrackCard from "../../../components/dashboard/TrackCard";
import axios from "axios";
import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import { mapActions, mapState } from "vuex";
import { ask } from "@/helpers";

export default {
  components: {
    TrackCard,
    DateRangePicker,
  },
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

      dateRange: {
        startDate: "2022-11-1",
        endDate: "2022-12-1",
      },

      // reports: [],
      loading: false,
    };
  },
  created() {
    this.loadReports();
  },
  computed: {
    ...mapState("reports", ["reports"]),
  },
  methods: {
    ...mapActions("reports", ["getReports", "removeReport"]),
    loadReports() {
      this.loading = true;
      this.getReports()
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
    async deleteReport(id) {
      const { isConfirmed } = await ask("Are you sure ?");
      if (isConfirmed) {
        this.removeReport(id);
      }
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

.builder-cards .v-card__title {
  font-weight: 600;
  background: #f1f1f1 !important;
  color: #1e8e49;
  font-weight: 400;
}
.v-image__image--cover {
  background-size: 88% 80%;
  background-position: 50% 11% !important;
}
a {
  text-decoration: none;
}
</style>
