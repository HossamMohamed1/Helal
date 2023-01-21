// const pie = {
//   chart: {
//     type: "pie",
//   },
//   labels: [],
//   stroke: {
//     show: true,
//     width: 1,
//     colors: ["#fff"],
//   },
//   plotOptions: {
//     pie: {
//       donut: {
//         labels: {
//           show: true,
//           name: "total",
//           value: 20,
//           size: "65%",
//         },
//       },
//     },
//   },
//   colors: ["#1e8e49", "#c3b086"],
//   legend: {
//     position: "bottom",
//     horizontalAlign: "center",
//   },
//   dataLabels: {
//     enabled: true,
//     style: {
//       fontSize: "12",
//       colors: ["#fff"],
//     },
//   },
//   responsive: [
//     {
//       breakpoint: 480,
//       options: {
//         chart: {
//           width: 200,
//         },
//         legend: {
//           position: "bottom",
//         },
//       },
//     },
//   ],
// };

// export default pie;

const pie = {
  chart: {
    type: "pie",
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
  },
  legend: {
    enabled: true,
  },
  title: {
    text: "",
  },
  tooltip: {
    pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
  },
  accessibility: {
    point: {
      valueSuffix: "%",
    },
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: "pointer",
      dataLabels: {
        enabled: true,
        format: "<b>{point.name}</b>: {point.percentage:.1f} %",
        connectorColor: "silver",
      },
    },
  },
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default pie;
