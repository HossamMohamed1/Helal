const chartOptions = {
  bar: {
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
  },
  line: {
    chart: {
      height: 350,
      type: "line",
      zoom: {
        enabled: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: [2, 2, 2, 2, 2],
      // curve: 'straight',
      curve: "smooth",
      // dashArray: [0, 8, 5]
    },
    title: {
      text: "",
      align: "center",
    },
    legend: {
      tooltipHoverFormatter: function (val, opts) {
        return (
          val +
          " - " +
          opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
          ""
        );
      },
    },
    markers: {
      size: 0,
      hover: {
        sizeOffset: 6,
      },
    },
    xaxis: {
      categories: [],
    },
    colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
    tooltip: {
      y: [
        {
          title: {
            formatter: function (val) {
              return val + " موظف ";
            },
          },
        },
        {
          title: {
            formatter: function (val) {
              return val + " موظف ";
            },
          },
        },
        {
          title: {
            formatter: function (val) {
              return val;
            },
          },
        },
      ],
    },
    grid: {
      borderColor: "#f1f1f1",
    },
  },
  pie: {
    chart: {
      type: "pie",
    },
    labels: [],
    stroke: {
      // colors: ["#29abe2", "#a4a8ad", "#d5d5d5"]
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
  },
};

export default chartOptions;
