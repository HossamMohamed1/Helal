import axios from "@/plugins/axios";

const actions = {
  async getUsers({ commit }) {
    const response = await axios.get("users");
    const { users } = response?.data;
    commit("SET_USERS", users);
  },
  async getUser({ commit }, id) {
    // console.log(id);
    const response = await axios.get(`users/${id}`);
    // console.log(response?.data);
    const { user } = response?.data;
    commit("SET_USER", user);
  },
  async deleteUser({ commit, dispatch }, id) {
    await axios.delete(`users/${id}`);
    await dispatch("getUsers");
  },
  async updateUser({ state }, form) {
    const { id } = state?.user ?? {};
    await axios.post(`users/${id}`, form);
  },
  async storeUser({ commit }, data) {
    return await axios.post(`users`, data);
  }
};

export default actions;
