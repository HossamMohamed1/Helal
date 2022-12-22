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
  }
];
