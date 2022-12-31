import axios from "@/plugins/axios";

const actions = {
  async storeChart({}, data) {
    return await axios.post("charts/create", data);
  },
  async getChartData({ commit, dispatch }, id) {
    const response = await axios.get(`charts/chartFiles/${id}`);
    const files = response?.data?.data ?? [];
    commit("SET_CHART_FILES", files);
    commit("SET_FILE", files[0]);
    let data = {
      file: files[0].file_path
    };
    dispatch("loadFile", data);
  },
  async loadFile({ commit }, data) {
    const response = await axios.post("charts/show-excel", data);
    // console.log(response?.data?.data);
    let file = response?.data?.data;
    commit("SET_FILE_DATA", file);
  },
  async updateFile({}, data) {
    await axios.post("charts/EditExcelData", data);
  },
  async deleteItem({}, data) {
    await axios.post("charts/removeColumn", data);
  },
  async insertItem({}, data) {
    await axios.post("charts/addColumn", data);
  },

  async getChart({ commit }, id) {
    const response = await axios.get(`charts/show/${id}`);
    const chart = response?.data?.chart ?? [];
    console.log(chart)
    commit("SET_CHART", chart);


  },


};

export default actions;
