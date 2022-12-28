<template>
    <div>
        <div class="story_pie" :id="'PieChartDiv'"></div>
    </div>
</template>
  
<script>
import BootstrapVueIcons from "bootstrap-vue";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";

export default {
    name: "PieComponent",
    props: ['piedata', 'divId'],
    mounted() {
        this.loadChart(this.piedata)
    },
    created() {
        console.log("PieData");
    },
    methods: {
        loadChart(seriesData) {
            var chart = am4core.create(`PieChartDiv`, am4charts.PieChart);
            chart.data = seriesData;
            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "name";
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeOpacity = 1;

            // This creates initial animation
            pieSeries.hiddenState.properties.opacity = 1;
            pieSeries.hiddenState.properties.endAngle = -90;
            pieSeries.hiddenState.properties.startAngle = -90;

            chart.hiddenState.properties.radius = am4core.percent(0);
        },

    }
};
</script>
  
<style scoped lang="scss">
#PieChartDiv {
    height: 600px;
}

.story_pie {
    width: 100%;
    height: 600px;
    margin-bottom: 20px;
}
</style>
  