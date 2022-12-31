<template>
  <div class="aside-config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال Line Chart</div>
      <v-spacer></v-spacer>
      <v-btn icon @click="right = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>

    <v-divider></v-divider>

    <div class="pa-2">
      <div class="font-weight-bold mt-2 mb-1">Color Palette</div>
      <div class="color-palette d-flex">
        <input
          type="color"
          class="color"
          value="#5F4690"
          v-model="config.colors[index]"
          :key="index"
          v-for="(color, index) in config.colors"
        />
      </div>

      <div class="font-weight-bold mt-3 mb-1">Zooming</div>
       <v-row>
       <v-col cols="6">
         <legend>scrollbar X</legend>
         <v-btn-toggle
           v-model="config.zoom.scrollbarX"
           color="primary"
           mandatory
           class="mb-2"
         >
           <v-btn>true</v-btn>
           <v-btn>false</v-btn>
         </v-btn-toggle>
       </v-col>
       <v-col cols="6">
         <legend>Position</legend>
         <v-btn-toggle
           v-model="config.zoom.scrollbarXBottom"
           color="primary"
           mandatory
           class="mb-2"
         >
           <v-btn>top</v-btn>
           <v-btn>bottom</v-btn>
         </v-btn-toggle>
       </v-col>
     </v-row>
       <v-row>
        <v-col cols="6">
          <legend>scrollbar Y</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarY"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>true</v-btn>
            <v-btn>false</v-btn>
          </v-btn-toggle>
        </v-col>
        <v-col cols="6">
          <legend>Position</legend>
          <v-btn-toggle
            v-model="config.zoom.scrollbarYLeft"
            color="primary"
            mandatory
            class="mb-2"
          >
            <v-btn>right</v-btn>
            <v-btn>left</v-btn>
          </v-btn-toggle>
        </v-col>
      </v-row>



      <div class="font-weight-bold mt-3 mb-1">Axis Titles</div>
      <div>
        <legend>X Title</legend>
        <v-text-field
          placeholder="Enter XAxis Title"
          solo
          v-model="config.xLabel.text"
        ></v-text-field>

        <legend>Y Title</legend>
        <v-text-field
          placeholder="Enter YAxis Title"
          solo
          v-model="config.yLabel"
        ></v-text-field>
      </div>


      <div class="font-weight-bold mt-3 mb-1">Chart Title</div>
      <div>
        <legend>Title</legend>
        <v-text-field
          solo
          placeholder="Enter Chart Title"
          v-model="config.title.name"
        ></v-text-field>

        <legend>Font Size</legend>
        <v-text-field
          solo
          v-model="config.title.fontSize"
        ></v-text-field>

        <legend>Font Weight</legend>
        <v-text-field
          solo
          v-model="config.title.fontWeight"
        ></v-text-field>

        <legend>Margin Bottom</legend>
        <v-text-field
          solo
          v-model="config.title.marginBottom"
        ></v-text-field>

        <legend>Color</legend>
        <v-color-picker
          v-model="config.title.fill"
        ></v-color-picker>
      </div>
    </div>

    <v-divider></v-divider>
  </div>
</template>

<script>

export default {
  components: {},
  props: {
    config: {}
  },
  data() {
    return {
      loading: false
    };
  },
  created() {

  },
  watch: {
    config(value) {
      this.config = value;

      // this.chart.config = JSON.parse(this.chart.config);
    },
  },
  mounted() {

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

