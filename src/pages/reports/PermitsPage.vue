<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("permits.permitsReports") }}
          </div>
          <small class="mx-1">({{ $t("dashboard.thismonth") }})</small>
        </div>
        <v-spacer></v-spacer>
        <div style="width: 170px; height: 40px;" class="mx-1">
          <v-select
            v-model="defaultSelectedvisitorsFilter"
            label=""
            class="mb-0"
            :items="visitorsFilter"
            solo
          ></v-select>
        </div>

        <div style="width: 160px; height: 40px;" class="mx-1">
          <v-select
            v-model="defaultSelectedpermitsFilter"
            label=""
            class="mb-0"
            :items="permitsFilter"
            solo
          ></v-select>
        </div>
        <div class="h-38">
          <template>
            <div class="date-picker position-relative">
              <i aria-hidden="true" class="v-icon mdi mdi-calendar"></i>
              <date-range-picker
                v-model="dateRange"
                :date-format="dateFormat"
                direction="rtl"
              >
              </date-range-picker>
            </div>
          </template>
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row class="flex-grow-0 mb-1" dense>
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('permits.TheTotalNumberOfPermits')"
            class="h-full"
            color="#8c9eff"
            :value="2359"
            :percentage="4.3"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('permits.TotalPermitsForAlHaramainExhibition')"
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
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('permits.TotalRamadanTravelPermits')"
            class="h-full"
            color="#8c9eff"
            :value="310"
            :percentage="16"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('permits.TheTotalNumberOfEmployeesOrVisitors')"
            class="h-full"
            color="#8c9eff"
            :value="1100"
            :percentage="90"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('permits.TheTotalMaterialsUsedInTheRamadanBreakfast')"
            class="h-full"
            color="#8c9eff"
            :value="50"
            :percentage="14"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="4" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="
              $t('permits.NumberOfEstablishmentsOperatingInTheRamadanIftar')
            "
            class="h-full"
            color="#8c9eff"
            :value="9"
            :percentage="20"
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
              {{ $t("menu.permits") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-status></chart-permits-status>
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
              {{ $t("permits.HaraminVisitingAndAverageTime") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-average></chart-permits-average>
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
              {{ $t("permits.TheTotalNumberOfEmployeesOrVisitors") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-visitors></chart-permits-visitors>
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
              {{ $t("permits.TheNationalityOfVisitorsToTheExhibition") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-nationalities></chart-permits-nationalities>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12">
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
              {{ $t("permits.TheTotalMaterialsUsedInTheRamadanBreakfast") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-materials></chart-permits-materials>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12">
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
              {{
                $t("permits.NumberOfEstablishmentsOperatingInTheRamadanIftar")
              }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-permits-establishments></chart-permits-establishments>
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
import ChartPermitsStatus from "../../components/reports/permits/chart-permits-status";
import ChartPermitsVisitors from "../../components/reports/permits/chart-permits-visitors";
import ChartPermitsNationalities from "../../components/reports/permits/chart-permits-nationalities";
import ChartPermitsEstablishments from "../../components/reports/permits/chart-permits-establishments";
import ChartPermitsMaterials from "../../components/reports/permits/chart-permits-materials";
import ChartPermitsAverage from "../../components/reports/permits/chart-permits-average";

export default {
  components: {
    ChartPermitsAverage,
    ChartPermitsMaterials,
    ChartPermitsEstablishments,
    ChartPermitsNationalities,
    ChartPermitsVisitors,
    ChartPermitsStatus,
    TrackCard,
    DateRangePicker
  },
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reports"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("menu.permits"),
          to: "/reports/permits",
          exact: true
        }
      ],
      loadingInterval: null,

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

      permitsFilter: [
        this.$t("permits.all"),
        this.$t("permits.AlHaramainExhibition"),
        this.$t("permits.RamadanTravel")
      ],
      defaultSelectedpermitsFilter: this.$t("permits.all"),

      visitorsFilter: [
        this.$t("permits.employeesAndVisitors"),
        this.$t("permits.employees"),
        this.$t("permits.visitors")
      ],
      defaultSelectedvisitorsFilter: this.$t("permits.employeesAndVisitors"),

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
