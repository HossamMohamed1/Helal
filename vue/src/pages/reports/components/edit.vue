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
                mdi-file
              </v-icon>
              {{ file.file_name.replace(".json", "") }}
            </v-tab>

            <v-tab-item v-for="(file, index) in chartFiles">
              <v-card flat>
                <v-card-text>
                  <p class="mb-0">
                    <Excel />
                  </p>
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
    return { loading: false };
  },
  created() {
    this.loadData();
  },
  computed: {
    ...mapState("reports", ["chartFiles", "file"])
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
    changeFile({ file_path }) {
      this.loading = true;
      let data = {
        file: file_path
      };
      this.loadFile(data)
        .then(() => (this.loading = false))
        .catch(() => (this.loading = false));
    }
  },
  components: { Excel }
};
</script>
