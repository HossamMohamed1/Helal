const column = {
  chart: {
    type: "column",
    zoomType: "x",
  },
  title: {
    text: "",
  },
  // subtitle: {
  //   text: "Source: WorldClimate.com",
  // },
  xAxis: {
    categories: [],
    crosshair: true,
  },
  yAxis: {
    min: 0,
    title: {
      text: "",
    },
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat:
      '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
    footerFormat: "</table>",
    shared: true,
    useHTML: true,
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0,
    },
  },
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default column;
