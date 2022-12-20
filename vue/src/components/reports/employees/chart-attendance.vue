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
      series: [890, 60, 50, 100, 40],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [this.$t('employees.attendees'), this.$t('employees.absence'), this.$t('employees.vacations'),
          this.$t('employees.tasks'), this.$t('employees.permission')
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
