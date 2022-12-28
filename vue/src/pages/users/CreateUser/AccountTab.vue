<template>
  <div class="my-2">
    <div>
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
                :loading="loading"
              />
              <input
                type="file"
                accept="image/*"
                id="update-avatar"
                class="d-none"
              />
              <v-btn
                @click.prevent="changeImage()"
                :loading="loading"
                :disabled="loading"
                class="mt-1"
                small
              >
                {{ $t("users.EditAvatar") }}
              </v-btn>
            </div>
            <div class="flex-grow-1 pt-2 pa-sm-2">
              <v-text-field
                v-model="user.username"
                :label="$t('tables.username')"
                :error-messages="errors['username']"
              ></v-text-field>
              <v-text-field
                v-model="user.name"
                :label="$t('tables.name')"
                :error-messages="errors['name']"
              ></v-text-field>
              <v-text-field
                v-model="user.email"
                :label="$t('tables.email')"
                :error-messages="errors['email']"
              ></v-text-field>
              <v-text-field
                v-model="user.password"
                :label="$t('general.password')"
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
                  :loading="loading"
                  :disabled="loading"
                  @click="updateProfile"
                  color="primary"
                >
                  {{ $t("general.save") }}
                </v-btn>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: () => ({})
    },
    errors: {
      type: Object,
      default: () => {}
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      showPassword: false,
      avatar: {}
    };
  },
  methods: {
    changeImage() {
      document.getElementById("update-avatar").click();
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
    updateProfile() {
      const { email, name, password, confirm_password, username } = this.user;
      let data = {
        email,
        name,
        password,
        confirm_password,
        username
      };
      if (this.avatar.length) {
        data["avatar"] = this.avatar[0];
      }

      let form = this.buildForm(data);
      this.$emit("createUser", form);
      document.getElementById("update-avatar").files = null;
      this.avatar = {};
    }
  },
  mounted() {
    document.getElementById("update-avatar").addEventListener("change", e => {
      this.avatar = e.target.files;
    });
  }
};
</script>
