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
        data: [44, 55, 60, 70, 120, 100, 50, 60, 30]
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
          categories: [this.$t('complaints.complaint1'), this.$t('complaints.complaint2'), this.$t('complaints.complaint3'), this.$t('complaints.complaint4'),
            this.$t('complaints.complaint5'), this.$t('complaints.complaint6'), this.$t('complaints.complaint7'), this.$t('complaints.complaint8'),
            this.$t('complaints.complaint9')
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
              return  + val + ' بلاغ'
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
