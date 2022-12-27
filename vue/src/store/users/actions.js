import axios from "@/plugins/axios";

const actions = {
  async getUsers({ commit }) {
    const response = await axios.get("users");
    const { users } = response?.data;
    commit("SET_USERS", users);
  }
};

export default actions;
