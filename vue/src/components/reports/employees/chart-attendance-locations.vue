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
        name: "الأقسام",
        data: [44, 55, 41, 33, 37]
      }, {
        name: "الإدارات",
        data: [53, 52, 53, 32, 33]
      }],
      chartOptions: {
        chart: {
          type: 'bar',
          height: 430
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        colors: ['#1e8e49', '#c3b086'],
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: [
            this.$t('employees.attendees'), this.$t('employees.absence'), this.$t('employees.vacations'),
            this.$t('employees.tasks'), this.$t('employees.permission')
          ],
        },
      },
    }
  },
  mounted() {
    this.showChart = true
  }
}
</script>
