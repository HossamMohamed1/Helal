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
      series: [1200, 890, 310],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [this.$t('permits.TheTotalNumberOfPermits'), this.$t('permits.AlHaramainExhibition'), this.$t('permits.RamadanTravel')
        ],
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
        colors: ['#1e8e49', '#c3b086',  '#a7a7a7', '#fd9162','#41b27b',  '#c9de77'],
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
