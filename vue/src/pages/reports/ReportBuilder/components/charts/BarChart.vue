<template>
  <v-card :loading="loading" flat>
    <div dir="ltr" ref="chartdiv" style="height: 500px"></div>
  </v-card>
</template>
<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import { mapActions, mapState } from "vuex";

am4core.useTheme(am4themes_animated);

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
  computed: {
    ...mapState("reports", ["analytics", "chart", "fileData"])
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
  destroyed() {
    if (this.chartObject) {
      this.chartObject.dispose();
    }
  },
  methods: {
    ...mapActions("reports", ["loadAnalytics"]),
    loadChart() {
      if (this.chartObject) {
        this.chartObject.dispose();
      }
      let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);
      chart.data = this.analytics;
      chart.logo.disabled = true;
      let data = [];
      this.analytics.forEach(obj => {
        Object.keys(obj).forEach((key, index) => {
          if (index > 0) data.push({ name: key, value: obj[key] });
        });
      });

      const { config } = this.chart;
      this.backgroundStyle.backgroundColor = config?.style?.backgroundColor;
      chart.colors.list = config.colors.map(color => am4core.color(color));
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "category";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.inside = config?.labels?.valign != "bottom";

      categoryAxis.renderer.grid.template.disabled = false;
      categoryAxis.renderer.labels.template.valign = config?.labels?.valign;
      categoryAxis.renderer.labels.template.fontSize = parseInt(
        config?.labels?.fontSize
      );

      categoryAxis.renderer.labels.template.fill = am4core.color(
        config?.labels?.fill
      );
      categoryAxis.renderer.labels.template.rotation = config?.labels?.rotation;
      categoryAxis.renderer.labels.template.marginTop = 20;

      categoryAxis.renderer.labels.template.visible = config?.labels?.disabled;

      categoryAxis.renderer.cellStartLocation = config?.cellStartLocation;
      categoryAxis.renderer.cellEndLocation = config?.cellEndLocation;

      categoryAxis.title.text = config?.xLabel?.text;
      categoryAxis.title.paddingTop = parseInt(config?.xLabel?.paddingTop);
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.min = 0;
      valueAxis.title.text = config?.yLabel;

      let title = chart.titles.create();
      title.text = config?.title?.name;
      title.fontSize = config?.title?.fontSize;
      title.fill = am4core.color(config?.title?.fill);
      title.fontWeight = config?.title?.fontWeight;
      title.marginBottom = config?.title?.marginBottom;
      title.align = config?.title?.align;

      // Legend
      if (config?.legend?.disabled == "true") {
        chart.legend = new am4charts.Legend();
        chart.legend.position = config?.legend?.position;
        chart.legend.paddingTop = parseInt(config?.legend?.paddingTop);
        chart.legend.paddingBottom = parseInt(config?.legend?.paddingBottom);
      }

      function createSeries(field, name) {
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = field;
        series.dataFields.categoryX = "category";
        series.name = name;
        series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
      }

      chart.paddingBottom = 10;
      chart.maskBullets = false;
      let keys = [];

      this.analytics.forEach(item => {
        Object.keys(item).forEach(item => {
          if (!keys.includes(item)) {
            keys.push(item);
          }
        });
      });

      keys
        .filter(item => item != "category")
        .forEach((item, index) => {
          createSeries(item, item, index == 1);
        });

      this.chartObject = chart;
    }
  },
  created() {},
  mounted() {
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

    // return false;
    // let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

    // // Add data
    // chart.data = generateChartData();

    // // Create axes
    // var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    // dateAxis.renderer.minGridDistance = 50;

    // var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    // // Create series
    // var series = chart.series.push(new am4charts.LineSeries());
    // series.dataFields.valueY = "visits";
    // series.dataFields.dateX = "date";
    // series.strokeWidth = 2;
    // series.minBulletDistance = 10;
    // series.tooltipText = "{valueY}";
    // series.tooltip.pointerOrientation = "vertical";
    // series.tooltip.background.cornerRadius = 20;
    // series.tooltip.background.fillOpacity = 0.5;
    // series.tooltip.label.padding(12, 12, 12, 12);

    // // Add scrollbar
    // chart.scrollbarX = new am4charts.XYChartScrollbar();
    // chart.scrollbarX.series.push(series);

    // // Add cursor
    // chart.cursor = new am4charts.XYCursor();
    // chart.cursor.xAxis = dateAxis;
    // chart.cursor.snapToSeries = series;

    // function generateChartData() {
    //   var chartData = [];
    //   var firstDate = new Date();
    //   firstDate.setDate(firstDate.getDate() - 1000);
    //   var visits = 1200;
    //   for (var i = 0; i < 10; i++) {
    //     // we create date objects here. In your data, you can have date strings
    //     // and then set format of your dates using chart.dataDateFormat property,
    //     // however when possible, use date objects, as this will speed up chart rendering.
    //     var newDate = new Date(firstDate);
    //     newDate.setDate(newDate.getDate() + i);

    //     visits += Math.round(
    //       (Math.random() < 0.5 ? 1 : -1) * Math.random() * 10
    //     );

    //     chartData.push({
    //       date: newDate,
    //       visits: visits
    //     });
    //   }
    //   return chartData;
    // }
  }
};
</script>
