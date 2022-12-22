export default [
  {
    path: "/roles",
    redirect: "roles-list",
    meta: {
      auth: true
    }
  },
  {
    path: "/roles/list",
    name: "roles-list",
    meta: {
      auth: true
    },
    component: () =>
      import(/* webpackChunkName: "roles-list" */ "@/pages/roles/RolesPage.vue")
  },
  {
    path: "/roles/edit",
    name: "roles-edit",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "roles-edit" */ "@/pages/roles/EditRolePage.vue"
      )
  },
  {
    path: "/roles/create",
    name: "roles-create",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "roles-create" */ "@/pages/roles/CreateRolePage.vue"
      )
  },
  {
    path: "/roles/view",
    name: "roles-view",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "roles-view" */ "@/pages/roles/ViewRolePage.vue"
      )
  }
];
