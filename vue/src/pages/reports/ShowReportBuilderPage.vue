<template>
    <div class="d-flex flex-grow-1 flex-column">
        <div class="py-3">
            <div class="d-flex align-center page-filters">
                <div class="d-flex align-baseline">
                    <div class="display-1 d-flex align-center">
                        {{ $t("menu.reportBuilder") }}
                    </div>
                    <small class="mx-1">({{ $t("dashboard.thismonth") }})</small>
                </div>
            </div>
            <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
        </div>

        <v-row>
            <v-col cols="12">
                <v-card class="pa-2">
                    <div class="title mb-2">
                        {{ $t("reports.showReport") }}
                    </div>
                    <v-card>
                        <v-tabs color="deep-purple accent-4" centered>
                            <v-tab>{{ $t('showchart') }}</v-tab>
                            <v-tab>{{ $t('editchart') }}</v-tab>

                            <v-tab-item :key="1">
                                <v-container fluid>
                                    <v-row>
                                        AAAA
                                    </v-row>
                                </v-container>
                            </v-tab-item>
                            <v-tab-item :key="2">
                                <v-container fluid>
                                    <v-row>
                                        BBBBB
                                    </v-row>
                                </v-container>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
  
<script>
import axios from "axios";

export default {
    components: {},
    data() {
        return {
            breadcrumbs: [
                {
                    text: this.$t("menu.reportBuilder"),
                    disabled: false,
                    href: "#"
                },
                {
                    text: this.$t("menu.reportBuilder"),
                    to: "/reports/report-builder",
                    exact: true
                }
            ],
            chartData: [],
            chartAnalysis: {}


        };
    },
    mounted() {
        this.getChartData();
        this.getAnaysisData();
    },
    methods: {
        getChartData() {
            this.$axios
                .get("charts/show/" + this.$route.params.id, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.chartData = response.data;
                })
                .catch(error => {
                    console.log({ error });
                });
        },
        getAnaysisData() {
            this.$axios
                .get("charts/analysis/" + this.$route.params.id, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.chartAnalysis = response.data;
                    console.log(this.chartAnalysis);
                })
                .catch(error => {
                    console.log({ error });
                });

        }

    }
};
</script>
<style scoped>
.vue-daterange-picker {
    margin: 0;
}

.v-sheet.v-card:not(.v-sheet--outlined) {
    box-shadow: none !important;
}

.reportrange-text {
    padding: 8px 10px !important;
}
</style>
  