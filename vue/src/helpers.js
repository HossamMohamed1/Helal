import Vue from "vue";
export const makeToast = (type, message) => {
  Vue.$toast.open({
    message,
    type,
    position: "bottom"
  });
};
