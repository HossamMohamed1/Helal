import chartOptions from "./chartOptions";
import reports from "./reports";
const state = {
  usersPerGender: [],
  usersPerDepartment: [],
  reports,
  cards: [
    {
      id: 1,
      label: "employees.employees",
      color: "#8c9eff",
      loading: false,
      value: 1200,
      ordersSeries: [
        {
          name: "Orders",
          data: [
            ["2020-02-02", 34],
            ["2020-02-03", 43],
            ["2020-02-04", 40],
            ["2020-02-05", 43],
          ],
        },
      ],
    },
    {
      id: 2,
      label: "employees.males",
      color: "#8c9eff",
      loading: false,
      value: 1200,
      ordersSeries: [
        {
          name: "Orders",
          data: [
            ["2020-02-02", 34],
            ["2020-02-03", 43],
            ["2020-02-04", 40],
            ["2020-02-05", 43],
          ],
        },
      ],
    },
    {
      id: 3,
      label: "employees.females",
      color: "#8c9eff",
      loading: false,
      value: 310,
      ordersSeries: [
        {
          name: "Orders",
          data: [
            ["2020-02-02", 34],
            ["2020-02-03", 43],
            ["2020-02-04", 40],
            ["2020-02-05", 43],
          ],
        },
      ],
    },
    {
      id: 4,
      label: "employees.attendees",
      color: "#8c9eff",
      loading: false,
      value: 310,
      ordersSeries: [
        {
          name: "Orders",
          data: [
            ["2020-02-02", 34],
            ["2020-02-03", 43],
            ["2020-02-04", 40],
            ["2020-02-05", 43],
          ],
        },
      ],
    },
  ],
  chartOptions,
};

export default state;
