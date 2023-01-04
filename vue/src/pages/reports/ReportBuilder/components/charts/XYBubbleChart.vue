<template>
  <v-card
    :style="{ background: backgroundStyle.backgroundColor }"
    :loading="loading"
    flat
  >
    <div>
      <div dir="ltr" ref="chartdiv" style="height: 500px"></div>
    </div>
  </v-card>
</template>
<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

am4core.useTheme(am4themes_animated);
import { mapActions, mapState } from "vuex";

export default {
  components: {},
  props: {
    config: {}
  },
  data() {
    return {
      loading: false,
      backgroundStyle: { backgroundColor: "" },
      chartObject: null
    };
  },
  destroyed() {
    if (this.chartObject) {
      this.chartObject.dispose();
    }
  },
  watch: {
    fileData() {
      let { id } = this.chart;
      this.loading = true;
      this.loadAnalytics(id)
        .then(() => {
          this.loading = false;
          this.loadChart();
        })
        .catch(() => {
          this.loading = false;
        });
    },
    chart() {
      let { id } = this.chart;
      this.loading = true;
      this.loadAnalytics(id)
        .then(() => {
          this.loading = false;
          this.loadChart();
        })
        .catch(() => {
          this.loading = false;
        });
    }
  },
  computed: {
    ...mapState("reports", ["analytics", "chart", "fileData"])
  },
  methods: {
    ...mapActions("reports", ["loadAnalytics"]),
    loadChart() {
      if (this.chartObject) {
        this.chartObject.dispose();
      }
      let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);
      chart.maskBullets = false;
      console.log(this.analytics);
      chart.data = this.analytics;
      const { config } = this.chart;
      // Title
      let title = chart.titles.create();
      title.text = config?.title?.name;
      title.fontSize = parseInt(config?.title?.fontSize);
      title.fill = am4core.color(config?.title?.fill);
      title.fontWeight = parseInt(config?.title?.fontWeight);
      title.marginBottom = parseInt(config?.title?.marginBottom);

      title.align = config?.title?.align;
      let xAxis = chart.xAxes.push(new am4charts.CategoryAxis());

      let yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      // Axis Titles
      xAxis.title.text = config?.xLabel?.text;
      xAxis.title.fontSize = parseInt(config?.xLabel?.fontSize);
      xAxis.title.fill = config?.xLabel?.fill;
      xAxis.title.marginTop = parseInt(config?.xLabel?.marginTop);
      yAxis.title.text = config?.yLabel?.text;
      yAxis.title.fontSize = parseInt(config?.yLabel?.fontSize);
      yAxis.title.fill = config?.yLabel?.fill;

      yAxis.title.marginRight = parseInt(config?.yLabel?.marginRight);

      // Background
      this.backgroundStyle.backgroundColor = config?.style?.backgroundColor;
      yAxis.dataFields.category = "y";
      xAxis.renderer.minGridDistance = 20;
      yAxis.renderer.minGridDistance = 20;

      xAxis.dataFields.category = "x";
      xAxis.renderer.grid.template.disabled = true;
      yAxis.renderer.grid.template.disabled = true;
      xAxis.renderer.axisFills.template.disabled = true;
      yAxis.renderer.axisFills.template.disabled = true;
      yAxis.renderer.ticks.template.disabled = true;

      xAxis.renderer.ticks.template.disabled = true;
      yAxis.renderer.labels.template.rotation = 45;

      xAxis.renderer.labels.template.rotation = 45;

      yAxis.renderer.inversed = true;
      let series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.categoryY = "y";
      series.dataFields.categoryX = "x";
      series.dataFields.value = "value";
      series.columns.template.disabled = true;

      series.sequencedInterpolation = true;

      //series.defaultState.transitionDuration = 3000;
      let bullet = series.bullets.push(new am4core.Circle());
      bullet.tooltipText =
        "[bold]{title}:[/]\nPopulation: {value.value}\nIncome: {valueX.value}\nLife expectancy:{valueY.value}";
      bullet.propertyFields.fill = "color";
      bullet.strokeOpacity = 0;
      bullet.fontSize = 10;
      bullet.adapter.add("tooltipY", function(tooltipY, target) {
        return -target.radius + 1;
      });
      bullet.strokeWidth = parseInt(config?.bullets?.strokeWidth);

      bullet.stroke = am4core.color(config?.bullets?.fill);

      series.heatRules.push({
        property: "radius",
        target: bullet,
        min: 2,
        max: 40
      });
      bullet.hiddenState.properties.scale = 0.01;

      bullet.hiddenState.properties.opacity = 1;
      let hoverState = bullet.states.create("hover");
      hoverState.properties.strokeOpacity = parseFloat(
        config?.bullets?.strokeOpacity
      );

      hoverState.properties.fillOpacity = parseFloat(
        config?.bullets?.fillOpacity
      );
      //Zoom
      if (config?.zoom?.scrollbarX == "true") {
        chart.scrollbarX = new am4core.Scrollbar();
      }

      if (config?.zoom?.scrollbarY == "true") {
        chart.scrollbarY = new am4core.Scrollbar();
      }

      if (config?.zoom?.cursor == "zoomXY") {
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomXY";
      } else if (config?.zoom?.cursor == "zoomX") {
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomX";
      } else {
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";
      }
      chart.scrollbarX.marginBottom = 35;
      if (config?.zoom?.scrollbarXBottom == "bottom") {
        chart.scrollbarX.parent = chart.bottomAxesContainer;
        chart.scrollbarX.marginBottom = 20;
      }
      if (config?.zoom?.scrollbarYLeft == "left") {
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.marginRight = 35;
      }

      chart.fontSize = parseInt(config?.fontSize);
      this.chartObject = chart;
    }
  },
  mounted() {
    const { id } = this.chart;
    this.loadAnalytics(id)
      .then(() => {
        this.loading = false;
        this.loadChart();
      })
      .catch(() => {
        this.loading = false;
      });

    return false;
    let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

    // Add data
    chart.data = generateChartData();

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.minGridDistance = 50;

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = "visits";
    series.dataFields.dateX = "date";
    series.strokeWidth = 2;
    series.minBulletDistance = 10;
    series.tooltipText = "{valueY}";
    series.tooltip.pointerOrientation = "vertical";
    series.tooltip.background.cornerRadius = 20;
    series.tooltip.background.fillOpacity = 0.5;
    series.tooltip.label.padding(12, 12, 12, 12);

    // Add scrollbar
    chart.scrollbarX = new am4charts.XYChartScrollbar();
    chart.scrollbarX.series.push(series);

    // Add cursor
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.xAxis = dateAxis;
    chart.cursor.snapToSeries = series;

    function generateChartData() {
      var chartData = [];
      var firstDate = new Date();
      firstDate.setDate(firstDate.getDate() - 1000);
      var visits = 1200;
      for (var i = 0; i < 10; i++) {
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property,
        // however when possible, use date objects, as this will speed up chart rendering.
        var newDate = new Date(firstDate);
        newDate.setDate(newDate.getDate() + i);

        visits += Math.round(
          (Math.random() < 0.5 ? 1 : -1) * Math.random() * 10
        );

        chartData.push({
          date: newDate,
          visits: visits
        });
      }
      return chartData;
    }
  }
};
</script>
