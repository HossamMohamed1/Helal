<template>
  <div v-if="showChart">
    <apexchart
      type="line"
      height="350"
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
      series: [{
        name: this.$t('employees.administration1'),
        data: [45, 52, 38, 24, 33, 26, 21, 20, 44, 45, 30, 35, 37, 38, 53, 55, 33, 26, 21, 20, 44, 45 ]
      },
        {
          name: this.$t('employees.administration2'),
          data: [35, 41, 62, 42, 13, 18, 29, 37, 24, 45, 52, 38, 24, 33, 26, 21, 42, 13, 18, 29, 37, 24]
        }
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [2, 2, 2, 2, 2],
          // curve: 'straight',
          curve: 'smooth',
          // dashArray: [0, 8, 5]
        },
        title: {
          text: '',
          align: 'center'
        },
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          }
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6
          }
        },
        xaxis: {
          categories: [20,21, 22, 23,24, 25,26, 27, 28, 29, 30, 30, 35, 40,41, 42, 43, 44, 45, 50, 55, 60
          ],
        },
        colors: ['#1e8e49', '#c3b086'],
        tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val + " موظف "
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val + " موظف "
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val;
                }
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
      },
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
