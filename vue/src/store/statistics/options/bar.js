const bar = {
  chart: {
    type: "bar",
    height: 430,
  },
  plotOptions: {
    bar: {
      dataLabels: {
        position: "top",
      },
    },
  },
  dataLabels: {
    enabled: true,
    offsetX: -6,
    style: {
      fontSize: "12px",
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
  },
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default bar;
