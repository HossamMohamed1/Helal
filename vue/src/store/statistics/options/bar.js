const bar = {
  type: "bar",
  chart: {
    type: "column",
    zoomType: "x",
    // inverted: true
  },
  title: {
    text: "",
    // align: "left",
  },

  xAxis: {
    categories: [],
    title: {
      text: null,
    },
    reversed: false, // true || false
    labels: {
      rotation: 0, // -45
      // style: {
      //   fontSize: '12px',
      // }
    },
  },
  yAxis: {
    min: 0,
    title: {
      text: "",
      align: "high",
    },
    labels: {
      overflow: "justify",
      rotation: 0, // -45
      // style: {
      //   fontSize: '12px',
      // }
    },
  },
  tooltip: {
    enabled: true,
    formatter: function () {
      return `${this.series.name} : <b>${this.y}</b>`;
    },
  },
  plotOptions: {
    bar: {
      dataLabels: {
        enabled: false,
        formatter: function () {
          return this.y;
        },
      },
    },
    series: {
      // pointWidth: 40,
      borderRadius: 10,
      borderRadiusTopLeft: 8,
      borderRadiusTopRight: 8,
    },
  },
  legend: {
    // layout: "vertical",
    // align: "right",
    // verticalAlign: "top",
    // x: -40,
    // y: 80,
    // floating: false,
    // borderWidth: 1,
    // backgroundColor: "#FFFFFF",
    // shadow: true,
  },
  credits: {
    enabled: false,
  },
  series: [
    {
      dataLabels: {
        enabled: true,
        rotation: -90,
        color: "#FFFFFF",
        align: "right",
        format: "{point.y:1f}", // one decimal
        y: 10, // 10 pixels down from the top
        style: {
          fontSize: "13px",
          fontFamily: "Verdana, sans-serif",
        },
      },
    },
  ],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default bar;
