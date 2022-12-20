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
          data: [30, 60, 60, 65, 70, 85, 90, 100, 85, 95, 110, 115]
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
            this.$t('dates.Jan'), this.$t('dates.Feb'), this.$t('dates.Mar'), this.$t('dates.Apr'), this.$t('dates.May'), this.$t('dates.Jun'),
            this.$t('dates.Jul'), this.$t('dates.Aug'), this.$t('dates.Sep'), this.$t('dates.Oct'), this.$t('dates.Nov'), this.$t('dates.Dec')
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
              return +val + 'شخص '
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
