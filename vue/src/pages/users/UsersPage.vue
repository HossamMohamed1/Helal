<template>
  <div class="d-flex flex-column flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t("users.usersList") }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn color="primary" to="/users/create">
        {{ $t("users.createUser") }}
      </v-btn>
    </div>

    <v-card>
      <!-- users list -->
      <v-row dense class="pa-2 align-center">
        <v-col cols="6">
          <v-menu offset-y left>
            <template v-slot:activator="{ on }">
              <transition name="slide-fade" mode="out-in">
                <v-btn v-show="selectedUsers.length > 0" v-on="on">
                  {{ $t("general.actions") }}
                  <v-icon right>mdi-menu-down</v-icon>
                </v-btn>
              </transition>
            </template>
            <v-list dense>
              <v-list-item>
                <v-list-item-title>
                  {{ $t("general.verify") }}
                </v-list-item-title>
              </v-list-item>

              <v-divider></v-divider>
              <v-list-item>
                <v-list-item-title>
                  {{ $t("general.delete") }}
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
        <v-col cols="6" class="d-flex text-right align-center">
          <v-text-field
            v-model="searchQuery"
            append-icon="mdi-magnify"
            class="flex-grow-1 mr-md-2"
            solo
            hide-details
            dense
            clearable
            :placeholder="$t('general.search')"
            @keyup.enter="searchUser(searchQuery)"
          ></v-text-field>
          <v-btn :loading="isLoading" icon small class="ml-2">
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
        </v-col>
      </v-row>

      <v-data-table
        v-model="selectedUsers"
        show-select
        :headers="headers"
        :items="users"
        :search="searchQuery"
        class="flex-grow-1"
      >
        <template v-slot:item.id="{ item }">
          <div class="font-weight-bold">
            # <copy-label :text="item.id + ''" />
          </div>
        </template>

        <template v-slot:item.email="{ item }">
          <div class="d-flex align-center py-1">
            <v-avatar size="32" class="elevation-1 grey lighten-3">
              <v-img :src="item.avatar" />
            </v-avatar>
            <div class="ml-1 caption font-weight-bold">
              <copy-label :text="item.email" />
            </div>
          </div>
        </template>

        <template v-slot:item.verified="{ item }">
          <v-icon v-if="item.verified" small color="success">
            mdi-check-circle
          </v-icon>
          <v-icon v-else small>
            mdi-circle-outline
          </v-icon>
        </template>

        <template v-slot:item.disabled="{ item }">
          <div>
            {{ item.email_verified_at ? "true" : "false" | capitalize }}
          </div>
        </template>

        <template v-slot:item.role="{ item }">
          <v-chip
            label
            small
            v-for="(item, index) in item.roles"
            :key="index"
            class="font-weight-bold"
            :color="item.display_name === 'Admin' ? 'primary' : undefined"
          >
            {{ item.display_name }}
          </v-chip>
        </template>

        <template v-slot:item.created_at="{ item }">
          <div>{{ item.created_at | formatDate("lll") }}</div>
        </template>

        <template v-slot:item.action="{ item }">
          <div class="actions">
            <v-btn icon :to="`/users/edit/${item.id}`">
              <v-icon>mdi-open-in-new</v-icon>
            </v-btn>
          </div>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import CopyLabel from "../../components/common/CopyLabel";

export default {
  components: {
    CopyLabel
  },
  data() {
    return {
      isLoading: false,
      breadcrumbs: [
        {
          text: this.$t("menu.usersManagement"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("users.usersList")
        }
      ],

      searchQuery: "",
      selectedUsers: [],
      headers: [
        { text: this.$t("tables.id"), value: "id" },
        { text: this.$t("tables.email"), value: "email" },
        { text: this.$t("tables.verified"), value: "verified" },
        { text: this.$t("tables.name"), value: "name" },
        { text: this.$t("tables.role"), value: "role" },
        { text: this.$t("tables.created"), value: "created_at" },
        // { text: this.$t("tables.lastSignIn"), value: "lastSignIn" },
        { text: this.$t("tables.disabled"), value: "disabled" },
        { text: "", sortable: false, align: "right", value: "action" }
      ]
    };
  },
  watch: {
    selectedUsers(val) {}
  },

  computed: {
    ...mapState("users", ["users"])
  },
  mounted() {
    this.open();
  },
  methods: {
    ...mapActions("users", ["getUsers"]),
    open() {
      this.getUsers();
    },
    searchUser() {}
  }
};
</script>

<style lang="scss" scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>
