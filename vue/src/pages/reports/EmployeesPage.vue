<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("employees.employeesReports") }}
          </div>
          <small class="mx-1">({{ $t("dashboard.thismonth") }})</small>
        </div>
        <v-spacer></v-spacer>
        <div style="width: 160px; height: 40px;" class="mx-1">
          <v-select
            v-model="defaultSelectedGender"
            label=""
            class="mb-0"
            :items="gender"
            solo
          ></v-select>
        </div>
        <div style="width: 120px; height: 40px;" class="mx-1">
          <v-select
            v-model="defaultSelected"
            label=""
            class="mb-0"
            :items="administrations"
            solo
          ></v-select>
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
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row class="flex-grow-0 mb-1" dense>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('employees.employees')"
            class="h-full"
            color="#8c9eff"
            :value="1200"
            :percentage="4.3"
            :percentage-label="$t('dashboard.lastweek')"
            :loading="isLoading3"
            :series="ordersSeries"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('employees.males')"
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
            :label="$t('employees.females')"
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
      <v-col cols="12" lg="3" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('employees.attendees')"
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
            <v-card-title
              class="d-flex align-center align-content-space-between"
            >
              <div>
                {{
                  $t("employees.employeesInPublicAgenciesAndAdministrations")
                }}
              </div>
              <!--              <div>-->
              <!--                <v-menu-->
              <!--                  ref="menu"-->
              <!--                  v-model="menu"-->
              <!--                  :close-on-content-click="false"-->
              <!--                  :return-value.sync="date"-->
              <!--                  transition="scale-transition"-->
              <!--                  offset-y-->
              <!--                  min-width="auto"-->
              <!--                >-->
              <!--                  <template v-slot:activator="{ on, attrs }">-->
              <!--                    <v-text-field-->
              <!--                      v-model="date"-->
              <!--                      prepend-icon="mdi-calendar"-->
              <!--                      readonly-->
              <!--                      v-bind="attrs"-->
              <!--                      v-on="on"-->
              <!--                    ></v-text-field>-->
              <!--                  </template>-->
              <!--                  <v-date-picker-->
              <!--                    v-model="date"-->
              <!--                    no-title-->
              <!--                    scrollable-->
              <!--                    range-->
              <!--                  >-->
              <!--                    <v-spacer></v-spacer>-->
              <!--                    <v-btn-->
              <!--                      text-->
              <!--                      color="primary"-->
              <!--                      @click="menu = false"-->
              <!--                    >-->
              <!--                      Cancel-->
              <!--                    </v-btn>-->
              <!--                    <v-btn-->
              <!--                      text-->
              <!--                      color="primary"-->
              <!--                      @click="$refs.menu.save(date)"-->
              <!--                    >-->
              <!--                      OK-->
              <!--                    </v-btn>-->
              <!--                  </v-date-picker>-->
              <!--                </v-menu>-->
              <!--              </div>-->
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-agencies></chart-agencies>
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
              {{ $t("employees.employeesByHeadquarters") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-headquarters></chart-headquarters>
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
              {{ $t("employees.employeesByGender") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-gender></chart-gender>
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
              {{ $t("employees.EmployeesAccordingAttendance") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1 justify-center pb-3">
              <chart-attendance></chart-attendance>
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
              {{ $t("employees.employeesAccordingToTheirQualificationsIn") }}
              {{ $t("employees.administration1") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1">
              <chart-administration1-qualifications></chart-administration1-qualifications>
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
              {{ $t("employees.employeesAccordingToTheirRanksIn") }}
              {{ $t("employees.administration1") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1">
              <chart-administration1-ranks></chart-administration1-ranks>
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
              {{ $t("employees.employeesAccordingToTheirQualificationsIn") }}
              {{ $t("employees.administration2") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1">
              <chart-administration2-qualifications></chart-administration2-qualifications>
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
              {{ $t("employees.employeesAccordingToTheirRanksIn") }}
              {{ $t("employees.administration2") }}
            </v-card-title>
            <div class="d-flex flex-column flex-grow-1">
              <chart-administration2-ranks></chart-administration2-ranks>
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

import ChartGender from "../../components/reports/employees/chart-gender";
import ChartAttendance from "../../components/reports/employees/chart-attendance";
import ChartAgencies from "../../components/reports/employees/chart-agencies";
import ChartHeadquarters from "../../components/reports/employees/chart-headquarters";
import ChartAdministration1Qualifications from "../../components/reports/employees/chart-administration1-qualifications";
import ChartAdministration2Qualifications from "../../components/reports/employees/chart-administration2-qualifications";
import ChartAdministration1Ranks from "../../components/reports/employees/chart-administration1-ranks";
import ChartAdministration2Ranks from "../../components/reports/employees/chart-administration2-ranks";

export default {
  components: {
    ChartAdministration2Ranks,
    ChartAdministration1Ranks,
    ChartAdministration2Qualifications,
    ChartAdministration1Qualifications,
    ChartHeadquarters,
    ChartAgencies,
    ChartAttendance,
    ChartGender,
    TrackCard,
    DateRangePicker
  },
  // filters: {
  //   dateCell(value) {
  //     const dt = new Date(value)
  //
  //     return dt.getDate()
  //   },
  //   date(val) {
  //     return val ? val.toLocaleString() : 'filter'
  //   }
  // },
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.reports"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("employees.employeesReports"),
          to: "/reports/employees",
          exact: true
        }
      ],
      loadingInterval: null,

      isLoading1: true,
      isLoading2: true,
      isLoading3: true,
      isLoading4: true,
      loading: false,
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
      // Selects filters
      administrations: [
        this.$t("employees.administration1"),
        this.$t("employees.administration2"),
        this.$t("employees.administration3"),
        this.$t("employees.administration4"),
        this.$t("employees.administration5"),
        this.$t("employees.administration6"),
        this.$t("employees.administration7"),
        this.$t("employees.administration8"),
        this.$t("employees.administration9")
      ],
      defaultSelected: this.$t("employees.administration1"),

      gender: [
        this.$t("employees.all"),
        this.$t("employees.males"),
        this.$t("employees.females")
      ],
      defaultSelectedGender: this.$t("employees.all"),

      // Date filter
      dateRange: {
        startDate: "2022-11-1",
        endDate: "2022-12-1"
      }

      // date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      // menu: false,
      // modal: false,
      // menu2: false
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
    created() {}
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
