import { sleep } from "@/helpers";
const actions = {
  async fetchChart({ commit }, data) {
    await sleep(2000);
    return data;
  }
};

export default actions;
