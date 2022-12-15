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
          data: [60, 65, 85, 90 , 110, 115]
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
            this.$t('nationalities.Saudi'), this.$t('nationalities.Egypt'), this.$t('nationalities.Moroccan'), this.$t('nationalities.Tunisian'),
            this.$t('nationalities.American'), this.$t('nationalities.Japanese')
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
