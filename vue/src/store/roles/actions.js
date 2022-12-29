import axios from "@/plugins/axios";
const actions = {
  async getRoles({ commit }) {
    commit("SET_ROLES", []);
    const response = await axios.get("roles");
    const roles = response?.data?.data ?? [];
    commit("SET_ROLES", roles);
  }
};

export default actions;
