<template>
    <div class="d-flex flex-grow-1 flex-column">

        <div class="py-3">

            <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
        </div>

        <v-row dense>
            <template>
                <v-card>
                    <v-tabs v-model="tab" background-color="deep-purple accent-4" centered dark icons-and-text>
                        <v-tabs-slider></v-tabs-slider>

                        <v-tab href="#tab-1">
                            Recents
                            <v-icon>mdi-phone</v-icon>
                        </v-tab>

                        <v-tab href="#tab-2">
                            Favorites
                            <v-icon>mdi-heart</v-icon>
                        </v-tab>

                        <v-tab href="#tab-3">
                            Nearby
                            <v-icon>mdi-account-box</v-icon>
                        </v-tab>
                    </v-tabs>

                    <v-tabs-items v-model="tab">
                        <v-tab-item v-for="i in 3" :key="i" :value="'tab-' + i">
                            <v-card flat>
                                <v-card-text>{{ text }}</v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </template>

        </v-row>



    </div>
</template>
  
<script>
// DEMO Cards for dashboard
import TrackCard from '../../components/dashboard/TrackCard'
import axios from 'axios'
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'


export default {
}
</script>
<style>
.vue-daterange-picker {
    margin: 0;
}

.reportrange-text {
    padding: 8px 10px !important;
}
</style>
  