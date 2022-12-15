<template>
  <div v-if="showChart">
    <apexchart
      type="donut"
      width="480"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChart: false,
      series: [22, 14, 45, 41, 17, 17],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [this.$t('charts.Station1'), this.$t('charts.Station2'), this.$t('charts.Station3'),
          this.$t('charts.Station4'), this.$t('charts.Station5'), this.$t('charts.Station6'), this.$t('charts.Station7')],
        stroke: {
          // colors: ['#29abe2', '#a4a8ad', '#d5d5d5']
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name:'total',
                value: 50
              }

            }

          }
        },
        // colors: ['#29abe2', '#a4a8ad', '#d5d5d5'],
        legend: {
          position: 'bottom',
          horizontalAlign: 'center'

        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      }
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
