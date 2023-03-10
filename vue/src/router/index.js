import Vue from "vue";
import Router from "vue-router";
// Routes
import AppsRoutes from "./apps.routes";
import UIRoutes from "./ui.routes";
import PagesRoutes from "./pages.routes";
import UsersRoutes from "./users.routes";
import RolesRoutes from "./roles.routes";
import EcommerceRoutes from "./ecommerce.routes";
import LandingRoutes from "./landing.routes";
import SettingsRoutes from "./settings.routes";
import ReportsRoutes from "./reports.routes";
import PipesRoutes from "./pipes.routes";
import store from "@/store";

Vue.use(Router);

export const routes = [
  {
    path: "/",
    redirect: "/dashboard/analytics",
    meta: {
      auth: true,
    },
  },
  {
    path: "/dashboard/analytics",
    name: "dashboard-analytics",
    meta: {
      auth: true,
    },
    component: () =>
      import(
        /* webpackChunkName: "dashboard" */ "@/pages/dashboard/DashboardPage.vue"
      ),
  },
  ...AppsRoutes,
  ...UIRoutes,
  ...PagesRoutes,
  ...UsersRoutes,
  ...RolesRoutes,
  ...EcommerceRoutes,
  ...LandingRoutes,
  ...SettingsRoutes,
  ...ReportsRoutes,
  ...PipesRoutes,
  {
    path: "/blank",
    name: "blank",
    component: () =>
      import(/* webpackChunkName: "blank" */ "@/pages/BlankPage.vue"),
  },
  {
    path: "*",
    name: "error",
    component: () =>
      import(/* webpackChunkName: "error" */ "@/pages/error/NotFoundPage.vue"),
    meta: {
      layout: "error",
    },
  },
];

const router = new Router({
  mode: "history",
  base: process.env.VUE_APP_SUB_DIR || "/",
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition;

    return { x: 0, y: 0 };
  },
  routes,
});

/**
 * Before each route update
 */
router.beforeEach((to, from, next) => {
  const token = store.state.auth.token;

  if (!token && to.meta.auth) {
    return next({ name: "auth-signin" });
  }

  return next();
});

/**
 * After each route update
 */
router.afterEach((to, from) => {});

export default router;
