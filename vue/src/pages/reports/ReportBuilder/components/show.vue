<template>
    <v-card :loading="loading"  class="pa-2 mt-2">
      <v-row>
        <v-col>
          <LineChart/>
        </v-col>
      </v-row>
    </v-card>
</template>
<script>



import LineChart from '@/pages/reports/ReportBuilder/components/charts/LineChart'
export default {
  components: {LineChart  },
  data() {
    return {
      loading: false,
    };
  },
  created() {

  },
  watch: {
  },
  computed: {
  },
  methods: {
  }
};
</script>
