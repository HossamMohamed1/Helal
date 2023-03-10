import Vue from "vue";
import App from "./App.vue";

// VUEX - https://vuex.vuejs.org/
import store from "./store";

// VUE-ROUTER - https://router.vuejs.org/
import router from "./router";

// PLUGINS
import vuetify from "./plugins/vuetify";
import i18n from "./plugins/vue-i18n";
import "./plugins/vue-google-maps";
import "./plugins/vue-shortkey";
import "./plugins/vue-head";
import "./plugins/vue-gtag";
import "./plugins/apexcharts";
import "./plugins/echarts";
import "@/plugins/hightchart";
import "./plugins/animate";
import "./plugins/clipboard";
import "./plugins/moment";
import "./plugins/ckeditor";
import "./plugins/vue-ctk-date-time-picker";
import "./plugins/vue-gates";

// FILTERS
import "./filters/capitalize";
import "./filters/lowercase";
import "./filters/uppercase";
import "./filters/formatCurrency";
import "./filters/formatDate";
import "@/plugins/axios";
import "@/plugins/toast";
// STYLES
// Main Theme SCSS
import "./assets/scss/theme.scss";

// Animation library - https://animate.style/
import "animate.css/animate.min.css";
import mixins from "./mixins";

// Set this to false to prevent the production tip on Vue startup.
Vue.config.productionTip = false;
import { Network } from "vue-vis-network";
Vue.component("network", Network);
// Laravel Echo

/*
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js')

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'ABCDEFG',
  //encrypted: true,
  wsHost: '192.168.1.7',
  wsPort: 6001,
  wssport: 6001,
  transports: ['websocket'],
  enabledTransports: ['ws', 'wss'],
  forceTLS: false,
  disableStats: true
})
*/

/*
|---------------------------------------------------------------------
| Main Vue Instance
|---------------------------------------------------------------------
|
| Render the vue application on the <div id="app"></div> in index.html
|
| https://vuejs.org/v2/guide/instance.html
|
*/
export default new Vue({
  mixins: [mixins],
  i18n,
  vuetify,
  router,
  store,
  render: (h) => h(App),
  // data() {
  //   return {
  //     public_path: process.env.VUE_APP_PUBLIC_DIR
  //   };
  // },
  created() {
    if (window.location.pathname != "/auth/signin") {
      store
        .dispatch("auth/user")
        .then(() => {
          const user = this.$store.state.auth.user;
          const roles = user.roles.map((item) => item.name);
          const permissions = user.permissions.map((item) => item.name);
          this.$gates.setRoles(roles);
          this.$gates.setPermissions(permissions);
        })
        .catch((err) => {
          // console.log(err);
        });
    }
  },
}).$mount("#app");
