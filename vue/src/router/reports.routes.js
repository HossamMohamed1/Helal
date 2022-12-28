export default [
  {
    path: "/reports",
    redirect: "reports-employees",
    meta: {
      auth: true
    }
  },
  {
    path: "/reports/employees",
    name: "reports-employees",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "reports-list" */ "@/pages/reports/EmployeesPage.vue"
      )
  },
  {
    path: "/reports/permits",
    name: "reports-permits",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "reports-permits" */ "@/pages/reports/PermitsPage.vue"
      )
  },
  {
    path: "/reports/complaints",
    name: "reports-complaints",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "reports-complaints" */ "@/pages/reports/ComplaintsPage.vue"
      )
  },
  {
    path: "/reports/report-builder",
    name: "report-builder",
    component: () =>
      import(
        /* webpackChunkName: "report-builder" */ "@/pages/reports/ReportBuilderPage.vue"
      )
  },

  {
    path: "/reports/report-builder/create",
    name: "report-builder",
    component: () =>
      import(
        /* webpackChunkName: "report-builder-create" */ "@/pages/reports/CreateReportPage.vue"
      )
  },
  {
    path: "/reports/report-builder/:id",
    name: "show-report-builder",
    component: () =>
      import(
        /* webpackChunkName: "report-builder-show" */ "@/pages/reports/ShowReportBuilderPage.vue"
      )
  }
];
