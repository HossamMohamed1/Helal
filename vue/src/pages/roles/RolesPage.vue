<template>
  <div class="d-flex flex-column flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t("users.rolesList") }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn color="primary" to="/roles/create">
        {{ $t("users.createRole") }}
      </v-btn>
    </div>
    <!-- roles list -->
    <v-card :loading="isLoading">
      <div v-if="isLoading" class="py-8 text-center">
        <v-progress-circular
          :size="70"
          :width="7"
          indeterminate
        ></v-progress-circular>
      </div>
    </v-card>

    <v-row dense class="">
      <div class="col-md-4 mb-2" v-for="item in roles">
        <v-card class="mx-auto">
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">
              {{ item.display_name }}
            </div>
            <p></p>
            <!-- <p>{{ $t("texts.totalUsersWithThisRole") }}: 5</p> -->
            <div class="d-flex flex-column">
              <div
                v-for="item in item.permissions"
                class="d-flex align-center mb-1 text--primary"
              >
                <span class="bullet bg-primary mx-1"></span>
                {{ item.replace("-", " ") | uppercase }}
              </div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn color="dark" to="/roles/view">
              {{ $t("users.viewRole") }}
            </v-btn>
            <v-btn
              color="dark"
              :to="{ name: 'roles-edit', params: { id: item.id } }"
            >
              {{ $t("users.editRole") }}
            </v-btn>
            <v-btn color="dark" @click.prevent="deleteRole(item)">
              {{ $t("users.deleteRole") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </div>
    </v-row>
  </div>
</template>

<script>
import { ask } from "@/helpers";
import { mapActions, mapState } from "vuex";

export default {
  components: {},
  data() {
    return {
      isLoading: false,
      breadcrumbs: [
        {
          text: this.$t("menu.usersManagement"),
          disabled: false,
          href: "#",
        },
        {
          text: this.$t("users.rolesList"),
        },
      ],

      // roles: []
    };
  },
  computed: {
    ...mapState("roles", ["roles"]),
  },
  mounted() {
    this.open();
  },
  methods: {
    ...mapActions("roles", ["getRoles", "removeRole"]),
    open() {
      this.isLoading = true;
      this.getRoles()
        .then(() => {
          this.isLoading = false;
        })
        .catch(() => {
          this.isLoading = false;
        });
    },
    async deleteRole({ name, id }) {
      const message = `Are you sure to delete role ${name} ?`;
      const { isConfirmed } = await ask(message);
      if (isConfirmed) {
        this.loading = true;
        this.removeRole(id)
          .then(() => {
            this.loading = false;
            this.open();
          })
          .catch(() => {
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
