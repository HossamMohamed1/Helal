<template>
  <div>
    <div ref="lineChart" style="height: 500px"></div>
  </div>
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
      let chart = am4core.create(this.$refs.lineChart, am4charts.XYChart);
      const line = this.analytics?.line;
      chart.data = line.map(item => {
        let keys = Object.keys(item);
        keys = keys.filter(item => item != "date");

        for (let index = 0; index < keys.length; index++) {
          const key = keys[index];
          // item = { key: parseFloat() };
          item[key] = item[key];
        }
        return item;
      });
      const { config } = this.chart;
      chart.colors.list = config.colors.map(color => am4core.color(color));
      this.backgroundStyle.backgroundColor = config?.style?.backgroundColor;
      let title = chart.titles.create();
      title.text = config?.title?.name;
      title.fontSize = config?.title?.fontSize;
      title.fill = am4core.color(config?.title?.fill);
      title.fontWeight = config?.title?.fontWeight;
      title.marginBottom = config?.title?.marginBottom;
      title.align = config?.title?.align;

      if (config?.legend?.disabled == "true") {
        chart.legend = new am4charts.Legend();
        chart.legend.position = config?.legend?.position;
        chart.legend.paddingTop = config?.legend?.paddingTop;
        chart.legend.paddingBottom = config?.legend?.paddingBottom;
      }

      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      dateAxis.renderer.minGridDistance = 50;
      dateAxis.title.text = config?.xLabel?.text;
      dateAxis.title.paddingTop = config?.xLabel?.paddingTop;
      dateAxis.renderer.grid.template.disabled = true;

      function createAxisAndSeries(field, name, opposite, bullet) {
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        // valueAxis.title.text = config?.yLabel;
        valueAxis.renderer.grid.template.disabled = true;

        if (chart.yAxes.indexOf(valueAxis) != 0) {
          valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
        }

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = field;
        series.dataFields.dateX = "date";
        series.absoluteWidth = 30;
        series.strokeWidth = 2;
        series.yAxis = valueAxis;
        series.name = name;
        series.tooltipText = "{name}: [bold]{valueY}[/] Units";
        series.tensionX = 0.8;
        series.showOnInit = true;

        var interfaceColors = new am4core.InterfaceColorSet();

        switch (bullet) {
          case "triangle":
            var bullet = series.bullets.push(new am4charts.Bullet());
            bullet.width = 12;
            bullet.height = 12;
            bullet.horizontalCenter = "middle";
            bullet.verticalCenter = "middle";

            var triangle = bullet.createChild(am4core.Triangle);
            triangle.stroke = interfaceColors.getFor("background");
            triangle.strokeWidth = 2;
            triangle.direction = "top";
            triangle.width = 12;
            triangle.height = 12;
            break;
          case "rectangle":
            var bullet = series.bullets.push(new am4charts.Bullet());
            bullet.width = 10;
            bullet.height = 10;
            bullet.horizontalCenter = "middle";
            bullet.verticalCenter = "middle";

            var rectangle = bullet.createChild(am4core.Rectangle);
            rectangle.stroke = interfaceColors.getFor("background");
            rectangle.strokeWidth = 2;
            rectangle.width = 10;
            rectangle.height = 10;
            break;
          default:
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.stroke = interfaceColors.getFor("background");
            bullet.circle.strokeWidth = 2;
            break;
        }

        valueAxis.renderer.line.strokeOpacity = 1;
        valueAxis.renderer.line.strokeWidth = 2;
        valueAxis.renderer.line.stroke = series.stroke;
        valueAxis.renderer.labels.template.fill = series.stroke;
        valueAxis.renderer.opposite = opposite;
      }

      let keys = [];

      line.forEach(item => {
        Object.keys(item).forEach(item => {
          if (!keys.includes(item)) {
            keys.push(item);
          }
        });
      });

      keys
        .filter(item => item != "date")
        .forEach((item, index) => {
          createAxisAndSeries(item, item.toUpperCase(), index != 0, "circle");
        });

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
    let chart = am4core.create(this.$refs.lineChart, am4charts.XYChart);

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
