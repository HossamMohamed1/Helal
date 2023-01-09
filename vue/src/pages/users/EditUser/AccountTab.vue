<template>
  <div class="my-2">
    <div>
      <v-card v-if="user.disabled" class="warning mb-4" light>
        <v-card-title>{{ $t("users.DeleteUser") }}</v-card-title>
        <v-card-subtitle>{{
          $t("users.ThisuserhasbeendisabledLoginaccessshasbeenrevoked")
        }}</v-card-subtitle>
        <v-card-text>
          <v-btn dark @click="user.disabled = false">
            <v-icon left small>mdi-account-check</v-icon>Enable User
          </v-btn>
        </v-card-text>
      </v-card>

      <v-card :loading="loading">
        <v-card-title>{{ $t("users.basicInformation") }}</v-card-title>
        <v-card-text>
          <div class="d-flex flex-column flex-sm-row">
            <div>
              <v-img
                :src="user.avatar"
                aspect-ratio="1"
                class="blue-grey lighten-4 rounded elevation-3"
                max-width="90"
                max-height="90"
              ></v-img>
              <input
                type="file"
                accept="image/*"
                id="update-avatar"
                class="d-none"
              />
              <v-btn class="mt-1" @click.prevent="changeImage()" small>
                {{ $t("users.EditAvatar") }}
              </v-btn>
            </div>
            <div class="flex-grow-1 pt-2 pa-sm-2">
              <v-text-field
                v-model="user.username"
                :label="$t('tables.username')"
                placeholder="username"
                :error-messages="errors['username']"
              ></v-text-field>
              <v-text-field
                v-model="user.name"
                :label="$t('tables.name')"
                placeholder="name"
                :error-messages="errors['name']"
              ></v-text-field>
              <v-text-field
                v-model="user.email"
                :label="$t('tables.email')"
                type="email"
                :error-messages="errors['email']"
              ></v-text-field>

              <!-- <hr /> -->
              <v-text-field
                v-model="user.password"
                :label="$t('check.newpassword')"
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
                :error-messages="errors['password']"
              ></v-text-field>
              <v-text-field
                v-model="user.confirm_password"
                :label="$t('check.confirmation_password')"
                type="password"
                :error-messages="errors['confirm_password']"
              ></v-text-field>

              <div class="mt-2">
                <v-btn
                  @click.prevent="updateProfile()"
                  color="primary"
                  :loading="loading"
                  :disabled="loading"
                >
                  {{ $t("general.save") }}
                </v-btn>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </div>

    <!-- disable modal -->
    <v-dialog v-model="disableDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">{{
          $t("users.DisableUser")
        }}</v-card-title>
        <v-card-text>{{
          $t("users.Areyousureyouwanttodisablethisuser")
        }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="disableDialog = false">Cancel</v-btn>
          <v-btn
            color="warning"
            @click="
              user.disabled = true;
              disableDialog = false;
            "
            >Disable{{ $t("users.DangerZone") }}</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- delete modal -->
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">{{
          $t("users.DeleteUser")
        }}</v-card-title>
        <v-card-text>{{
          $t("users.Areyousureyouwanttodeletethisuser")
        }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="error" @click="deleteDialog = false">{{
            $t("users.Delete")
          }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: () => ({}),
    },
    errors: {
      type: Object,
      default: {},
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      panel: [1],
      deleteDialog: false,
      disableDialog: false,
      avatar: {},
      showPassword: false,
    };
  },
  methods: {
    changeImage() {
      document.getElementById("update-avatar").click();
    },
    updateProfile() {
      const { email, name, password, confirm_password, username } = this.user;
      let data = {
        email,
        name,
        password,
        confirm_password,
        username,
      };
      if (this.avatar.length) {
        data["avatar"] = this.avatar[0];
      }

      let form = this.buildForm(data);
      this.$emit("updateUser", form);
      document.getElementById("update-avatar").files = null;
      this.avatar = {};
    },
    buildForm(data) {
      let keys = Object.keys(data);
      let form = new FormData();
      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        if (data[key]) {
          form.set(key, data[key]);
        }

        if (key == "password" && data["password"]) {
          form.set("confirm_password", data["confirm_password"]);
        }
      }
      return form;
    },
  },
  mounted() {
    document.getElementById("update-avatar").addEventListener("change", (e) => {
      this.avatar = e.target.files;
    });
  },
};
</script>
