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
        <div style="width: 120px; height: 40px">
          <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark v-bind="attrs" v-on="on" class="mt-1">
                {{ $t("reports.createReport") }}
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ $t("reports.createReport") }}</span>
              </v-card-title>
              <v-card-text class="pb-0">
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <v-autocomplete
                        v-model="report.type"
                        :items="types"
                        :error-messages="validationError['type']"
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
                    <v-col cols="12">
                      <v-autocomplete
                        :items="columns"
                        :label="$t('reports.columns')"
                        v-model="report.columns"
                        multiple
                        dense
                        chips
                        small-chips
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
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions class="mb-1">
                <v-spacer></v-spacer>
                <v-btn color="primary" dark @click="submitFile"> حفظ </v-btn>
                <v-btn color="dark" dark @click="dialog = false"> إلغاء </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
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
              <date-range-picker v-model="dateRange" direction="rtl">
              </date-range-picker>
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
        :report="report"
        v-for="(report, index) in reports"
        :key="index + cards.length"
      />
    </v-row>
  </div>
</template>
<script>
import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import { mapState } from "vuex";
import TrackCard from "../../components/dashboard/TrackCard";
// import ChartComponent from "./components/chartComponent";
const ChartComponent = () =>
  import(
    /* webpackChunkName: "chart-component" */ "./components/chartComponent.vue"
  );
export default {
  components: { DateRangePicker, TrackCard, ChartComponent },
  data() {
    return {
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
          name: "XYBubble",
          image: require("@/assets/images/visualization/xybubble.jpg"),
        },
        {
          name: "Pie",
          image: require("@/assets/images/visualization/pie.jpg"),
        },
      ],
      columns: [
        "الموظفين",
        "الجنس",
        "الأقسام",
        "الإدارات",
        "المؤهلات",
        "الوكالات",
        "الجنسيه",
        "الحضور والغياب",
        "الأجازات",
        "الأعمار",
        "الموقع",
      ],
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
    };
  },
  computed: {
    ...mapState("statistics", ["cards", "reports"]),
  },
  methods: {
    submitFile() {
      this.dialog = false;
    },
  },
};
</script>
