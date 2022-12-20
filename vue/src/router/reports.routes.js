export default [{
  path: '/reports',
  redirect: 'reports-employees'
}, {
  path: '/reports/employees',
  name: 'reports-employees',
  component: () => import(/* webpackChunkName: "reports-list" */ '@/pages/reports/EmployeesPage.vue')
}, {
  path: '/reports/permits',
  name: 'reports-permits',
  component: () => import(/* webpackChunkName: "reports-permits" */ '@/pages/reports/PermitsPage.vue')
}, {
  path: '/reports/complaints',
  name: 'reports-complaints',
  component: () => import(/* webpackChunkName: "reports-complaints" */ '@/pages/reports/ComplaintsPage.vue')
}]
