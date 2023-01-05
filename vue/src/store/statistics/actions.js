import axios from "@/plugins/axios";
const actions = {
  async fetchChart({ commit }, data) {
    const response = await axios.get("report/charts", { params: data });
    return response?.data?.data;
  },
  async fetchUsers({}) {
    const response = await axios.get("report/employee");

    return response?.data?.emp;
  }
};

export default actions;
