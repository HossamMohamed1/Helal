const pie = {
  chart: {
    type: "pie",
  },
  labels: [],
  stroke: {
    colors: ["#29abe2", "#a4a8ad", "#d5d5d5"],
  },
  plotOptions: {
    pie: {
      donut: {
        labels: {
          show: true,
          name: "total",
          value: 20,
        },
      },
    },
  },
  colors: ["#1e8e49", "#c3b086"],
  legend: {
    position: "bottom",
    horizontalAlign: "center",
  },
  responsive: [
    {
      breakpoint: 480,
      options: {
        chart: {
          width: 200,
        },
        legend: {
          position: "bottom",
        },
      },
    },
  ],
};

export default pie;
