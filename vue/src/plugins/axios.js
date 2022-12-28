import axios from "axios";
import Vue from "vue";
import { makeToast } from "@/helpers";
import store from "@/store";
import router from "@/router";
const token = localStorage.getItem("token");
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["Content-Type"] = 'multipart/form-data';
// 'Content-Type': 'multipart/form-data',
axios.defaults.baseURL =
  process.env.VUE_APP_API_URL ?? "http://haramain.test/backend/public/api";
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
axios.interceptors.response.use(
  function(response) {
    // store.commit('setValidationError', []);

    const meesage = response?.data?.message || response?.data?.msg;
    if (meesage) {
      makeToast("success", meesage);
    }

    return response;
  },
  function(error) {
    const message =
      error?.response?.data?.message || error?.response?.data?.errors?.message;
    if (message && error.response.status !== 401) {
      makeToast("error", message);
    }
    // store.commit("setLoading", false);
    if (error.response && error.response.status === 422) {
      // if (typeof error.response.data.errors != 'undefined')
      // store.commit('setValidationError', error.response.data.errors);
    }
    // access denied
    else if (error.response && error.response.status === 403) {
      //   return router.push({ name: 'denied' });
    }
    // require login
    else if (error.response && error.response.status === 401) {
      // localStorage.removeItem("userInfo");
      // localStorage.removeItem("authInfo");
      // store.commit('setLogout');
      store.commit("auth/SET_TOKEN", "");
      store.commit("auth/SET_USER", {});
      axios.defaults.headers.common["Authorization"] = "";
      return router.push({ name: "auth-signin" });
    }
    // Too Many Requests
    else if (error.response && error.response.status === 429) {
      // store.commit('setLoading', false);
    }
    // General errors / internal server error
    else if (error.response && error.response.status === 500) {
      // store.commit('setError', error)
      // if (error.response.data.message) {
      //     store.commit('setError', null);
      //     store.commit('setError', {
      //         a: null,
      //         code: 500,
      //         message: error.response.data.message,
      //     });
      // }
    } else if (error.response && error.response.status === 520) {
      // store.commit('setError', {
      //     a: null,
      //     code: 520,
      //     message: error.response.data.errors.message,
      // });
      // store.dispatch('refreshUser');
      //   return router.push({ name: 'subscribe.index' });
    } else {
      // store.commit('setLoading', false);
    }
    // throw error;
    return Promise.reject(error);
  }
);

Vue.prototype.$axios = axios;

export default axios;
