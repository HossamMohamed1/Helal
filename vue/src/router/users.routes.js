export default [
  {
    path: "/users",
    redirect: "users-list",
    meta: {
      auth: true
    }
  },
  {
    path: "/users/list",
    name: "users-list",
    meta: {
      auth: true
    },
    component: () =>
      import(/* webpackChunkName: "users-list" */ "@/pages/users/UsersPage.vue")
  },
  {
    path: "/users/edit",
    name: "users-edit",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "users-edit" */ "@/pages/users/EditUserPage.vue"
      )
  },
  {
    path: "/users/edit/:id",
    name: "users-list-edit",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "users-edit" */ "@/pages/users/EditUserListPage.vue"
      )
  },
  {
    path: "/users/create",
    name: "users-create",
    meta: {
      auth: true
    },
    component: () =>
      import(
        /* webpackChunkName: "users-create" */ "@/pages/users/CreateUserPage.vue"
      )
  }
];
