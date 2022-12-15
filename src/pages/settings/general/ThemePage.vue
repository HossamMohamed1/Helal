<template>
  <div class="flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t('menu.general') }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn icon @click>
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </div>

    <div class="d-flex flex-grow-1 flex-row">
      <v-navigation-drawer
        v-model="drawer"
        :app="$vuetify.breakpoint.mdAndDown"
        :permanent="$vuetify.breakpoint.lgAndUp"
        floating
        class="elevation-1 rounded flex-shrink-0"
        :class="[$vuetify.rtl ? 'ml-3' : 'mr-3']"
        width="240"
      >
        <general-settings-menu class="pa-2"></general-settings-menu>
      </v-navigation-drawer>

      <div class="d-flex flex-grow-1 flex-column">
        <!--Form Content-->
        <v-card class="pa-2">
          <v-card-text class="">
            <v-form>
              <div class="title mb-2">
                {{ $t('settings.theme') }}
              </div>

              <v-row>
                <v-col cols="12" lg="8">
                  <v-row>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">Global Theme</div>
                      <v-btn-toggle v-model="theme" color="primary" mandatory class="mb-2">
                        <v-btn>Light</v-btn>
                        <v-btn>Dark</v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">Toolbar Theme</div>
                      <v-btn-toggle v-model="toolbarTheme" color="primary" mandatory class="mb-2">
                        <v-btn>Global</v-btn>
                        <v-btn>Light</v-btn>
                        <v-btn>Dark</v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">Toolbar Style</div>
                      <v-btn-toggle v-model="toolbarStyle" color="primary" mandatory class="mb-2">
                        <v-btn>Full</v-btn>
                        <v-btn>Solo</v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">Content Layout</div>
                      <v-btn-toggle v-model="contentBoxed" color="primary" mandatory class="mb-2">
                        <v-btn>Fluid</v-btn>
                        <v-btn>Boxed</v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">Menu Theme</div>
                      <v-btn-toggle v-model="menuTheme" color="primary" mandatory class="mb-2">
                        <v-btn>Global</v-btn>
                        <v-btn>Light</v-btn>
                        <v-btn>Dark</v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12" md="6">
                      <div class="font-weight-bold my-1">RTL</div>
                      <v-switch v-model="rtl" inset label="Right to Left"></v-switch>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" lg="3">
                  <v-row>en
                    <v-col cols="12">
                      <div class="font-weight-bold my-1">Primary Color</div>

                      <v-color-picker v-model="color" mode="hexa" :swatches="swatches" show-swatches></v-color-picker>
                    </v-col>
                  </v-row>
                </v-col>

              </v-row>

              <div class="d-flex mt-3">
                <v-btn color="primary">{{ $t('general.save') }}</v-btn>
              </div>
            </v-form>
          </v-card-text>
        </v-card>
      </div>
    </div>
  </div>
</template>

<script>

import GeneralSettingsMenu from '../../../components/settings/general/GeneralSettingsMenu'
import { mapMutations, mapState } from 'vuex'

export default {
  components: {
    GeneralSettingsMenu
  },
  data() {
    return {
      breadcrumbs: [{
        text: this.$t('menu.settings'),
        disabled: false,
        href: '#'
      }, {
        text: this.$t('menu.general'),
        to: '/settings/information',
        exact: true
      }],
      drawer: null,
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
      const { isDark } = this.$vuetify.theme

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
