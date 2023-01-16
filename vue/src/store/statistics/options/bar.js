const bar = {
  chart: {
    type: "bar",
    height: 400,
  },
  plotOptions: {
    bar: {
      dataLabels: {
        position: "top",
      },
      horizontal: false,
      borderRadius: 0,
      columnWidth: "50%",
    },
  },
  dataLabels: {
    enabled: true,
    offsetX: -6,
    style: {
      fontSize: "12",
      colors: ["#fff"],
    },
  },
  stroke: {
    show: true,
    width: 1,
    colors: ["#fff"],
  },
  tooltip: {
    shared: true,
    intersect: false,
  },
  xaxis: {
    categories: [],
    tickPlacement: "on",
  },
  yaxis: {
    reversed: false,
  },
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default bar;
