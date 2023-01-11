import i18n from "@/plugins/vue-i18n";
import chartOptions from "./chartOptions";
import reports from "./reports";
const state = {
  usersPerGender: [],
  usersPerDepartment: [],
  reports,
  cards: [
    {
      id: 1,
      label: i18n.t("employees.employees"),
      color: "#8c9eff",
      loading: false,
      value: 1200,
      percentage: 4.3,
      "percentage-label": i18n.t("dashboard.lastweek"),
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
      label: i18n.t("employees.males"),
      color: "#8c9eff",
      loading: false,
      value: 1200,
      percentage: 4.3,
      "percentage-label": i18n.t("dashboard.lastweek"),
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
      label: i18n.t("employees.females"),
      color: "#8c9eff",
      loading: false,
      value: 310,
      percentage: 16,
      "percentage-label": i18n.t("dashboard.lastweek"),
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
      label: i18n.t("employees.attendees"),
      color: "#8c9eff",
      loading: false,
      value: 310,
      percentage: 16,
      "percentage-label": i18n.t("dashboard.lastweek"),
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
