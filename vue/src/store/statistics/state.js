import chartOptions from "./chartOptions";
import reports from "./reports";
const state = {
  usersPerGender: [],
  usersPerDepartment: [],
  reports,
  chartOptions,
  cards: [
    {
      backend: "emps",
      label: "employees.employees",
      color: "#8c9eff",
      loading: false,
      value: 0,
    },
    {
      backend: "males",
      label: "employees.males",
      color: "#8c9eff",
      loading: false,
      value: 0,
    },
    {
      backend: "females",
      label: "employees.females",
      color: "#8c9eff",
      loading: false,
      value: 0,
    },
    {
      backend: "attendees",
      label: "employees.attendees",
      color: "#8c9eff",
      loading: false,
      value: 0,
    },
  ],
};

export default state;
