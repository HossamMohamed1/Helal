<template>
  <div class="aside-config">
    <div class="d-flex align-center pa-2">
      <div class="title">إعدادات ال Bar Chart</div>
      <v-spacer></v-spacer>
      <v-btn icon @click="right = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </div>

    <v-divider></v-divider>

    <div class="pa-2">
      <div class="font-weight-bold mt-2 mb-1">Color Palette</div>
      <div class="color-palette d-flex">
        <input type="color" value="#1E8E49" class="color">
        <input type="color" value="#000" class="color">
        <input type="color" value="#46BBB1" class="color">
        <input type="color" value="#55BB46" class="color">
      </div>


      <div class="font-weight-bold mt-3 mb-1">Axis Titles</div>
      <div>
        <v-text-field
          value=" "
          label="X Title"
          outlined
        ></v-text-field>
        <v-text-field
          value=" "
          label="Y Title"
          outlined
        ></v-text-field>
      </div>


      <div class="font-weight-bold mt-3 mb-1">Chart Title</div>
      <div>
        <v-text-field
          value="Line Chart"
          label="Title"
          outlined
        ></v-text-field>
        <v-text-field
          value="16"
          label="Font Size"
          outlined
        ></v-text-field>
        <v-text-field
          value="600"
          label="Font Weight"
          outlined
        ></v-text-field>
        <v-color-picker></v-color-picker>
      </div>
    </div>

    <v-divider></v-divider>
  </div>
</template>
