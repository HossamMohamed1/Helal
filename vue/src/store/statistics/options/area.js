const area = {
  type: "area",
  chart: {
    type: "area",
    zoomType: "x",
    scrollablePlotArea: {
      minWidth: 600,
      scrollPositionX: 1,
    },
  },
  title: {
    text: "",
  },
  xAxis: {
    reversed: true, // true || false
    categories: [],
    labels: {
      rotation: 0, // -45
    }
  },
  yAxis: {
    title: {
      text: "",
    },
    labels: {
      rotation: 0, // -45
    }
  },
  legend: {
    enabled: true // true || false
  },
  plotOptions: {
    area: {
      dataLabels: {
        enabled: true,
      },
      enableMouseTracking: false,
      marker: {
        radius: 4,
        fillColor: '#ff0',
        lineColor: '#1e8e49',
        lineWidth: 1,
        symbol: 'diamond' // circle, diamond, square, triangle, triangle-down
      }
    },
    series: {
      // step: 'right'
    }
  },
  series: [],
  colors: ["#1e8e49", "#fd9162", "#a7a7a7", "#41b27b", "#c9de77"],
};

export default area;
