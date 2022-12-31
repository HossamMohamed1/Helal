<template>
  <v-row>
    <v-col style="overflow: scroll;" cols="12" lg="12" md="12">
      <table class="excel" :loading="true">
        <thead>
          <tr>
            <th scope="col">
              <svg
                id="arrow-tow-directions"
                xmlns="http://www.w3.org/2000/svg"
                width="20.706"
                height="21.551"
                viewBox="0 0 20.706 21.551"
              >
                <path
                  id="Path_276901"
                  data-name="Path 276901"
                  d="M7400,95.03h-12.519v12.922"
                  transform="translate(-7383.388 -91.53)"
                  fill="none"
                  stroke="#1e4a51"
                  stroke-width="2"
                />
                <path
                  id="Polygon_9"
                  data-name="Polygon 9"
                  d="M3.8,0l3.8,6.761H0Z"
                  transform="translate(7.606 21.551) rotate(180)"
                  fill="#1e4a51"
                />
                <path
                  id="Polygon_10"
                  data-name="Polygon 10"
                  d="M3.8,0l3.8,6.761H0Z"
                  transform="translate(20.706) rotate(90)"
                  fill="#1e4a51"
                />
              </svg>
            </th>
            <th scope="col" v-for="(item, index) in alpha" :key="index">
              <span
                class="excel-btn"
                color="error"
                v-if="columnLength > index"
                @click.prevent="deleteColumn(index, 'column')"
              >
                <v-icon small>
                  mdi-delete
                </v-icon>
              </span>
              {{ item }}
              <!-- </v-btn> -->
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in file.data">
            <td>
              <span v-if="index + 1 + perPage * (page - 1) > 1">
                {{ index + 1 + perPage * (page - 1) - 1 }}
              </span>
              <span
                class="excel-btn"
                color="error"
                v-if="index + 1 + perPage * (page - 1) > 1"
                @click.prevent="deleteColumn(index, 'row')"
              >
                <v-icon small>
                  mdi-delete
                </v-icon>
              </span>
            </td>
            <td v-for="(item, itemIndex) in row">
              <input
                type="text"
                @focusout="saveColumn(itemIndex, index, item)"
                @keyup.enter="saveColumn(itemIndex, index, item)"
                :value="item"
              />
            </td>
            <td v-if="index == 0 && page == 1">
              <input
                type="text"
                v-model="newItem"
                @keydown.enter="addItem('column')"
              />
            </td>
          </tr>
          <tr v-if="file.data && !file.next_page_url">
            <td>{{ file.data.length + perPage * (page - 1) }}</td>
            <td>
              <input
                type="text"
                v-model="newItem"
                @keydown.enter="addItem('row')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </v-col>
  </v-row>
</template>
<script>
import { ask } from "@/helpers";
import { mapActions } from "vuex";

export default {
  data() {
    return {
      alpha: [
        "A",
        "B",
        "C",
        "D",
        "E",
        "F",
        "G",
        "H",
        "I",
        "J",
        "K",
        "L",
        "M",
        "N",
        "O",
        "P",
        "Q",
        "R",
        "S",
        "T",
        "U",
        "V",
        "W",
        "X",
        "Y",
        "Z"
      ],
      newItem: ""
    };
  },
  props: {
    page: { type: Number, default: 1 },
    perPage: { type: Number, default: 10 }
  },
  computed: {
    file() {
      return this.$store.state.reports.fileData;
    },
    fileObject() {
      return this.$store.state.reports.file;
    },
    columnLength() {
      try {
        return this.$store?.state?.reports?.fileData?.data[0]?.length ?? 0;
      } catch (error) {
        return 0;
      }
    }
  },
  methods: {
    saveColumn(itemIndex, index, item) {
      const value = event.target.value;
      if (value == item) {
        return false;
      }

      let data = {
        row_index: index,
        column_index: itemIndex,
        page_num: this.page,
        page_limit: this.perPage,
        value
      };

      this.$emit("updateExcelData", data);
    },
    async deleteColumn(index, type) {
      const { file_path } = this.fileObject;
      let data = {
        file_name: file_path,
        column_index: index,
        type,
        page_num: this.page,
        page_limit: this.perPage
      };
      const { isConfirmed } = await ask("Are you sure ?");
      if (isConfirmed) {
        this.$emit("deleteColumn", data);
      }
    },
    addItem(type) {
      const value = this.newItem;
      const { file_path } = this.fileObject;

      let data = {
        file_name: file_path,
        value,
        type
      };

      this.$emit("addItem", data);
      this.newItem = "";
    }
  }
};
</script>
