import i18n from "@/plugins/vue-i18n";

const state = {
  usersPerGender: [],
  usersPerDepartment: [],
  reports: [],
  cards: [
    {
      label: i18n.t("employees.employees"),
      color: "#8c9eff",
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
      label: i18n.t("employees.males"),
      color: "#8c9eff",
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
      label: i18n.t("employees.males"),
      color: "#8c9eff",
      value: 890,
      percentage: 84,
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
      label: i18n.t("employees.females"),
      color: "#8c9eff",
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
      label: i18n.t("employees.attendees"),
      color: "#8c9eff",
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
};

export default state;
