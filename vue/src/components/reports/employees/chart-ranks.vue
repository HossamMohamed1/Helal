<template>
  <div v-if="showChart">
    <apexchart type="bar" height="430" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChart: false,
      series: [{
        name: this.$t('employees.rank1'),
        data: [44, 55, 41, 64, 22, 43, 21]
      }, {
        name: this.$t('employees.rank2'),
        data: [70, 59, 45, 65, 23, 45, 43]
      }, {
        name: this.$t('employees.rank3'),
        data: [53, 32, 33, 52, 13, 44, 32]
      }, {
        name: this.$t('employees.rank4'),
        data: [30, 60, 40, 45, 20, 15, 40]
      }, {
        name: this.$t('employees.rank4'),
        data: [54, 67, 78, 45, 57, 77, 88]
      }],
      chartOptions: {
        chart: {
          type: 'bar',
          height: 430
        },
        // labels: [this.$t('charts.drone1'), this.$t('charts.drone2'), this.$t('charts.drone3'), this.$t('charts.drone4')],
        plotOptions: {
          bar: {
            // horizontal: true,
            dataLabels: {
              position: 'top'
            }
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        colors: ['#1e8e49', '#fd9162', '#a7a7a7','#41b27b',  '#c9de77'],
        xaxis: {
          categories:  [this.$t('employees.administration1'), this.$t('employees.administration2'), this.$t('employees.administration3'),
            this.$t('employees.administration4'), this.$t('employees.administration5'), this.$t('employees.administration6'), this.$t('employees.administration7')]
        }
      }
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
