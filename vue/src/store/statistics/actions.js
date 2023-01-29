import axios from "@/plugins/axios";
const actions = {
  async fetchChart({}, data) {
    // return {
    //   bar: {
    //     labels: [
    //       "25 - 29",
    //       "30 - 34",
    //       "35 - 39",
    //       "40 - 44",
    //       "45 - 49",
    //       "50 - 54",
    //       "55 - 59",
    //       "60 - فيما اكبر",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: [136, 1130, 1220, 1251, 870, 433, 384, 362],
    //       },
    //     ],
    //   },
    //   line: {
    //     labels: [
    //       "25 - 29",
    //       "30 - 34",
    //       "35 - 39",
    //       "40 - 44",
    //       "45 - 49",
    //       "50 - 54",
    //       "55 - 59",
    //       "60 - فيما اكبر",
    //     ],
    //     result: [
    //       {
    //         name: "العدد",
    //         data: [136, 1130, 1220, 1251, 870, 433, 384, 362],
    //       },
    //     ],
    //   },
    //   pie: {
    //     labels: [
    //       "25 - 29",
    //       "30 - 34",
    //       "35 - 39",
    //       "40 - 44",
    //       "45 - 49",
    //       "50 - 54",
    //       "55 - 59",
    //       "60 - فيما اكبر",
    //     ],
    //     result: [136, 1130, 1220, 1251, 870, 433, 384, 362],
    //   },
    // };
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
