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
      series: [{
        name: 'متوسط الوقت',
        data: [44, 55, 60, 70, 120, 100, 50, 60, 30]
      }],
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
          curve: 'smooth'
        },
        colors: ['#1e8e49', '#fd9162', '#a7a7a7','#41b27b',  '#c9de77'],
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
          categories: [this.$t('complaints.complaint1'), this.$t('complaints.complaint2'), this.$t('complaints.complaint3'), this.$t('complaints.complaint4'),
            this.$t('complaints.complaint5'), this.$t('complaints.complaint6'), this.$t('complaints.complaint7'), this.$t('complaints.complaint8'),
            this.$t('complaints.complaint9')
          ]
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return  + val + ' ساعة'
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
