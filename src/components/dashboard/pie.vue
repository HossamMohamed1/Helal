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
      series: [44, 55, 41, 17, 15],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [this.$t('general.work'), this.$t('general.leakage'), this.$t('general.chemicalLeakage'),
          this.$t('general.fires'), this.$t('general.intrudersAndVandals')
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
