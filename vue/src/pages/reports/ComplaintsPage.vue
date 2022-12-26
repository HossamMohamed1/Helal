<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("complaints.complaintsReports") }}
          </div>
          <small class="mx-1">({{ $t("dashboard.thismonth") }})</small>
        </div>
        <v-spacer></v-spacer>
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
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row class="flex-grow-0 mb-1" dense>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('complaints.totalComplaints')"
            class="h-full"
            color="#8c9eff"
            :value="2230"
            :percentage="100"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('complaints.monthlyComplaints')"
            class="h-full"
            color="#8c9eff"
            :value="890"
            :percentage="84"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('complaints.weeklyComplaints')"
            class="h-full"
            color="#8c9eff"
            :value="140"
            :percentage="38"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('complaints.dailyComplaints')"
            class="h-full"
            color="#8c9eff"
            :value="20"
            :percentage="8"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
    </v-row>

    <v-row class="flex-grow-0 mb-1" dense>
      <v-col cols="12" lg="6">
        <v-card>
          <div
            v-if="loading"
            class="d-flex flex-grow-1 align-center justify-center"
          >
            <v-progress-circular
              indeterminate
              color="primary"
            ></v-progress-circular>
          </div>
          <div v-else class="d-flex flex-column flex-grow-1">
            <v-card-title>
              {{ $t("complaints.monthlyWeeklyDailyComplaints") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-count></chart-count>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <div
            v-if="loading"
            class="d-flex flex-grow-1 align-center justify-center"
          >
            <v-progress-circular
              indeterminate
              color="primary"
            ></v-progress-circular>
          </div>
          <div v-else class="d-flex flex-column flex-grow-1">
            <v-card-title>
              {{ $t("complaints.complaintsReceivedForComplaints") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-complaints></chart-complaints>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <div
            v-if="loading"
            class="d-flex flex-grow-1 align-center justify-center"
          >
            <v-progress-circular
              indeterminate
              color="primary"
            ></v-progress-circular>
          </div>
          <div v-else class="d-flex flex-column flex-grow-1">
            <v-card-title>
              {{ $t("complaints.AverageTimeToResolveComplaints") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-average></chart-average>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <div
            v-if="loading"
            class="d-flex flex-grow-1 align-center justify-center"
          >
            <v-progress-circular
              indeterminate
              color="primary"
            ></v-progress-circular>
          </div>
          <div v-else class="d-flex flex-column flex-grow-1">
            <v-card-title>
              {{ $t("complaints.TheRateOfComplaintsInShifts") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-shifts></chart-shifts>
            </div>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
// DEMO Cards for dashboard
import TrackCard from "../../components/dashboard/TrackCard";

import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import ChartCount from "../../components/reports/complaints/chart-count";
import ChartShifts from "../../components/reports/complaints/chart-shifts";
import ChartAverage from "../../components/reports/complaints/chart-average";
import ChartComplaints from "../../components/reports/complaints/chart-complaints";

export default {
  components: {
    ChartComplaints,
    ChartAverage,
    ChartShifts,
    ChartCount,
    TrackCard,
    DateRangePicker
  },
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reports"),
          disabled: false,
          to: "/reports"
        },
        {
          text: this.$t("menu.complaints"),
          to: "/reports/complaints",
          exact: true
        }
      ],
      loadingInterval: null,
      loading: false,
      isLoading1: true,
      isLoading2: true,
      isLoading3: true,
      isLoading4: true,

      ordersSeries: [
        {
          name: "Orders",
          data: [
            ["2020-02-02", 34],
            ["2020-02-03", 43],
            ["2020-02-04", 40],
            ["2020-02-05", 43]
          ]
        }
      ],

      customersSeries: [
        {
          name: "Customers",
          data: [
            ["2020-02-02", 13],
            ["2020-02-03", 11],
            ["2020-02-04", 13],
            ["2020-02-05", 12]
          ]
        }
      ],

      filter: [
        this.$t("dashboard.thismonth"),
        this.$t("dashboard.lastweek"),
        this.$t("dashboard.lastmonth")
      ],
      defaultSelected: this.$t("dashboard.thismonth"),

      dateRange: {
        startDate: "2022-11-1",
        endDate: "2022-12-1"
      }
    };
  },
  computed: {
    theme() {
      return this.$vuetify.theme.isDark
        ? this.$vuetify.theme.defaults.dark
        : this.$vuetify.theme.defaults.light;
    }
  },
  watch: {
    selectedUsers(val) {},
    created() {
      this.endDate.setDate(this.endDate.getDate() + 6);
      this.dateRange = {
        startDate,
        endDate
      };
    }
  },
  mounted() {
    let count = 0;

    // DEMO delay for loading graphics
    this.loadingInterval = setInterval(() => {
      this[`isLoading${count++}`] = false;
      if (count === 4) this.clear();
    }, 400);
  },
  beforeDestroy() {
    this.clear();
  },
  methods: {
    clear() {
      clearInterval(this.loadingInterval);
    }
  }
};
</script>
<style>
.vue-daterange-picker {
  margin: 0;
}
</style>
