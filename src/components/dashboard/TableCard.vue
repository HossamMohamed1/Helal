<template>
  <v-card>
    <v-card-title>{{ label }}</v-card-title>
    <v-data-table
      :headers="headers"
      :items="items"
      hseriale-default-footer
    >

      <template v-slot:item.name="{ item }">
        <div>{{item.name}}</div>
      </template>

      <template v-slot:item.serial="{ item }">
        <copy-label :text="item.serial" />
      </template>

      <template v-slot:item.date="{ item }">
        <div>{{ item.date | formatDate }}</div>
      </template>

      <template v-slot:item.flights="{ item }">
        <div>{{ item.flights }}</div>
      </template>

      <template v-slot:item.stations="{ item }">
        <div>{{ item.stations }}</div>
      </template>

      <template v-slot:item.action="{ item }">
        <div class="actions">
          <v-btn text @click="open(item)">
            <span class="primary--text">{{$t('tables.view')}}</span>
          </v-btn>
        </div>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import CopyLabel from '../common/CopyLabel'

/*
|---------------------------------------------------------------------
| DEMO Dashboard Card Component
|---------------------------------------------------------------------
|
| Demo card component to be used to gather some serialeas on how to build
| your own dashboard component
|
*/
export default {
  components: {
    CopyLabel
  },
  props: {
    label: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      headers: [
        { text: this.$t('tables.name'), align: 'start', value: 'name' },
        { text: this.$t('tables.serial'), value: 'serial', align: 'center' },
        { text: this.$t('tables.date'), value: 'date', align: 'center' },
        { text: this.$t('tables.flightNum'), value: 'flights', align: 'center' },
        { text: this.$t('tables.stationsNum'), value: 'stations', align: 'center' },
        { text: this.$t('tables.actions'), value:'action', sortable: false, align: 'center' }
      ],
      items: [
        {
          name: this.$t('charts.drone1'),
          serial: '2837',
          date: '2020-05-10',
          flights: '30',
          stations: 5
        },
        {
          name: this.$t('charts.drone2'),
          serial: '2838',
          date: '2020-05-11',
          flights: '28',
          stations: 4
        },
        {
          name: this.$t('charts.drone3'),
          serial: '2839',
          date: '2020-05-12',
          flights: '25',
          stations: 3
        },
        {
          name: this.$t('charts.drone4'),
          serial: '2840',
          date: '2020-05-12',
          flights: '12',
          stations: 5
        }

      ]
    }
  },
  methods: {
    open(item) { }
  }
}
</script>
