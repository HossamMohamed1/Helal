import axios from "@/plugins/axios";
const actions = {
  async fetchChart({ commit }, data) {
    const response = await axios .get('report/charts',{params:data})
    return response?.data?.data;
  }
};

export default actions;
