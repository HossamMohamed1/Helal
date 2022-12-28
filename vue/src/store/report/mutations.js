const mutations = {
  SET_CHARTS(state, value) {
    state.charts = value;
  },
  SET_CHART(state, value) {
    state.chart = value;
  },
  SET_CHART_FILES(state, value) {
    state.chartFiles = value;
  },
  SET_FILE(state, value) {
    state.file = value;
  },
  SET_FILE_DATA(state, value) {
    state.fileData = value;
  }
};
export default mutations;
