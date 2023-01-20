// const line = {
//   chart: {
//     height: 350,
//     type: "line",
//     zoom: {
//       enabled: true,
//       type: "x",
//     },
//   },
//   dataLabels: {
//     enabled: false,
//   },
//   stroke: {
//     width: [2, 2, 2, 2, 2],
//     // curve: 'straight',
//     curve: "smooth",
//     dashArray: 0,
//     // dashArray: [0, 8, 5]
//   },
//   title: {
//     text: "",
//     align: "center",
//   },
//   legend: {
//     tooltipHoverFormatter: function (val, opts) {
//       return (
//         val +
//         " - " +
//         opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
//         ""
//       );
//     },
//   },
//   markers: {
//     size: 0,
//     shape: "circle",
//     hover: {
//       sizeOffset: 6,
//     },
//   },
//   xaxis: {
//     categories: [],
//   },
//   colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
//   tooltip: {
//     y: [
//       {
//         title: {
//           formatter: function (val) {
//             return val;
//           },
//         },
//       },
//       {
//         title: {
//           formatter: function (val) {
//             return val;
//           },
//         },
//       },
//       {
//         title: {
//           formatter: function (val) {
//             return val;
//           },
//         },
//       },
//     ],
//   },
//   grid: {
//     borderColor: "#f1f1f1",
//   },
// };

// export default line;

const line = {
  chart: {
    type: "spline",
    zoomType: "x",
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
    categories: [],
  },
  yAxis: {
    title: {
      text: "",
    },
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true,
      },
      enableMouseTracking: false,
    },
  },
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default line;
