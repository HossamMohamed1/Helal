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
        <v-card class="pa-2 properties">
          <v-card-text class="p-3 roles">
            <v-form>
              <div class="title mb-2">
                {{ $t('settings.properties') }}
              </div>
              <v-row>
                <v-col cols="12" md="6" lg="3">
                  <v-file-input
                    :label="$t('settings.websiteLogoSmall')"
                    v-model="image1"
                    @change="Preview_image1"
                  >
                  </v-file-input>
                  <v-img :src="url1"></v-img>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-file-input
                    :label="$t('settings.websiteLogoLarge')"
                    v-model="image2"
                    @change="Preview_image2"
                  >
                  </v-file-input>
                  <v-img :src="url2"></v-img>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-file-input
                    :label="$t('settings.favouritePlaceIcon')"
                    v-model="image3"
                    @change="Preview_image3"
                  >
                  </v-file-input>
                  <v-img :src="url3"></v-img>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-file-input
                    :label="$t('settings.websiteLoginPageImage')"
                    v-model="image4"
                    @change="Preview_image4"
                  >
                  </v-file-input>
                  <v-img :src="url4"></v-img>
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
      url1: null,
      image1: null,
      url2: null,
      image2: null,
      url3: null,
      image3: null,
      url4: null,
      image4: null
    }
  },
  methods: {
    Preview_image1() {
      this.url1 = URL.createObjectURL(this.image1)
    },
    Preview_image2() {
      this.url2 = URL.createObjectURL(this.image2)
    },
    Preview_image3() {
      this.url3 = URL.createObjectURL(this.image3)
    },
    Preview_image4() {
      this.url4 = URL.createObjectURL(this.image4)
    }
  }
}
</script>
<style >
.v-responsive__content{
  width: fit-content !important;
}

</style>
