<template>
  <v-row>
    <v-col style="overflow: scroll;">
      <table class="excel">
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
              {{ item }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in file.data">
            <td>{{ index + 1 }}</td>
            <td v-for="(item, itemIndex) in row">
              <input type="text" v-model="file.data[index][itemIndex]" />
            </td>
            <td v-for="i in alpha.length - row.length"></td>
          </tr>
        </tbody>
      </table>
    </v-col>
  </v-row>
</template>
<script>
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
      ]
    };
  },
  computed: {
    file: {
      get() {
        return this.$store.state.reports.fileData;
      }
    }
  }
};
</script>
