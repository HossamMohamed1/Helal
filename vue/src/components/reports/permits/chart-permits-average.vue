<template>
  <div v-if="showChart">
    <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChart: false,
      series: [
        {
          name: this.$t('permits.visitsRate'),
          data: [44, 55, 60, 70, 120, 100, 50, 60, 30, 40, 50, 20]
        },
        {
          name: this.$t('permits.timeSpent'),
          data: [54, 75, 76, 90, 130, 160, 80, 90, 60, 70, 80, 40]
        }
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [2, 2, 2, 2, 2],
          curve: 'smooth'
        },
        colors: ['#1e8e49', '#fd9162', '#a7a7a7', '#41b27b', '#c9de77'],
        title: {
          text: '',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          }
        },
        xaxis: {
          categories: [
            this.$t('dates.Jan'), this.$t('dates.Feb'), this.$t('dates.Mar'), this.$t('dates.Apr'), this.$t('dates.May'), this.$t('dates.Jun'),
            this.$t('dates.Jul'), this.$t('dates.Aug'), this.$t('dates.Sep'), this.$t('dates.Oct'), this.$t('dates.Nov'), this.$t('dates.Dec')
          ]
        },
        tooltip: {
          // y: {
          //   formatter: function (val) {
          //     return +val + ' ساعة'
          //   }
          // }
        }
      }
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
