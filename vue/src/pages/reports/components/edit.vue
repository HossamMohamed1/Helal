<template>
  <v-container fluid>
    <v-card :loading="loading" flat>
      <v-row>
        <v-col>
          <v-tabs>
            <v-tab
              v-for="(file, index) in chartFiles"
              @click.prevent="changeFile(file)"
            >
              <v-icon left>
                mdi-file-excel
              </v-icon>
              {{ file.file_name.replace(".json", "") }}
            </v-tab>
            <v-tab-item v-for="(file, index) in chartFiles">
              <v-card flat>
                <v-card-text>
                  <p class="mb-0">
                    <Excel @pageChanged="pageChanged" />
                  </p>
                  <v-col cols="12" lg="12" md="12" class="">
                    <!-- <div>{{ file }}</div> -->
                    <v-pagination
                      v-if="fileData.links"
                      v-model="page"
                      total-visible="7"
                      :length="fileData.links.length - 2"
                    ></v-pagination>
                  </v-col>
                </v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs>
        </v-col>
      </v-row>
    </v-card>
  </v-container>
</template>
<script>
import { mapActions, mapState } from "vuex";
import Excel from "./excel.vue";

export default {
  data() {
    return {
      loading: false,
      page: 1,
      perPage: 10
    };
  },
  created() {
    this.loadData();
  },
  watch: {
    page(val) {
      const data = {
        page: val,
        perPage: this.perPage
      };
      data["file"] = this.file.file_path;
      this.pageChanged(data);
      // this.$emit("pageChanged", data);
    }
  },
  computed: {
    ...mapState("reports", ["chartFiles", "file", "fileData"])
  },
  methods: {
    ...mapActions("reports", ["getChartData", "loadFile"]),
    loadData() {
      const { id } = this.$route.params;
      this.loading = true;
      this.getChartData(id)
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
    changeFile(file) {
      this.loading = true;
      this.$store.commit("reports/SET_FILE", file);
      const { file_path } = file;
      let data = {
        file: file_path
      };

      this.page = 1;

      this.loadFile(data)
        .then(() => (this.loading = false))
        .catch(() => (this.loading = false));
    },
    pageChanged(data) {
      this.loading = true;
      data["file"] = this.file.file_path;
      this.loadFile(data)
        .then(() => (this.loading = false))
        .catch(() => (this.loading = false));
      // console.log(data);
    }
  },
  components: { Excel }
};
</script>
