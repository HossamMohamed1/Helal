// const bar = {
//   chart: {
//     type: "bar",
//     height: 400,
//   },
//   plotOptions: {
//     bar: {
//       dataLabels: {
//         position: "top",
//       },
//       horizontal: false,
//       borderRadius: 0,
//       columnWidth: "50%",
//     },
//   },
//   dataLabels: {
//     enabled: true,
//     offsetX: -6,
//     style: {
//       fontSize: "12",
//       colors: ["#fff"],
//     },
//   },
//   stroke: {
//     show: true,
//     width: 1,
//     colors: ["#fff"],
//   },
//   tooltip: {
//     shared: true,
//     intersect: false,
//   },
//   xaxis: {
//     categories: [],
//     tickPlacement: "on",
//   },
//   yaxis: {
//     reversed: false,
//   },
//   colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
// };

// export default bar;

const bar = {
  chart: {
    type: "bar",
    zoomType: "x",
  },
  title: {
    text: "",
    // align: "left",
  },
  // subtitle: {
  //   text:
  //     "Source: <a " +
  //     'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
  //     'target="_blank">Wikipedia.org</a>',
  //   align: "left",
  // },
  xAxis: {
    categories: [],
    title: {
      text: null,
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
    },
  },
  tooltip: {
    valueSuffix: " ",
  },
  plotOptions: {
    bar: {
      dataLabels: {
        enabled: true,
      },
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
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default bar;
