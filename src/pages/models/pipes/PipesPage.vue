<template>
  <div class="d-flex flex-column flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t('menu.pipesModel') }}</div>
      </div>
      <v-spacer></v-spacer>
    </div>

    <v-row class="flex-grow-0 mb-1" dense>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.total')"
            class="h-full"
            color="#8c9eff"
            :value="45"
            :percentage="100"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.work')"
            class="h-full"
            color="#8c9eff"
            :value="5"
            :percentage="6"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.leakage')"
            class="h-full"
            color="#8c9eff"
            :value="10"
            :percentage="11"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.fires')"
            class="h-full"
            color="#8c9eff"
            :value="3"
            :percentage="3"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.chemicalLeakage')"
            class="h-full"
            color="#8c9eff"
            :value="8"
            :percentage="7.9"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
      <v-col cols="12" lg="2" md="6">
        <div class="d-flex flex-column flex-grow-1 h-full">
          <track-card
            :label="$t('general.intrudersAndVandals')"
            class="h-full"
            color="#8c9eff"
            :value="9"
            :percentage="8.9"
            :percentage-label="$t('dashboard.lastweek')"
          ></track-card>
        </div>
      </v-col>
    </v-row>

    <v-card>
      <!-- users list -->
      <v-row dense class="pa-2 align-center">
        <v-col cols="6">
          <v-menu offset-y left>
            <template v-slot:activator="{ on }">
              <transition name="slide-fade" mode="out-in">
                <v-btn v-show="selectedUsers.length > 0" v-on="on">
                  {{ $t('general.actions') }}
                  <v-icon right>mdi-menu-down</v-icon>
                </v-btn>
              </transition>
            </template>
            <v-list dense>
              <v-list-item >
                <v-list-item-title>{{ $t('general.verify') }}</v-list-item-title>
              </v-list-item>
              <v-list-item >
                <v-list-item-title>{{ $t('general.disable') }}</v-list-item-title>
              </v-list-item>
              <v-divider></v-divider>
              <v-list-item >
                <v-list-item-title>Delete{{ $t('general.delete') }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>

        </v-col>
        <v-col cols="6" class="d-flex text-right align-center">
          <v-text-field
            v-model="searchQuery"
            append-icon="mdi-magnify"
            class="flex-grow-1 mr-md-2 mx-1"
            hide-details
            dense
            solo
            clearable
            :placeholder="$t('general.search')"
            @keyup.enter="searchUser(searchQuery)"
          ></v-text-field>
          <!--          <div style="width: 140px; height: 38px;" class="pipesFilter" >-->
          <!--            <v-select-->
          <!--              v-model="defaultSelected"-->
          <!--              label="Select Date"-->
          <!--              class="mb-0"-->
          <!--              :items="filter"-->
          <!--              solo-->
          <!--            ></v-select>-->
          <!--          </div>-->
          <div class="h-38">
            <date-range-picker
              v-model="dateRange"
            >
              <!--    header slot-->
              <div slot="header" slot-scope="header" class="slot">
                <h3>{{ $t('general.calenderHeader') }}</h3> <span v-if="header.in_selection"> - in selection</span>
              </div>
              <!--    input slot (new slot syntax)-->
              <template #input="picker" style="min-width: 350px;" >
                <!--              {{ picker.startDate | date }} - {{ picker.endDate | date }}-->
                {{ picker.rangeText }}
                <span v-if="filterLabel">{{ $t('general.filterWithDate') }}</span>
              </template>

              <!--    date slot-->
              <template #date="data" >
                <span class="small">
                  {{ data.date | dateCell }}
                </span>
              </template>
              <!--    ranges (new slot syntax) -->
              <template #ranges="ranges" >
                <div class="ranges">
                  <ul>
                    <li v-for="(range, name) in ranges.ranges" :key="name" @click="ranges.clickRange(range)">
                      <b>{{ name }}</b> <small class="text-muted">{{ range[0].toDateString() }} - {{ range[1].toDateString() }}</small>
                    </li>
                  </ul>
                </div>
              </template>
              <!--    footer slot-->
              <div slot="footer" slot-scope="data" class="slot">
                <div>
                  <b class="text-black">{{ $t('general.calenderFooter') }}</b> {{ data.rangeText }}
                </div>
                <div style="margin-left: auto" @click="showFilterLabel">
                  <a
                    v-if="!data.in_selection"
                    class="btn btn-primary btn-sm"
                    @click="data.clickApply"
                  >{{ $t('general.chooseDate') }}</a>
                </div>
              </div>
            </date-range-picker>
          </div>
          <v-btn
            class="primary--text  v-btn--active mx-1"
            @click="openAllCapturedImage"
          >
            <v-icon>mdi-eye-outline</v-icon>
          </v-btn>
          <v-btn
            class="primary--text  v-btn--active mx-1"
            @click="OpenImageSettings"
          >
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
          <v-btn
            :loading="isLoading"
            icon
            small
            class="mx-1"
            @click
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
        </v-col>
      </v-row>

      <v-data-table
        v-model="selectedUsers"
        show-select
        :headers="headers"
        :items="items"
        :search="searchQuery"
        class="flex-grow-1 cursor-pointer"
        @click:row="openCapturedImage"
      >
        <template v-slot:item.id="{ item }">
          <div class="font-weight-bold" >{{ item.id }}</div>
        </template>

        <template v-slot:item.date="{ item }">
          <div>{{ item.date | formatDate }}</div>
        </template>

        <template v-slot:item.time="{ item }">
          <div>{{ item.time }}</div>
        </template>

        <template v-slot:item.type="{ item }">
          <div class="font-weight-bold d-flex align-center text-no-wrap">
            <div v-if="item.type === 'work'" class="success--text">
              <v-icon small color="success">mdi-circle-medium</v-icon>
              <span>{{ $t('general.work') }}</span>
            </div>
            <div v-if="item.type=== 'leakage'" class="warning--text">
              <v-icon small color="warning">mdi-circle-medium</v-icon>
              <span>{{ $t('general.leakage') }}</span>
            </div>
            <div v-if="item.type=== 'chemical'" class="deep-purple--text">
              <v-icon small color="deep-purple">mdi-circle-medium</v-icon>
              <span>{{ $t('general.chemicalLeakage') }}</span>
            </div>
            <div v-if="item.type === 'fire'" class="red--text">
              <v-icon small color="red">mdi-circle-medium</v-icon>
              <span>{{ $t('general.fire') }}</span>
            </div>
            <div v-if="item.type === 'vandals'" class="blue--text">
              <v-icon small color="blue">mdi-circle-medium</v-icon>
              <span>{{ $t('general.intrudersAndVandals') }}</span>
            </div>
          </div>
        </template>

        <template v-slot:item.action="{ item }">
          <div class="actions" @click.stop="dialog = true">
            <v-btn
              color="primary"
              @click="open(item)"
            >
              {{ $t('general.changeStatus') }}
            </v-btn>
          </div>
        </template>
      </v-data-table>
    </v-card>
    <change-status-dialog v-model="dialog"></change-status-dialog>

    <!-- Captured Image-->
    <div id="captured_images" class="model-aside" :class="{ open: CapturedImageOpened }">
      <v-card>
        <v-card-title class="d-flex justify-space-between align-center border-bottom">
          {{ $t('general.capturedImage') }}
          <span class="cursor-pointer" @click="closeCapturedImage">
            X
          </span>
        </v-card-title>
        <v-card-text>
          <div class="captured_images_body ">
            <div class="captured_images_scroll position-relative scroll-y " >
              <div class="row">
                <div class="col-12">
                  <div class="image-cover position-relative">
                    <div style="background-image:url('/images/models/pipe-1.jpg'); height: 300px; background-size: 100% 100%;">
                      <span class="image-mark" style="top: 20%; left: 30%; border-color: red"></span>
                      <span class="image-mark" style="top: 40%; left: 45%; border-color: yellow"></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">Date</h6>
                      <p>15 Sep 2022</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">Time</h6>
                      <p>9:30 م</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">Pipe ID</h6>
                      506
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">
                        Camera ID</h6>
                      23
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">Status</h6>
                      <div class="warning--text">
                        <v-icon small color="warning">mdi-circle-medium</v-icon>
                        <span>Work</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class=" data-cont">
                    <div>
                      <h6 class="blue-grey darken-3">إدارة</h6>
                      <div class="modal-action">
                        <v-btn
                          color="primary"
                          small
                          @click.stop="dialog = true"
                        >
                          Change Status
                        </v-btn>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!--end::Content-->
            </div>
            <!--end::Body-->
          </div>
        </v-card-text>
      </v-card>
    </div>

    <!-- All Captured Images-->
    <div id="all_captured_images" class="model-aside" :class="{ open: AllCapturedImageOpened }">
      <v-card>
        <v-card-title class="d-flex justify-space-between align-center border-bottom">
          {{ $t('general.capturedImages') }}
          <span class="cursor-pointer" @click="closeAllCapturedImage">
            X
          </span>
        </v-card-title>
        <v-card-text>
          <div class="captured_images_body ">
            <div class="captured_images_scroll position-relative scroll-y " >
              <div class="row ma-0">
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-1.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 1</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-2.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 2</v-btn>
                    </div>
                  </div>

                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-3.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 3</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-4.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 4</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-5.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 5</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-6.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 6</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-1.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 7</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-2.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 8</v-btn>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pa-1">
                  <div class="overlay-wrapper">
                    <img src="/images/models/pipe-3.jpg" alt="">
                    <div class="overlay-layer bg-dark bg-opacity-10">
                      <v-btn color="primary"> {{ $t('general.screenshot') }} 9</v-btn>
                    </div>
                  </div>
                </div>
              </div>

              <!--end::Content-->
            </div>
            <!--end::Body-->
          </div>
        </v-card-text>
      </v-card>
    </div>

    <!-- Settings-->
    <div id="captured_images_settings" class="model-aside" :class="{ open: ImageSettingsOpened }">
      <v-card>
        <v-card-title class="d-flex justify-space-between align-center border-bottom">
          {{ $t('general.settings') }}
          <span class="cursor-pointer" @click="CloseImageSettings">
            X
          </span>
        </v-card-title>
        <v-card-text>
          <div class="captured_images_body ">
            <div class="captured_images_scroll position-relative scroll-y " >
              <div class="row ma-0">
                <div class="col-md-12 px-0 py-3 border-bottom">
                  <h3 class="mb-2">{{ $t('general.controlSetting') }}</h3>
                  <v-text-field value="" type="date" :label="$t('general.selectDate')"></v-text-field>
                  <div class="d-flex align-center">
                    <v-switch
                      class="mr-2"
                      :label="$t('general.notification')"
                    ></v-switch>
                    <v-switch
                      :label="$t('general.screenshots')"
                    ></v-switch>
                  </div>
                </div>
                <div class="col-md-12 px-0 py-3">
                  <h3 class="mb-2">{{ $t('general.export') }}</h3>
                  <v-text-field value="" type="date" label="Select Date"></v-text-field>
                  <div class="d-flex align-center">
                    <v-switch
                      class="mr-2"
                      :label="$t('general.notification')"
                    ></v-switch>
                    <v-switch
                      :label="$t('general.screenshots')"
                    ></v-switch>
                  </div>
                  <v-select
                    v-model="defaultSelected"
                    :items="filter"
                    :label="$t('general.selectDate')"
                  ></v-select>
                </div>
              </div>

              <!--end::Content-->
            </div>
            <!--end::Body-->
          </div>
        </v-card-text>
      </v-card>
    </div>
  </div>
</template>

<script>

import ChangeStatusDialog from '../../../components/pipes/ChangeStatusDialog'
import TrackCard from '../../../components/dashboard/TrackCard'

import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
export default {
  components: {
    ChangeStatusDialog,
    TrackCard,
    DateRangePicker
  },
  filters: {
    dateCell (value) {
      const dt = new Date(value)

      return dt.getDate()
    },
    date (val) {
      return val ? val.toLocaleString() : ''
    }
  },
  data() {

    return {
      isLoading: false,
      breadcrumbs: [{
        text: this.$t('menu.pipesModel'),
        disabled: false,
        href: '#'
      }, {
        text: this.$t('breadcrumbs.pipesList')
      }],
      // dateRange: '',
      dialog: false,
      CapturedImageOpened: false,
      AllCapturedImageOpened: false,
      ImageSettingsOpened: false,
      searchQuery: '',
      selectedUsers: [],
      headers: [
        { text: this.$t('tables.id'), align: 'start', value: 'id' },
        { text: this.$t('tables.date'), value: 'date' },
        { text: this.$t('tables.time'), value: 'time' },
        { text: this.$t('tables.type'), value: 'type' },
        { text: this.$t('tables.actions'), sortable: false, align: 'center', value: 'action' }
      ],
      items: [
        {
          id: '28347',
          date: '2020-05-10',
          time: '7:12 ص',
          type: 'leakage'
        },
        {
          id: '23838',
          date: '2020-05-11',
          time: '10:20 ص',
          type: 'work'
        },
        {
          id: '28139',
          date: '2020-05-11',
          time: '2:30 م',
          type: 'vandals'
        },
        {
          id: '28540',
          date: '2020-06-12',
          time: '5:00 م',
          type: 'leakage'
        },
        {
          id: '28841',
          date: '2020-06-13',
          time: '9:15 م',
          type: 'leakage'
        },
        {
          id: '20837',
          date: '2020-05-10',
          time: '7:12 ص',
          type: 'fire'
        },
        {
          id: '28338',
          date: '2020-07-11',
          time: '10:20 ص',
          type: 'chemical'
        },
        {
          id: '28639',
          date: '2020-10-11',
          time: '2:30 م',
          type: 'work'
        },
        {
          id: '28840',
          date: '2020-05-12',
          time: '5:00 م',
          type: 'chemical'
        },
        {
          id: '2841',
          date: '2020-10-13',
          time: '9:15 م',
          type: 'fire'
        },
        {
          id: '2837',
          date: '2020-05-10',
          time: '7:12 ص',
          type: 'vandals'
        },
        {
          id: '28338',
          date: '2020-05-11',
          time: '10:20 ص',
          type: 'work'
        },
        {
          id: '28349',
          date: '2020-05-11',
          time: '2:30 م',
          type: 'work'
        },
        {
          id: '28540',
          date: '2020-05-12',
          time: '5:00 م',
          type: 'leakage'
        },
        {
          id: '25841',
          date: '2020-05-13',
          time: '9:15 م',
          type: 'leakage'
        },
        {
          id: '28357',
          date: '2020-05-10',
          time: '7:12 ص',
          type: 'leakage'
        },
        {
          id: '28348',
          date: '2020-05-11',
          time: '10:20 ص',
          type: 'work'
        },
        {
          id: '28339',
          date: '2020-05-11',
          time: '2:30 م',
          type: 'work'
        },
        {
          id: '28440',
          date: '2020-05-12',
          time: '5:00 م',
          type: 'leakage'
        },
        {
          id: '28641',
          date: '2020-05-13',
          time: '9:15 م',
          type: 'leakage'
        }
      ],
      filter:[this.$t('dashboard.thismonth'), this.$t('dashboard.lastweek'), this.$t('dashboard.lastmonth')],
      defaultSelected: this.$t('dashboard.thismonth'),

      filterLabel: true,
      dateRange: {},
      startDate:  new Date(),
      endDate:  new Date()

    }

  },
  watch: {
    selectedUsers(val) {

    },
    created() {
      this.endDate.setDate(this.endDate.getDate() + 6)
      this.dateRange = {
        startDate , endDate
      }
    }
  },

  methods: {
    searchUser() {},
    open() {},
    openCapturedImage() {
      this.CapturedImageOpened = true
    },
    closeCapturedImage() {
      this.CapturedImageOpened = false
    },
    openAllCapturedImage() {
      this.AllCapturedImageOpened = true
    },
    closeAllCapturedImage() {
      this.AllCapturedImageOpened = false
    },
    OpenImageSettings() {
      this.ImageSettingsOpened = true
    },
    CloseImageSettings() {
      this.ImageSettingsOpened = false
    },
    showFilterLabel() {
      this.filterLabel = false
    }
  }
}
</script>

<style lang="scss" scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
////
</style>
