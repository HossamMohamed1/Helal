export default [{
  path: '/roles',
  redirect: 'roles-list'
}, {
  path: '/roles/list',
  name: 'roles-list',
  component: () => import(/* webpackChunkName: "roles-list" */ '@/pages/roles/RolesPage.vue')
}, {
  path: '/roles/edit',
  name: 'roles-edit',
  component: () => import(/* webpackChunkName: "roles-edit" */ '@/pages/roles/EditRolePage.vue')
}, {
  path: '/roles/create',
  name: 'roles-create',
  component: () => import(/* webpackChunkName: "roles-create" */ '@/pages/roles/CreateRolePage.vue')
}, {
  path: '/roles/view',
  name: 'roles-view',
  component: () => import(/* webpackChunkName: "roles-view" */ '@/pages/roles/ViewRolePage.vue')
}]
