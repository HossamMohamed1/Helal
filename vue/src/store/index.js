import Vue from "vue";
import Vuex from "vuex";

// Global vuex
import AppModule from "./app";

// Example Apps
// import BoardModule from "../apps/board/store";
// import EmailModule from "../apps/email/store";
// import TodoModule from "../apps/todo/store";
import Auth from "./auth";
import Users from "./users";
import Report from "./report";
import roles from "./roles";
import Statistics from "./statistics";
Vue.use(Vuex);

/**
 * Main Vuex Store
 */

const store = new Vuex.Store({
  modules: {
    // "board-app": BoardModule,
    // "email-app": EmailModule,
    // "todo-app": TodoModule,
    app: AppModule,
    auth: Auth,
    users: Users,
    roles: roles,
    reports: Report,
    statistics: Statistics
  }
});

export default store;
