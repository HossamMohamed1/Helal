<template>
  <div v-if="showChart">
    <apexchart type="line" height="372" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChart: false,
      series: [{
        name: this.$t('employees.administration1'),
        data: [35, 28, 42, 20, 44, 40 ]
      },
        {
          name: this.$t('employees.administration2'),
          data: [30, 14, 43, 26, 46, 42,]
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
          categories: [this.$t('employees.rank1'), this.$t('employees.rank2'), this.$t('employees.rank3'),
            this.$t('employees.rank4'), this.$t('employees.rank5'), this.$t('employees.rank6')
          ]
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
