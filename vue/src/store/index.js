import Vue from "vue";
import Vuex from "vuex";

// Global vuex
import AppModule from "./app";

// Example Apps
// import BoardModule from "../apps/board/store";
// import EmailModule from "../apps/email/store";
// import TodoModule from "../apps/todo/store";
import Auth from "./auth";
Vue.use(Vuex);

/**
 * Main Vuex Store
 */

const store = new Vuex.Store({
  modules: {
    app: AppModule,
    // "board-app": BoardModule,
    // "email-app": EmailModule,
    // "todo-app": TodoModule,
    auth: Auth
  }
});

export default store;
