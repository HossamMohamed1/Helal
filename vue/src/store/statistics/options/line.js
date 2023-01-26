const line = {
  type: "line",
  chart: {
    type: "line", // line || spline
    zoomType: "x",
    inverted: false, // true || false
  },
  title: {
    text: "",
  },
  // subtitle: {
  //   text:
  //     "Source: " +
  //     '<a href="https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature" ' +
  //     'target="_blank">Wikipedia.com</a>',
  // },
  xAxis: {
    reversed: true, // true || false
    categories: [],
    labels: {
      rotation: 0, // -45
    },
  },
  yAxis: {
    title: {
      text: "",
    },
    labels: {
      rotation: 0, // -45
    },
  },
  legend: {
    enabled: true, // true || false
  },
  tooltip: {
    formatter: function () {
      return `${this.series.name} : <b>${this.y}</b>`;
    },
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true,
        formatter: function () {
          return this.y;
        },
      },
      enableMouseTracking: false,
      marker: {
        radius: 4,
        fillColor: "#ff0",
        lineColor: "#1e8e49",
        lineWidth: 1,
        symbol: "diamond", // circle, diamond, square, triangle, triangle-down
      },
    },
    area: {
      dataLabels: {
        enabled: true,
      },
      enableMouseTracking: false,
      marker: {
        radius: 4,
        fillColor: "#ff0",
        lineColor: "#1e8e49",
        lineWidth: 1,
        symbol: "diamond", // circle, diamond, square, triangle, triangle-down
      },
    },
    spline: {
      marker: {
        radius: 4,
        fillColor: "#1e8e49",
        lineColor: "#1e8e49",
        lineWidth: 1,
        symbol: "diamond", // circle, diamond, square, triangle, triangle-down
      },
    },

    series: {
      // step: 'right'
    },
  },
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default line;
