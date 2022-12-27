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

      <v-card>
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
                v-model="user.name"
                :label="$t('tables.name')"
                placeholder="name"
              ></v-text-field>
              <v-text-field
                v-model="user.email"
                :label="$t('tables.email')"
                hide-details
              ></v-text-field>

              <!-- <hr /> -->
              <v-text-field
                v-model="user.password"
                :label="$t('check.newpassword')"
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
              ></v-text-field>
              <v-text-field
                v-model="user.confirm_password"
                :label="$t('check.confirmation_password')"
                type="password"
              ></v-text-field>

              <!-- <div class="d-flex flex-column">
                <v-checkbox
                  v-model="user.verified"
                  dense
                  :label="$t('users.emailVerified')"
                ></v-checkbox>
                <div>
                  <v-btn v-if="!user.verified">
                    <v-icon left small>mdi-email</v-icon>
                    {{ $t("users.sendVerificationEmail") }}
                  </v-btn>
                </div>
              </div> -->

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

      <!-- <v-expansion-panels v-model="panel" multiple class="mt-3">
        <v-expansion-panel>
          <v-expansion-panel-header class="title">{{
            $t("tables.actions")
          }}</v-expansion-panel-header>
          <v-expansion-panel-content>
            <div class="mb-2">
              <div class="title">{{ $t("users.ResetUserPassword") }}</div>
              <div class="subtitle mb-2">
                {{ $t("users.Sendsaresetpasswordemailtotheuser") }}
              </div>
              <v-btn class="mb-2">
                <v-icon left small>mdi-email</v-icon
                >{{ $t("users.SendResetPasswordEmail") }}
              </v-btn>
            </div>

            <v-divider></v-divider>

            <div class="my-2">
              <div class="title">{{ $t("users.ExportAccountData") }}</div>
              <div class="subtitle mb-2">
                {{ $t("users.Exportalltheplatformmetadataforthisuser") }}
              </div>
              <v-btn class="mb-2">
                <v-icon left small>mdi-clipboard-account</v-icon
                >{{ $t("users.ExportUserData") }}
              </v-btn>
            </div>

            <v-divider></v-divider>

            <div class="my-2">
              <div class="error--text title">{{ $t("users.DangerZone") }}</div>
              <div class="subtitle mb-2">
                {{ $t("users.Fulladministratorwithaccesstothisdashboard") }}
              </div>

              <div class="my-2">
                <v-btn
                  v-if="user.role === 'ADMIN'"
                  color="primary"
                  @click="user.role = 'USER'"
                >
                  <v-icon left small>mdi-security</v-icon
                  >{{ $t("users.Removeadminaccess") }}
                </v-btn>
                <v-btn v-else color="primary" @click="user.role = 'ADMIN'">
                  <v-icon left small>mdi-security</v-icon
                  >{{ $t("users.SetUserasAdmin") }}
                </v-btn>
              </div>

              <v-divider></v-divider>

              <div class="subtitle mt-3 mb-2">
                {{ $t("users.Preventtheuserfromsigninginontheplatform") }}
              </div>
              <div class="my-2">
                <v-btn
                  v-if="user.disabled"
                  color="warning"
                  @click="user.disabled = false"
                >
                  <v-icon left small>mdi-account-check</v-icon
                  >{{ $t("users.EnableUser") }}
                </v-btn>
                <v-btn v-else color="warning" @click="disableDialog = true">
                  <v-icon left small>mdi-cancel</v-icon
                  >{{ $t("users.DisableUser") }}
                </v-btn>
              </div>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header class="title">{{
            $t("users.Metadata")
          }}</v-expansion-panel-header>
          <v-expansion-panel-content class="body-2">
            <span class="font-weight-bold">{{ $t("users.Created") }}</span>
            {{ user.created | formatDate("lll") }}
            <br />
            <span class="font-weight-bold">{{ $t("users.LastSignIn") }}</span>
            {{ user.lastSignIn | formatDate("lll") }}
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header class="title">{{
            $t("users.RawData")
          }}</v-expansion-panel-header>
          <v-expansion-panel-content>
            <pre class="body-2">{{ user }}</pre>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels> -->
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
import { mapActions } from "vuex";

export default {
  props: {
    user: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      panel: [1],
      deleteDialog: false,
      disableDialog: false,
      avatar: {},
      showPassword: false,
      loading: false
    };
  },
  methods: {
    ...mapActions("auth", ["editProfile"]),
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
        username
      };
      if (this.avatar.length) {
        data["avatar"] = this.avatar[0];
      }

      let form = this.buildForm(data);
      this.loading = true;
      this.editProfile(form)
        .then(() => {
          document.getElementById("update-avatar").files = null;
          this.avatar = {};
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
    buildForm(data) {
      let keys = Object.keys(data);
      let form = new FormData();
      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        if (data[key]) {
          form.append(key, data[key]);
        }
      }
      return form;
    }
  },
  mounted() {
    document.getElementById("update-avatar").addEventListener("change", e => {
      this.avatar = e.target.files;
    });
  }
};
</script>
