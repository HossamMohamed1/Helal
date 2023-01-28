<template>
  <div class="d-flex flex-grow-1 flex-column">
    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">
            {{ $t("employees.employeesReports") }}
          </div>
        </div>
        <v-spacer></v-spacer>
        <div style="height: 30px">
          <div class="actions mx-1" @click.stop="dialog = true">
            <v-btn color="primary" style="height: 40px">
              {{ $t("reports.createReport") }}
            </v-btn>
          </div>
        </div>
        <div style="width: 160px; height: 40px" class="mx-1">
          <v-select
            v-model="defaultSelectedGender"
            label=""
            class="mb-0"
            :items="gender"
            solo
          ></v-select>
        </div>
        <div style="width: 120px; height: 40px" class="mx-1">
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
              <date-range-picker v-model="dateRange" direction="rtl" />
            </div>
          </template>
        </div>
      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>
    <v-row class="flex-grow-0 mb-1" dense>
      <v-col
        cols="12"
        lg="3"
        md="6"
        v-for="(card, index) in cards"
        :key="index"
      >
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t(card.label)"
            class="h-full"
            :color="card.color"
            :value="card.value"
            :loading="card.loading"
            :series="card.ordersSeries"
          ></track-card>
        </div>
      </v-col>
    </v-row>
    <v-row class="flex-grow-0 mb-1" dense>
      <ChartComponent
        @filter="filter"
        :filters="filters"
        :report="report"
        v-for="(report, index) in reports"
        :key="index + cards.length"
      />
      <ReportSettinDialog />
    </v-row>
    <create-report-dialog v-model="dialog" />
  </div>
</template>
<script>
// import DateRangePicker from "vue2-daterange-picker";
import CreateReportDialog from "@/components/reports/employees/CreateReportDialog";
import ReportSettinDialog from "@/components/reports/employees/ReportSetting";
const DateRangePicker = () =>
  import(/* webpackChunkName: "DateRangePicker" */ "vue2-daterange-picker");
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import { mapState, mapActions } from "vuex";
const TrackCard = () =>
  import(
    /* webpackChunkName: "TrackCard" */ "../../components/dashboard/TrackCard.vue"
  );
// import ChartComponent from "./components/chartComponent";
const ChartComponent = () =>
  import(
    /* webpackChunkName: "chart-component" */ "./components/chartComponent.vue"
  );

export default {
  components: {
    CreateReportDialog,
    DateRangePicker,
    TrackCard,
    ChartComponent,
    ReportSettinDialog,
  },
  data() {
    return {
      showChart: true,
      setting: true,
      breadcrumbs: [
        {
          text: this.$t("menu.reports"),
          disabled: false,
          href: "#",
        },
        {
          text: this.$t("employees.employeesReports"),
          to: "/reports/employees",
          exact: true,
        },
      ],
      dialog: false,
      validationError: [],
      report: {},
      administrations: [
        this.$t("employees.administration1"),
        this.$t("employees.administration2"),
        this.$t("employees.administration3"),
        this.$t("employees.administration4"),
        this.$t("employees.administration5"),
        this.$t("employees.administration6"),
        this.$t("employees.administration7"),
        this.$t("employees.administration8"),
        this.$t("employees.administration9"),
      ],
      defaultSelected: this.$t("employees.administration1"),

      gender: [
        this.$t("employees.all"),
        this.$t("employees.males"),
        this.$t("employees.females"),
      ],
      defaultSelectedGender: this.$t("employees.all"),
      dateRange: {
        startDate: "2022-11-1",
        endDate: "2022-12-1",
      },
      filters: {},
    };
  },
  computed: {
    ...mapState("statistics", ["cards", "reports"]),
  },
  async mounted() {
    this.fetchCards();
  },
  methods: {
    submitFile() {
      this.dialog = false;
    },
    ...mapActions("statistics", ["fetchCards"]),
    async filter(data) {
      this.filters = data;
    },
  },
};
</script>
