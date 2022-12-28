<template>
  <div class="d-flex flex-grow-1 flex-column">

    <div class="py-3">
      <div class="d-flex align-center page-filters">
        <div class="d-flex align-baseline">
          <div class="display-1 d-flex align-center">{{ $t('menu.reportBuilder') }}</div>
          <small class="mx-1">({{ $t('dashboard.thismonth') }})</small>
        </div>
        <v-spacer></v-spacer>
        <div class="d-flex align-center">
          <div class="mx-1">
            <v-btn color="primary" to="/reports/report-builder/create" class="h-38">
              إنشاء تقرير

            </v-btn>
          </div>

          <div class="h-38">
            <template>
              <div class="date-picker position-relative">
                <i aria-hidden="true" class="v-icon mdi mdi-calendar"></i>
                <date-range-picker v-model="dateRange" :date-format="dateFormat" direction='rtl'>
                </date-range-picker>
              </div>
            </template>
          </div>
        </div>

      </div>
      <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
    </div>

    <v-row dense>
      <v-col v-for="report in reports" :key="report.name" cols="12" sm="6" lg="3">
        <a  :href="'/reports/report-builder/'+report.id">
          <v-card>
            <v-img v-bind:src="'/visualization/' + report.img" class="white--dark align-end" height="200px">
              <v-card-title v-text="report.name" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"></v-card-title>
            </v-img>
          </v-card>
        </a>
      </v-col>
    </v-row>



  </div>
</template>

<script>
// DEMO Cards for dashboard
import TrackCard from '../../../components/dashboard/TrackCard'
import axios from 'axios'
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'


export default {
  components: {
    TrackCard,
    DateRangePicker
  },
  data() {
    return {
      breadcrumbs: [{
        text: this.$t('menu.reportBuilder'),
        disabled: false,
        href: '#'
      }, {
        text: this.$t('menu.reportBuilder'),
        to: '/reports/report-builder',
        exact: true
      }],

      dateRange: {
        startDate: '2022-11-1',
        endDate: '2022-12-1'
      },

      reports: []

    }

  },
  created() {
    this.getReports();
    this.endDate.setDate(this.endDate.getDate() + 6)
    this.dateRange = {
      startDate, endDate
    }
  },
  methods: {
    getReports() {
      axios.get('charts/index')
        .then(response => {
          console.log(response)
          this.reports = response.data.charts
          // this.$router.push('/reports/report-builder')
        })


    },

  },

}
</script>
<style>
.vue-daterange-picker {
  margin: 0;
}

.reportrange-text {
  padding: 8px 10px !important;
}
</style>
