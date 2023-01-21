const area = {
  chart: {
    type: "area",
    zoomType: "x",
    scrollablePlotArea: {
      minWidth: 600,
      scrollPositionX: 1,
    },
  },
  title: {
    text: "",
  },
  xAxis: {
    categories: [],
  },
  yAxis: {
    title: {
      text: null,
    },
  },
  tooltip: {
    crosshairs: true,
    shared: true,
    valueSuffix: "",
    xDateFormat: "%A, %b %e",
  },
  legend: {
    enabled: true,
  },
  series: [
    {
      name: "Tallinn",
      data: [],
    },
  ],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default area;
