<template>
  <div>
    <v-row class="flex" justify="center">
      <v-card
        :ripple="false"
        style="margin: 0 auto; max-width: 600px; width: 100%"
        :img="require('@/assets/images/images/demo/cards/desert.jpg')"
        height="300px"
        @click="show"
      ></v-card>
    </v-row>

    <v-menu
      v-model="showMenu"
      :position-x="x"
      :position-y="y"
      absolute
      offset-y
    >
      <v-list>
        <v-list-item v-for="(item, index) in items" :key="index" @click="">
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
export default {
  data: () => ({
    showMenu: false,
    x: 0,
    y: 0,
    items: [
      { title: "Click Me" },
      { title: "Click Me" },
      { title: "Click Me" },
      { title: "Click Me 2" },
    ],
  }),

  methods: {
    show(e) {
      e.preventDefault();
      this.showMenu = false;
      this.x = e.clientX;
      this.y = e.clientY;
      this.$nextTick(() => {
        this.showMenu = true;
      });
    },
  },
};
</script>

<style scoped>
.portrait.v-card {
  margin: 0 auto;
  max-width: 600px;
  width: 100%;
}
</style>
