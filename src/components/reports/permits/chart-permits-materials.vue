<template>
  <div v-if="showChart">
    <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChart: false,
      series: [
        {
          name: '',
          type: 'bar',
          data: [
            30, 60, 60, 65, 70, 85, 90, 100, 85, 95, 110, 115, 120, 88, 75,
            85, 95, 110, 115, 120, 88, 75, 30, 60, 60, 65, 70, 85, 90, 100
          ]
        }
      ],
      chartOptions: {
        chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'

          ],
          title: {
            text: this.$t('dates.ramadanDays')
          }
        },
        yaxis: {
          // title: {
          //   text: 'Screenshots'
          // }
        },
        // colors: ['#1e8e49'],
        colors: ['#c3b086'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return +val + ' مادة '
            }
          }
        }
      }
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
