<template>
  <div class="flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t("users.createNewUser") }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </div>

    <v-tabs v-model="tab" :show-arrows="false" background-color="transparent">
      <v-tab to="#tabs-account">{{ $t("users.account") }}</v-tab>
      <v-tab to="#tabs-information">{{ $t("users.information") }}</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item value="tabs-account">
        <account-tab ref="tabs-account" :user="user"></account-tab>
      </v-tab-item>

      <v-tab-item value="tabs-information">
        <information-tab ref="tabs-information" :user="user"></information-tab>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
import AccountTab from "./CreateUser/AccountTab";
import InformationTab from "./CreateUser/InformationTab";

export default {
  components: {
    AccountTab,
    InformationTab
  },
  data() {
    return {
      user: {
        id: 32,
        email: "f.almunimi@gph.gov.sa",
        name: "فيصل المنعمي",
        verified: false,
        created: "2019-08-09T03:14:12Z",
        lastSignIn: "2019-08-14T20:00:53Z",
        disabled: true,
        role: "ADMIN",
        avatar: "/images/avatars/avatar1.svg"
      },
      tab: null,
      breadcrumbs: [
        {
          text: this.$t("menu.usersManagement"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("users.usersList"),
          to: "/users/list",
          exact: true
        },
        {
          text: this.$t("users.createUser")
        }
      ]
    };
  }
};
</script>
