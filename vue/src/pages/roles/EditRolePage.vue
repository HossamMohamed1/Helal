<template>
  <div class="flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t("users.editRole") }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </div>

    <v-card>
      <v-card-text class="p-3 roles">
        <v-form>
          <div class="title mb-2">
            {{ $t("users.roleName") }}
          </div>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                value=""
                :label="$t('users.roleName')"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                value=""
                :label="$t('users.nameOnScreen')"
              ></v-text-field>
            </v-col>
          </v-row>
          <div>
            <div class="title mb-2 mt-2">{{ $t("users.roleDetails") }}</div>
            <div>
              <v-simple-table
                class="table align-middle table-row-dashed fs-6 gy-5"
              >
                <tbody>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.administratorAccess") }}
                      <i class="fas fa-exclamation-circle ms-1 fs-7"></i>
                    </td>
                    <td>
                      <v-checkbox class="mr-2" label="Select All"></v-checkbox>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.stations") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                          input-value="true"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.drones") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox
                          class="mr-2"
                          label="Read"
                          input-value="true"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.archiveFile") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.auditLog") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.config") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox
                          class="mr-2"
                          label="Write"
                          input-value="true"
                        ></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.draftReport") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.features") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                          input-value="true"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.notification") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                          input-value="true"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.permission") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox
                          class="mr-2"
                          label="Read"
                          input-value="true"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.pinnedReport") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox
                          class="mr-2"
                          label="Write"
                          input-value="true"
                        ></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.role") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.setting") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.dashboard") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox
                          class="mr-2"
                          input-value="true"
                          label="Write"
                        ></v-checkbox>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-primary text-center font-weight-bold">
                      {{ $t("texts.report") }}
                    </td>
                    <td>
                      <div class="d-flex">
                        <v-checkbox
                          class="mr-2 mb-0"
                          label="Create"
                        ></v-checkbox>
                        <v-checkbox class="mr-2" label="Read"></v-checkbox>
                        <v-checkbox class="mr-2" label="Write"></v-checkbox>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </v-simple-table>
            </div>
          </div>
          <div class="d-flex">
            <v-btn color="primary">{{ $t("general.save") }}</v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      breadcrumbs: [
        {
          text: this.$t("menu.usersManagement"),
          disabled: false,
          href: "#"
        },
        {
          text: this.$t("users.rolesList"),
          to: "/roles/list",
          exact: true
        },
        {
          text: this.$t("users.editRole")
        }
      ]
    };
  }
};
</script>
