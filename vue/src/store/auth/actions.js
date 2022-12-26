import axios from "@/plugins/axios";
import router from "@/router";

export default {
  async login({ commit }, data) {
    try {
      const response = await axios.post("login", data);
      const { token, user } = response?.data;
      commit("SET_TOKEN", token);
      commit("SET_USER", user);
      localStorage.setItem("token", token);
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      router.push("/");
    } catch (error) {
      throw error;
    }
  },

  async user({ commit }) {
    try {
      const response = await axios.get("user");
      const { user } = response?.data ?? {};
      commit("SET_USER", user);
    } catch (error) {}
  },
  async logout({ commit }) {
    try {
      await axios.get("logout");
      commit("SET_TOKEN", "");
      commit("SET_USER", {});
      router.push({ name: "auth-signin" });
    } catch (error) {}
  },
  async editProfile({ commit }, data) {
    const response = await axios.post("updateProfile", data);
    const { user } = response?.data ?? {};
    commit("SET_USER", user);
  }
};
