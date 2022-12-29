<template>
  <div>
    <v-btn
      ref="button"
      class="drawer-button"
      color="#ee44aa"
      dark
      @click="right = true"
    >
      <v-icon class="fa-spin">mdi-cog-outline</v-icon>
    </v-btn>

    <v-navigation-drawer
      v-model="right"
      fixed
      right
      hide-overlay
      temporary
      width="310"
    >
      <div class="d-flex align-center pa-2">
        <div class="title">الإعدادات</div>
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

      <v-row class="pa-2">
        <v-col cols="7">
          <div class="font-weight-bold my-1">Time Format</div>
          <v-menu
            offset-y
            left
            transition="slide-y-transition"
          >
            <template v-slot:activator="{ on }">
              <v-btn block v-on="on">{{ (new Date()) | formatDate }}</v-btn>
            </template>
            <v-list dense nav>
              <v-list-item v-for="format in availableFormats" :key="format.format"
                           @click="setTimeFormat(format.format)">
                <v-list-item-title>{{ format.label }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
        <v-col cols="5">
          <div class="font-weight-bold my-1">Currency</div>
          <v-menu
            offset-y
            left
            transition="slide-y-transition"
          >
            <template v-slot:activator="{ on }">
              <v-btn v-on="on">{{ currency.label }}</v-btn>
            </template>
            <v-list dense nav>
              <v-list-item v-for="item in availableCurrencies" :key="item.label" @click="setCurrency(item)">
                <v-list-item-title>{{ item.label }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
      </v-row>
    </v-navigation-drawer>
  </div>
</template>

<script>
import {mapMutations, mapState} from 'vuex'

export default {
  data() {
    return {
      right: false,
      theme: 0,
      toolbarTheme: 0,
      toolbarStyle: 0,
      contentBoxed: 0,
      menuTheme: 0,
      timeout: null,
      color: '#1e8e49',
      swatches: [
        ['#1e8e49', '#31944f'],
        ['#EE4f12', '#46BBB1'],
        ['#ee44aa', '#55BB46']
      ],

      rtl: 0,

      // timezones
      availableTimezones: ['America/Los_Angeles', 'America/New_York', 'Europe/London', 'Asia/Tokyo', 'Australia/Sydney'],

      // time formats
      availableFormats: [{
        label: '07/31/2020',
        format: 'L'
      }, {
        label: 'Jul 31, 2020',
        format: 'll'
      }, {
        label: '20200731',
        format: 'YYYYMMDD'
      }]
    }
  },
  computed: {
    ...mapState('app', ['time', 'currency', 'availableCurrencies'])
  },
  watch: {
    color(val) {
      const {isDark} = this.$vuetify.theme

      this.$vuetify.theme.themes.dark.primary = val
      this.$vuetify.theme.themes.light.primary = val
    },
    theme(val) {
      this.setGlobalTheme((val === 0 ? 'light' : 'dark'))
    },
    toolbarTheme(val) {
      const theme = val === 0 ? 'global' : (val === 1 ? 'light' : 'dark')

      this.setToolbarTheme(theme)
    },
    toolbarStyle(val) {
      this.setToolbarDetached(val === 1)
    },
    menuTheme(val) {
      const theme = val === 0 ? 'global' : (val === 1 ? 'light' : 'dark')

      this.setMenuTheme(theme)
    },
    contentBoxed(val) {
      this.setContentBoxed(val === 1)
    },
    rtl(val) {
      this.setRTL(val)
    }
  },
  mounted() {
    this.animate()
  },
  beforeDestroy() {
    if (this.timeout) clearTimeout(this.timeout)
  },
  methods: {
    ...mapMutations('app', ['setMenuTheme', 'setGlobalTheme', 'setToolbarTheme', 'setContentBoxed', 'setTimeZone', 'setTimeFormat', 'setCurrency', 'setRTL', 'setToolbarDetached']),
    setTheme() {
      this.$vuetify.theme.dark = this.theme === 'dark'
    },
    animate() {
      if (this.timeout) clearTimeout(this.timeout)

      const time = (Math.floor(Math.random() * 10 + 1) + 10) * 1000

      this.timeout = setTimeout(() => {
        this.$animate(this.$refs.button.$el, 'bounce')
        this.animate()
      }, time)
    }
  }
}
</script>

<style lang="scss" scoped>
.drawer-button {
  position: fixed;
  top: 340px;
  right: -20px;
  z-index: 6;
  box-shadow: 1px 1px 18px #ee44aa;

  .v-icon {
    margin-left: -18px;
    font-size: 1.3rem;
  }
  input{
    border-color:#ddd;
  }
}
</style>
