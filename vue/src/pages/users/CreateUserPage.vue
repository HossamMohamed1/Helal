<template>
  <div class="flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t("users.createNewUser") }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
    </div>

    <v-tabs v-model="tab" :show-arrows="false" background-color="transparent">
      <v-tab to="#tabs-account">{{ $t("users.account") }}</v-tab>
      <!-- <v-tab to="#tabs-information">{{ $t("users.information") }}</v-tab> -->
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item value="tabs-account">
        <account-tab
          ref="tabs-account"
          :errors="errors"
          :user="user"
          :loading="loading"
          @createUser="createUser"
        ></account-tab>
      </v-tab-item>

      <!-- <v-tab-item value="tabs-information">
        <information-tab ref="tabs-information" :user="user"></information-tab>
      </v-tab-item> -->
    </v-tabs-items>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import AccountTab from "./CreateUser/AccountTab";
import InformationTab from "./CreateUser/InformationTab";

export default {
  components: {
    AccountTab,
    InformationTab,
  },
  data() {
    return {
      user: {
        id: "",
        email: "",
        name: "",
        username: "",
        password: "",
        confirm_password: "",
      },
      tab: null,
      errors: {},
      loading: false,
      breadcrumbs: [
        {
          text: this.$t("menu.usersManagement"),
          disabled: false,
          href: "#",
        },
        {
          text: this.$t("users.usersList"),
          to: "/users/list",
          exact: true,
        },
        {
          text: this.$t("users.createUser"),
        },
      ],
    };
  },
  methods: {
    ...mapActions("users", ["storeUser"]),
    createUser(form) {
      this.loading = true;
      this.errors = {};
      this.storeUser(form)
        .then(() => {
          this.loading = false;
          this.$router.push({ name: "users-list" });
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status == 422) {
            const { errors } = error?.response?.data ?? {};
            this.errors = errors ?? {};
          }
        });
    },
  },
};
</script>
