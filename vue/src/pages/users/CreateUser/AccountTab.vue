<template>
  <div class="my-2">
    <div>
      <v-card>
        <v-card-title>{{ $t('users.basicInformation') }}</v-card-title>
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
              <v-btn class="mt-1" small>{{ $t('users.EditAvatar') }}</v-btn>
            </div>
            <div class="flex-grow-1 pt-2 pa-sm-2">
              <v-text-field v-model="user.name" :label="$t('tables.name')" placeholder="name"></v-text-field>
              <v-text-field v-model="user.email" :label="$t('tables.email')" hide-details></v-text-field>

              <div class="d-flex flex-column">
                <v-checkbox v-model="user.verified" dense :label="$t('users.emailVerified')"></v-checkbox>
                <div>
                  <v-btn
                    v-if="!user.verified"
                  >
                    <v-icon left small>mdi-email</v-icon>
                    {{ $t('users.sendVerificationEmail') }}
                  </v-btn>
                </div>
              </div>

              <div class="mt-2">
                <v-btn color="primary" @click>{{ $t('general.save') }}</v-btn>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>

      <v-expansion-panels v-model="panel" multiple class="mt-3">
        <v-expansion-panel>
          <v-expansion-panel-header class="title">{{ $t('tables.actions') }}</v-expansion-panel-header>
          <v-expansion-panel-content>
            <div class="mb-2">
              <div class="title">{{ $t('users.ResetUserPassword') }}</div>
              <div class="subtitle mb-2">{{ $t('users.Sendsaresetpasswordemailtotheuser') }}</div>
              <v-btn
                class="mb-2"
                @click
              >
                <v-icon left small>mdi-email</v-icon>{{ $t('users.SendResetPasswordEmail') }}
              </v-btn>
            </div>

            <v-divider></v-divider>

            <div class="my-2">
              <div class="title">{{ $t('users.ExportAccountData') }}</div>
              <div class="subtitle mb-2">{{ $t('users.Exportalltheplatformmetadataforthisuser') }}</div>
              <v-btn class="mb-2">
                <v-icon left small>mdi-clipboard-account</v-icon>{{ $t('users.ExportUserData') }}
              </v-btn>
            </div>

            <v-divider></v-divider>

            <div class="my-2">
              <div class="error--text title">{{ $t('users.DangerZone') }}</div>
              <div class="subtitle mb-2">{{ $t('users.Fulladministratorwithaccesstothisdashboard') }}</div>

              <div class="my-2">
                <v-btn
                  v-if="user.role === 'ADMIN'"
                  color="primary"
                  @click="user.role = 'USER'"
                >
                  <v-icon left small>mdi-security</v-icon>{{ $t('users.Removeadminaccess') }}
                </v-btn>
                <v-btn v-else color="primary" @click="user.role = 'ADMIN'">
                  <v-icon left small>mdi-security</v-icon>{{ $t('users.SetUserasAdmin') }}
                </v-btn>
              </div>

              <v-divider></v-divider>

              <div class="subtitle mt-3 mb-2">{{ $t('users.Preventtheuserfromsigninginontheplatform') }}</div>
              <div class="my-2">
                <v-btn
                  v-if="user.disabled"
                  color="warning"
                  @click="user.disabled = false"
                >
                  <v-icon left small>mdi-account-check</v-icon>{{ $t('users.EnableUser') }}
                </v-btn>
                <v-btn
                  v-else
                  color="warning"
                  @click="disableDialog = true"
                >
                  <v-icon left small>mdi-cancel</v-icon>{{ $t('users.DisableUser') }}
                </v-btn>
              </div>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>

    <!-- disable modal -->
    <v-dialog v-model="disableDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">{{ $t('users.DisableUser') }}</v-card-title>
        <v-card-text>{{ $t('users.Areyousureyouwanttodisablethisuser') }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="disableDialog = false">Cancel</v-btn>
          <v-btn color="warning" @click="user.disabled = true; disableDialog = false">Disable{{ $t('users.DangerZone') }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- delete modal -->
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">{{ $t('users.DeleteUser') }}</v-card-title>
        <v-card-text>{{ $t('users.Areyousureyouwanttodeletethisuser') }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="error" @click="deleteDialog = false">{{ $t('users.Delete') }}</v-btn>
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
      default: () => ({})
    }
  },
  data() {
    return {
      panel: [1],
      deleteDialog: false,
      disableDialog: false
    }
  }
}
</script>
