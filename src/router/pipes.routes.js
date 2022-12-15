export default [{
  path: '/pipes',
  name: 'pipes-list',
  component: () => import(/* webpackChunkName: "pipes-list" */ '@/pages/models/pipes/PipesPage.vue')
}]
