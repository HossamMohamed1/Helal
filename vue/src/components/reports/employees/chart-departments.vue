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
      series: [{
        name: '',
        data: [44, 100, 50, 60, ]
      }],
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
          categories: ["قسم 1", "قسم 2", "قسم 3", "قسم 4"
          ]
          // title: {
          //   text: 'Drones'
          // }
        },
        yaxis: {
          title: {
            // text: 'Screenshots'
          }
        },
        colors: ['#1e8e49'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return  + val + ' موظف'
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
