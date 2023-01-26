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
    crosshair: false,
    labels: {
      rotation: -45,
      style: {
        fontSize: "13px",
        fontFamily: "Verdana, sans-serif",
      },
    },
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
    formatter: function () {
      return `${this.series.name} : <b>${this.y}</b>`;
    },
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0,
    },
  },
  series: [
    {
      dataLabels: {
        enabled: true,
        rotation: -90,
        color: "#FFFFFF",
        align: "right",
        format: "{point.y:.1f}", // one decimal
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

export default column;
