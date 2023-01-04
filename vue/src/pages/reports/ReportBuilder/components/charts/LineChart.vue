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
        .catch(err => {
          console.log(err);
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
      const line = this.analytics?.line;
      chart.data = line.map(item => {
        let keys = Object.keys(item);
        keys = keys.filter(item => item != "date");

        for (let index = 0; index < keys.length; index++) {
          const key = keys[index];
          item[key] = item[key];
        }
        return item;
      });
      chart.logo.disabled = true;
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

      // Legend
      if (config?.legend?.disabled == false) {
        chart.legend = new am4charts.Legend();
        if (config?.legend?.position == true) {
          chart.legend.position = "bottom";
        } else {
          chart.legend.position = "top";
        }
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

      //Zoom
      // chart.scrollbarX = new am4core.Scrollbar();
      // chart.scrollbarY = new am4core.Scrollbar();
      //
      // if (config?.zoom?.scrollbarX == false) {
      //   chart.scrollbarX = new am4core.Scrollbar();
      // }
      //
      // if (config?.zoom?.scrollbarY == false) {
      //   chart.scrollbarY = new am4core.Scrollbar();
      // }
      //
      // if (config?.zoom?.cursor == "zoomXY") {
      //   chart.cursor = new am4charts.XYCursor();
      //   chart.cursor.behavior = "zoomXY";
      // }
      // else if(config?.zoom?.cursor == "zoomX"){
      //   chart.cursor = new am4charts.XYCursor();
      //   chart.cursor.behavior = "zoomX";
      // }
      // else{
      //   chart.cursor = new am4charts.XYCursor();
      //   chart.cursor.behavior = "zoomY";
      // }
      // chart.scrollbarX.marginBottom = 35;
      // if(config?.zoom?.scrollbarXBottom == "bottom"){
      //   chart.scrollbarX.parent = chart.bottomAxesContainer;
      //   chart.scrollbarX.marginBottom = 20;
      // }
      // if(config?.zoom?.scrollbarYLeft == "left"){
      //   chart.scrollbarY.parent = chart.leftAxesContainer;
      //   chart.scrollbarY.marginRight = 35;
      // }
      //
      // chart.fontSize = parseInt(config?.fontSize);

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
  }
};
</script>
