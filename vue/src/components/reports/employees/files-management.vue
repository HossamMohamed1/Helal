<template>
  <v-row class="flex-grow-0 mb-1">
    <v-col cols="12">
      <v-card class="pa-2">
        <div class="d-flex align-center justify-space-between">
          <v-tabs
            v-model="tab"
            :show-arrows="false"
            background-color="transparent"
          >
            <v-tab>
              {{ $t("employees.employees") }}
            </v-tab>
            <v-tab>{{ $t("employees.administrations") }}</v-tab>
          </v-tabs>
          <div>
            <v-dialog v-model="dialog" persistent max-width="600px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                  تحميل ملف
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">تحميل</span>
                </v-card-title>
                <v-card-text class="pb-0">
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-file-input
                          label="File input"
                          required
                          @change="uploadFile"
                          ref="file"
                        ></v-file-input>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions class="mb-1">
                  <v-spacer></v-spacer>
                  <v-btn color="primary" dark @click="submitFile"> حفظ </v-btn>
                  <v-btn color="dark" dark @click="dialog = false">
                    إلغاء
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </div>
        </div>

        <v-tabs-items v-model="tab" class="py-3">
          <v-tab-item>
            <v-row>
              <v-col cols="2" v-for="(file, index) in files" :key="index">
                <v-card class="grey lighten-4 shadow-none">
                  <div
                    class="py-1 px-1 d-flex align-center justify-space-between"
                  >
                    <div class="d-flex align-center">
                      <img
                        :src="require('@/assets/images/images/txt.png')"
                        alt="file"
                        width="24"
                      />
                      <div class="text-h6 mx-1 font-weight-medium">
                        {{ file.name }}
                      </div>
                    </div>
                    <div>
                      <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            icon
                            color="green"
                            v-bind="attrs"
                            v-on="on"
                            class="font-weight-bold"
                          >
                            ...
                          </v-btn>
                        </template>
                        <v-list>
                          <v-list-item>
                            <v-list-item-icon
                              ><v-icon>mdi-delete</v-icon></v-list-item-icon
                            >
                            <v-list-item-content>
                              <v-list-item-title>حذف</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item>
                            <v-list-item-icon
                              ><v-icon
                                >mdi-cloud-download-outline</v-icon
                              ></v-list-item-icon
                            >
                            <v-list-item-content>
                              <v-list-item-title>تحميل</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item>
                            <v-list-item-icon
                              ><v-icon>mdi-finance</v-icon></v-list-item-icon
                            >
                            <v-list-item-content>
                              <v-list-item-title>نشر</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>
                      </v-menu>
                    </div>
                  </div>
                </v-card>
              </v-col>
            </v-row>
          </v-tab-item>

          <v-tab-item>
            <v-row>
              <v-col
                cols="2"
                v-for="(file, index) in files"
                :key="index + files.length"
              >
                <v-card class="grey lighten-4 shadow-none">
                  <div
                    class="py-1 px-1 d-flex align-center justify-space-between"
                  >
                    <div class="d-flex align-center">
                      <img
                        :src="require('@/assets/images/images/txt.png')"
                        alt="file"
                        width="24"
                      />
                      <div class="text-h6 mx-1 font-weight-medium">
                        {{ file.name }}
                      </div>
                    </div>
                    <div>
                      <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            icon
                            color="green"
                            v-bind="attrs"
                            v-on="on"
                            class="font-weight-bold"
                          >
                            ...
                          </v-btn>
                        </template>
                        <v-list>
                          <v-list-item>
                            <v-list-item-icon>
                              <v-icon>mdi-delete</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                              <v-list-item-title>حذف</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item>
                            <v-list-item-icon>
                              <v-icon>mdi-cloud-download-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                              <v-list-item-title>تحميل</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item>
                            <v-list-item-icon>
                              <v-icon>mdi-finance</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                              <v-list-item-title>نشر</v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>
                      </v-menu>
                    </div>
                  </div>
                </v-card>
              </v-col>
            </v-row>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      tab: 0,
      dialog: false,
      files: [
        {
          id: 1,
          name: "File  name 1",
        },
        {
          id: 2,
          name: "File  name 2",
        },
      ],
    };
  },
  mounted() {},
  methods: {
    uploadFile() {
      this.files = this.$refs.file.files[0];
    },
    submitFile() {
      this.dialog = false;

      const formData = new FormData();
      formData.append("file", this.files);
      console.log(this.files);
      // const headers = { 'Content-Type': 'multipart/form-data' };
      // axios.post('https://httpbin.org/post', formData, { headers }).then((res) => {
      //   res.data.files; // binary representation of the file
      //   res.status; // HTTP status
      // });
    },
  },
};
</script>
<style scoped>
.v-list-item {
  cursor: pointer;
}
.v-list-item:hover {
  background: #f2f2f2;
}
</style>
