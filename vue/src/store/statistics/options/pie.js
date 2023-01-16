const pie = {
  chart: {
    type: "pie",
  },
  labels: [],
  stroke: {
    show: true,
    width: 1,
    colors: ["#fff"],
  },
  plotOptions: {
    pie: {
      donut: {
        labels: {
          show: true,
          name: "total",
          value: 20,
            size: '65%'
        },
      },
    },
  },
  colors: ["#1e8e49", "#c3b086"],
  legend: {
    position: "bottom",
    horizontalAlign: "center",
  },
  dataLabels: {
    enabled: true,
    style: {
      fontSize: "12px",
      colors: ["#fff"],
    },

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
