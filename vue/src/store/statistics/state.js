import chartOptions from "./chartOptions";
import reports from "./reports";
const state = {
  usersPerGender: [],
  usersPerDepartment: [],
  reports,
  cards: [
    {
      backend: "emps",
      label: "employees.employees",
      color: "#8c9eff",
      loading: false,
      value: 0,
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
      backend: "males",
      label: "employees.males",
      color: "#8c9eff",
      loading: false,
      value: 0,
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
      backend: "females",
      label: "employees.females",
      color: "#8c9eff",
      loading: false,
      value: 0,
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
      backend: "attendees",
      label: "employees.attendees",
      color: "#8c9eff",
      loading: false,
      value: 0,
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
