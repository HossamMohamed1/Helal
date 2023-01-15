<template>
  <v-row justify="center">
<!--    <v-dialog-->
<!--      v-model="dialog"-->
<!--      max-width="500"-->
<!--    >-->
<!--      <v-card>-->
<!--        <v-card-title class="text-h5">-->
<!--          {{ $t('general.confirmationLog') }}-->
<!--        </v-card-title>-->

<!--        <v-card-text>-->
<!--          <v-row>-->
<!--            <v-col cols="12">-->
<!--              <v-textarea-->
<!--                :label="$t('general.note')"-->
<!--                value=""-->
<!--              ></v-textarea>-->

<!--            </v-col>-->
<!--            <v-col cols="12">-->
<!--              <v-file-input-->
<!--                :label="$t('general.uploadFile')"-->
<!--              ></v-file-input>-->
<!--            </v-col>-->
<!--          </v-row>-->
<!--        </v-card-text>-->

<!--        <v-card-actions>-->
<!--          <v-spacer></v-spacer>-->

<!--          <v-btn-->
<!--            color="green darken-1"-->
<!--            text-->
<!--            @click="dialog = false"-->
<!--          >-->
<!--            {{ $t('general.save') }}-->
<!--          </v-btn>-->

<!--          <v-btn-->
<!--            color="green darken-1"-->
<!--            text-->
<!--            @click="dialog = false"-->
<!--          >-->
<!--            {{ $t('general.cancel') }}-->
<!--          </v-btn>-->
<!--        </v-card-actions>-->
<!--      </v-card>-->
<!--    </v-dialog>-->


    <v-dialog v-model="dialog" persistent max-width="600px">
      <!--            <template v-slot:activator="{ on, attrs }">-->
      <!--              <v-btn color="primary" dark v-bind="attrs" v-on="on" class="mt-1">-->
      <!--                {{ $t("reports.createReport") }}-->
      <!--              </v-btn>-->
      <!--            </template>-->
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ $t("reports.createReport") }}</span>
        </v-card-title>
        <v-card-text class="pb-0">
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-autocomplete
                  v-model="report.type"
                  :items="types"
                  :error-messages="validationError['type']"
                  :label="$t('reports.reportType')"
                  item-text="name"
                  item-value="name"
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
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  :items="columns"
                  :label="$t('reports.columns')"
                  v-model="report.columns"
                  multiple
                  dense
                  chips
                  small-chips
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
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="mb-1">
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
      types: [
        {
          name: "Network",
          image: require("@/assets/images/visualization/network.jpg"),
        },
        {
          name: "Bar",
          image: require("@/assets/images/visualization/bar.jpg"),
        },
        {
          name: "Line",
          image: require("@/assets/images/visualization/line.jpg"),
        },
        {
          name: "XYBubble",
          image: require("@/assets/images/visualization/xybubble.jpg"),
        },
        {
          name: "Pie",
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
  }
}
</script>
