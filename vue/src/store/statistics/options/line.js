const line = {
  chart: {
    height: 350,
    type: "line",
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: [2, 2, 2, 2, 2],
    // curve: 'straight',
    curve: "smooth",
    // dashArray: [0, 8, 5]
  },
  title: {
    text: "",
    align: "center",
  },
  legend: {
    tooltipHoverFormatter: function (val, opts) {
      return (
        val +
        " - " +
        opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
        ""
      );
    },
  },
  markers: {
    size: 0,
    hover: {
      sizeOffset: 6,
    },
  },
  xaxis: {
    categories: [],
  },
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
  tooltip: {
    y: [
      {
        title: {
          formatter: function (val) {
            return val;
          },
        },
      },
      {
        title: {
          formatter: function (val) {
            return val;
          },
        },
      },
      {
        title: {
          formatter: function (val) {
            return val;
          },
        },
      },
    ],
  },
  grid: {
    borderColor: "#f1f1f1",
  },
};

export default line;
