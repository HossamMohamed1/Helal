<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ $t("reports.createReport") }}</span>
        </v-card-title>
        <v-card-text class="pb-0">
<!--          <v-row>-->
<!--            <v-col cols="12">-->
<!--              <div class="d-flex align-center">-->
<!--                <div style="width: 80%">-->
<!--                  <div class="font-weight-bold mb-1">تحميل ملف</div>-->
<!--                  <v-select-->
<!--                    :items="uploadType"-->
<!--                    label=""-->
<!--                    solo-->
<!--                    @change="uploadFile()"-->
<!--                  ></v-select>-->
<!--                  <input type="file" ref="file" style="display: none" />-->
<!--                </div>-->
<!--                <div v-if="fileUploaded == true" class="d-flex align-center">-->
<!--                  <v-btn-->
<!--                    outlined-->
<!--                    small-->
<!--                    color="primary"-->
<!--                    class="mx-2"-->
<!--                    @click.stop="dialogTable = true"-->
<!--                    title="عرض كجدول"-->
<!--                  >-->
<!--                    <v-icon>mdi-table-large</v-icon>-->
<!--                  </v-btn>-->
<!--                  <v-dialog-->
<!--                    v-model="dialogTable"-->
<!--                    max-width="60vw"-->
<!--                    height="600"-->
<!--                    scrollable-->
<!--                  >-->
<!--                    <v-card>-->
<!--                      <v-card-title>-->
<!--                        <span class="text-h5">عرض البانات كجدول</span>-->
<!--                      </v-card-title>-->
<!--                      <v-simple-table>-->
<!--                        <template v-slot:default>-->
<!--                          <thead>-->
<!--                          <tr>-->
<!--                            <th class="text-right">-->
<!--                              Name-->
<!--                            </th>-->
<!--                            <th class="text-right">-->
<!--                              Calories-->
<!--                            </th>-->
<!--                          </tr>-->
<!--                          </thead>-->
<!--                          <tbody>-->
<!--                          <tr-->
<!--                            v-for="item in desserts"-->
<!--                            :key="item.name"-->
<!--                          >-->
<!--                            <td>{{ item.name }}</td>-->
<!--                            <td>{{ item.calories }}</td>-->
<!--                          </tr>-->
<!--                          </tbody>-->
<!--                        </template>-->
<!--                      </v-simple-table>-->
<!--                      <v-card-actions>-->
<!--                        <v-spacer></v-spacer>-->

<!--                        <v-btn-->
<!--                          color="green darken-1"-->
<!--                          text-->
<!--                          @click="dialogTable = false"-->
<!--                        >-->
<!--                          أغلاق-->
<!--                        </v-btn>-->

<!--                      </v-card-actions>-->
<!--                    </v-card>-->
<!--                  </v-dialog>-->

<!--                  <v-btn-->
<!--                    outlined-->
<!--                    small-->
<!--                    color="primary"-->
<!--                    @click.stop="dialogExcel = true"-->
<!--                  >-->
<!--                    <v-icon>mdi-microsoft-excel</v-icon>-->
<!--                  </v-btn>-->
<!--                  <v-dialog-->
<!--                    v-model="dialogExcel"-->
<!--                    max-width="60vw"-->
<!--                    height="600"-->
<!--                    scrollable-->
<!--                  >-->
<!--                    <v-card>-->
<!--                      <v-card-title>-->
<!--                        <span class="text-h5">عرض البانات كملف إكسيل</span>-->
<!--                      </v-card-title>-->
<!--                      <table class="excel">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                          <th class="text-right">-->
<!--                            Name-->
<!--                          </th>-->
<!--                          <th class="text-right">-->
<!--                            Calories-->
<!--                          </th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        <tr-->
<!--                          v-for="item in desserts"-->
<!--                          :key="item.name"-->
<!--                        >-->
<!--                          <td>{{ item.name }}</td>-->
<!--                          <td>{{ item.calories }}</td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                      </table>-->
<!--                      <v-card-actions>-->
<!--                        <v-spacer></v-spacer>-->

<!--                        <v-btn-->
<!--                          color="green darken-1"-->
<!--                          text-->
<!--                          @click="dialogExcel = false"-->
<!--                        >-->
<!--                          أغلاق-->
<!--                        </v-btn>-->

<!--                      </v-card-actions>-->
<!--                    </v-card>-->
<!--                  </v-dialog>-->
<!--                </div>-->
<!--              </div>-->
<!--            </v-col>-->

<!--            <v-col cols="12" v-if="fileUploaded == true">-->
<!--              <div class="font-weight-bold mb-1">نوع الرسم البياني</div>-->
<!--              <v-autocomplete-->
<!--                v-model="report.type"-->
<!--                :items="types"-->
<!--                :error-messages="validationError['type']"-->
<!--                :label="$t('reports.reportType')"-->
<!--                item-text="name"-->
<!--                item-value="name"-->
<!--                solo-->
<!--              >-->
<!--                <template v-slot:item="data">-->
<!--                  <template v-if="typeof data.item !== 'object'">-->
<!--                    <v-list-item-content-->
<!--                      v-text="data.item"-->
<!--                    ></v-list-item-content>-->
<!--                  </template>-->
<!--                  <template v-else>-->
<!--                    <v-list-item-avatar>-->
<!--                      <img :src="data.item.image" />-->
<!--                    </v-list-item-avatar>-->
<!--                    <v-list-item-content>-->
<!--                      <v-list-item-title-->
<!--                        v-html="data.item.name"-->
<!--                      ></v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                  </template>-->
<!--                </template>-->
<!--              </v-autocomplete>-->
<!--            </v-col>-->
<!--            <v-col cols="12" v-if="fileUploaded == true" >-->
<!--              <div class="font-weight-bold mb-1">أعمدة الجدول</div>-->
<!--              <v-autocomplete-->
<!--                :items="columns"-->
<!--                :label="$t('reports.columns')"-->
<!--                v-model="report.columns"-->

<!--                multiple-->
<!--                chips-->
<!--                small-chips-->
<!--                solo-->
<!--              >-->
<!--                <template v-slot:item="data">-->
<!--                  <template v-if="typeof data.item !== 'object'">-->
<!--                    <v-list-item-content-->
<!--                      v-text="data.item"-->
<!--                    ></v-list-item-content>-->
<!--                  </template>-->
<!--                  <template v-else>-->
<!--                    <v-list-item-avatar>-->
<!--                      <img :src="data.item.image" />-->
<!--                    </v-list-item-avatar>-->
<!--                    <v-list-item-content>-->
<!--                      <v-list-item-title-->
<!--                        v-html="data.item.name"-->
<!--                      ></v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                  </template>-->
<!--                </template>-->
<!--              </v-autocomplete>-->
<!--            </v-col>-->
<!--          </v-row>-->

          <template>
            <v-stepper v-model="e1">
              <v-stepper-header>
                <v-stepper-step
                  :complete="e1 > 1"
                  step="1"
                >
                  تحميل ملف
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step
                  :complete="e1 > 2"
                  step="2"
                >
                  عرض الملف
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">التفاصيل
                </v-stepper-step>
              </v-stepper-header>

              <v-stepper-items>
                <v-stepper-content step="1" >
                  <div style="min-height: 300px">
                    <v-row>
                      <v-col
                        cols="6"
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
                          </div>
                        </v-card>
                      </v-col>
                      <v-col cols="6" class="mx-auto mt-3">
                        <v-file-input
                          accept="*/xlsx"
                          label="تحميل من ال PC"
                          prepend-icon="mdi-paperclip"
                          solo
                        ></v-file-input>
                      </v-col>
                    </v-row>
                  </div>
                  <div class="d-flex justify-end">
                    <v-btn
                      color="primary"
                      outlined
                      @click="e1 = 2"

                    >
                      إستمرار
                    </v-btn>
                  </div>

                </v-stepper-content>

                <v-stepper-content step="2">
                  <div style="min-height: 300px">
                    <v-simple-table>
                      <template v-slot:default>
                        <thead>
                        <tr>
                          <th class="text-right">
                            Name
                          </th>
                          <th class="text-right">
                            Calories
                          </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                          v-for="item in desserts"
                          :key="item.name"
                        >
                          <td>{{ item.name }}</td>
                          <td>{{ item.calories }}</td>
                        </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </div>
                  <div class="d-flex align-center justify-space-between">
                    <v-btn
                      color="primary"
                      outlined
                      @click="e1 = 1"
                    >

                      رجوع
                    </v-btn>
                    <v-btn
                      color="primary"
                      outlined
                      @click="e1 = 3"
                    >
                      إستمرار
                    </v-btn>

                  </div>
                </v-stepper-content>

                <v-stepper-content step="3">
                  <div style="min-height: 300px">
                    <div class="font-weight-bold mb-1">نوع الرسم البياني</div>
                    <v-autocomplete
                      v-model="report.type"
                      :items="types"
                      :error-messages="validationError['type']"
                      :label="$t('reports.reportType')"
                      item-text="name"
                      item-value="name"
                      solo
                    >
                      <template v-slot:item="data">
                        <template v-if="typeof data.item !== 'object'">
                          <v-list-item-content
                            v-text="data.item"
                          ></v-list-item-content>
                        </template>
                        <template v-else>
                          <v-list-item-avatar>
                            <img :src="data.item.image" />
                          </v-list-item-avatar>
                          <v-list-item-content>
                            <v-list-item-title
                              v-html="data.item.name"
                            ></v-list-item-title>
                          </v-list-item-content>
                        </template>
                      </template>
                    </v-autocomplete>
                    <div class="font-weight-bold mb-1">أعمدة الجدول</div>
                    <v-autocomplete
                      :items="columns"
                      :label="$t('reports.columns')"
                      v-model="report.columns"

                      multiple
                      chips
                      small-chips
                      solo
                    >
                      <template v-slot:item="data">
                        <template v-if="typeof data.item !== 'object'">
                          <v-list-item-content
                            v-text="data.item"
                          ></v-list-item-content>
                        </template>
                        <template v-else>
                          <v-list-item-avatar>
                            <img :src="data.item.image" />
                          </v-list-item-avatar>
                          <v-list-item-content>
                            <v-list-item-title
                              v-html="data.item.name"
                            ></v-list-item-title>
                          </v-list-item-content>
                        </template>
                      </template>
                    </v-autocomplete>
                  </div>
                  <div class="d-flex align-center justify-space-between">
                    <v-btn
                      color="primary"
                      outlined
                      @click="e1 = 2">
                      رجوع
                    </v-btn>
                  </div>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </template>
        </v-card-text>
        <v-card-actions class="mb-1 mt-1">
          <v-spacer></v-spacer>
          <v-btn color="primary" dark @click="submitFile"> حفظ </v-btn>
          <v-btn color="dark" dark @click="dialog = false"> إلغاء </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  props: {
    value: Boolean
  },
  data(){
    return{
      validationError: [],
      dialogTable: false,
      dialogExcel: false,
      e1: 1,
      fileUploaded: false,
      types: [
        {
          name: "Bar",
          image: require("@/assets/images/visualization/bar.jpg"),
        },
        {
          name: "Line",
          image: require("@/assets/images/visualization/line.jpg"),
        },
        {
          name: "Pie",
          image: require("@/assets/images/visualization/xybubble.jpg"),
        },
        {
          name: "Donut",
          image: require("@/assets/images/visualization/pie.jpg"),
        },
      ],
      report: {
        name: null,
        type: undefined,
        columns: [],
      },
      columns: [
        "الموظفين",
        "الجنس",
        "الأقسام",
        "الإدارات",
        "المؤهلات",
        "الوكالات",
        "الجنسيه",
        "الحضور والغياب",
        "الأجازات",
        "الأعمار",
        "الموقع",
      ],
      uploadType: ["تحميل من الكمبيوتر", "تحميل من الملفات"],
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
        },
        {
          name: 'Ice cream sandwich',
          calories: 237,
        },
        {
          name: 'Eclair',
          calories: 262,
        },
        {
          name: 'KitKat',
          calories: 518,
        },
      ],
      files: [
        {
          id: 1,
          name: "تقارير الموظفين حسب العمر",
        },
        {
          id: 2,
          name: "الموظفين بالنسبه للمؤهلات",
        },
        {
          id: 3,
          name: "الموظفين حسب الإدارات",
        },
        {
          id: 4,
          name: "عدد الموظفين حسب الجنسية",
        }
      ]
    }
  },
  computed: {
    dialog: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  },
  methods: {
    submitFile() {
      console.log("object", this.report);
      this.dialog = false;
    },
    uploadFile(){
      this.fileUploaded = true

    }
  }
}
</script>
<style scoped>
.v-list-item {
  cursor: pointer;
}
.v-list-item:hover {
  background: #f2f2f2;
}
</style>

