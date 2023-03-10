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
  type: "pie",
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
    enabled: true,
    formatter: function () {
      // console.log(this);
      return `<b>${this.y}</b>`;
    },
    // },
    // pointFormat: "{series.name}: <b>{point.y}</b>",
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
        // format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        formatter: function () {
          const point = this.point;
          return (
            '<span style="color: ' +
            point.color +
            '">' +
            point.name +
            ": " +
            Math.round(point.percentage) +
            "%</span>"
          );
        },
        connectorColor: "silver",
      },
      showInLegend: true,
      borderColor: "#fffs",
      borderWidth: 1,
    },
  },
  series: [
    {
      minPointSize: 10,
      innerSize: "20%",
      zMin: 0,
    },
  ],
  raduis: {
    minPointSize: 10,
    innerSize: "30%",
    zMin: 0,
  },
  colors: ["#1e8e49", "#c3b086", "#a7a7a7", "#fd9162", "#41b27b", "#c9de77"],
};

export default pie;
