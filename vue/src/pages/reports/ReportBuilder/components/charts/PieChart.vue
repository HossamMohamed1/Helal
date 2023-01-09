<template>
  <v-card
    :loading="loading"
    :style="{ background: backgroundStyle.backgroundColor }"
    flat
  >
    <div ref="chartdiv" dir="ltr" style="height: 500px"></div>
  </v-card>
</template>
<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

am4core.useTheme(am4themes_animated);
import { mapActions, mapState } from "vuex";

export default {
  computed: {
    ...mapState("reports", ["analytics", "chart", "fileData"])
  },
  data() {
    return {
      loading: false,
      chartObject: null,
      backgroundStyle: { backgroundColor: "" }
    };
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
  destroyed() {
    if (this.chartObject) {
      this.chartObject.dispose();
    }
  },
  mounted() {
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
  },
  methods: {
    ...mapActions("reports", ["loadAnalytics"]),
    loadChart() {
      if (this.chartObject) {
        this.chartObject.dispose();
      }
      let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart);
      chart.logo.disabled = true;
      const { config } = this.chart;

      chart.data = this.analytics.map((item, key) => {
        let index = parseInt(
          Math.round(Math.random() * (config?.colors?.length - 1 - 0)) + 0
        );
        item["color"] = am4core.color(config.colors[index]);
        return item;
      });

      this.backgroundStyle.backgroundColor = config?.style?.backgroundColor;

      // chart.colors.list = config.colors.map(color => am4core.color(color));
      let title = chart.titles.create();
      title.text = config?.title?.name;
      title.fontSize = config?.title?.fontSize;
      title.fill = am4core.color(config?.title?.fill);
      title.fontWeight = config?.title?.fontWeight;
      title.marginBottom = config?.title?.marginBottom;
      title.align = config?.title?.align;

      var pieSeries = chart.series.push(new am4charts.PieSeries());
      pieSeries.dataFields.value = "value";
      pieSeries.dataFields.category = "name";
      pieSeries.slices.template.propertyFields.fill = "color";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeOpacity = 1;

      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -90;
      pieSeries.hiddenState.properties.startAngle = -90;

      chart.hiddenState.properties.radius = am4core.percent(0);

      // Let's cut a hole in our Pie chart the size of 30% the radius
      chart.innerRadius = am4core.percent(30);

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

      // Put a thick white border around each Slice
      pieSeries.slices.template.stroke = am4core.color(config?.stroke);
      pieSeries.slices.template.strokeWidth = config?.strokeWidth;
      pieSeries.slices.template.strokeOpacity = config?.strokeOpacity;
      // change the cursor on hover to make it apparent the object can be interacted with
      pieSeries.slices.template.cursorOverStyle = [
        {
          property: "cursor",
          value: "pointer"
        }
      ];
      if (config?.alignLabels == false) {
        pieSeries.alignLabels = false;
        pieSeries.labels.template.bent = true;
        pieSeries.labels.template.radius = 3;
        pieSeries.labels.template.padding(0, 0, 0, 0);

        pieSeries.ticks.template.disabled = true;
      }

      // Create a base filter effect (as if it's not there) for the hover to return to
      var shadow = pieSeries.slices.template.filters.push(
        new am4core.DropShadowFilter()
      );
      shadow.opacity = 0;

      // Create hover state
      var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

      // Slightly shift the shadow and make it more prominent on hover
      var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter());
      hoverShadow.opacity = 0.7;
      hoverShadow.blur = 5;
      this.chartObject = chart;
    }
  }
};
</script>
