export default {
  SET_TOKEN(state, data) {
    state.token = data;
  },
  SET_USER(state, data) {
    state.user = data;
    localStorage.setItem("user", JSON.stringify(data));
  }
};
