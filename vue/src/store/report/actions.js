import axios from "@/plugins/axios";

const actions = {
  async storeChart({}, data) {
    return await axios.post("charts/create", data);
  }
};

export default actions;
