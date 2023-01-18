import axios from "@/plugins/axios";
const actions = {
  async fetchChart({}, data) {
    const response = await axios.get("report/charts", { params: data });
    return response?.data?.data ?? {};
  },

  async fetchUsers({}) {
    const response = await axios.get("report/employee");

    return response?.data?.emp ?? [];
  },
  async fetchCards({ state, commit }) {
    try {
      let cards = state.cards.map((item) => ({ ...item, loading: true }));
      commit("setCards", cards);
      const response = await axios.get("report/statistics", {
        params: { type: "employee_card" },
      });
      let data = response?.data?.data ?? {};
      console.log(data);
      cards = state.cards.map((item) => ({
        ...item,
        loading: false,
        value: parseFloat(data[item.backend] ?? item.value),
      }));
      commit("setCards", cards);
    } catch (error) {
      let cards = state.cards.map((item) => ({ ...item, loading: false }));
      commit("setCards", cards);
    }
  },
};

export default actions;
