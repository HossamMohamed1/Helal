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
      series: [890, 140, 40],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [this.$t('complaints.monthlyComplaints'), this.$t('complaints.weeklyComplaints'),
          this.$t('complaints.dailyComplaints')
        ],
        stroke: {
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
        colors: ['#1e8e49', '#fd9162', '#a7a7a7','#41b27b',  '#c9de77'],
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
