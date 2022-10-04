<template>
    <div class="card h-100 m-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">{{label}}</div>
                <a @click="$emit('remove')" class="text-muted ml-auto lh-1" href="javascript:void(0)" v-if="edit">
                    <svg class="icon ml-auto lh-1" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <line x1="4" x2="20" y1="7" y2="7"></line>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    </svg>
                </a>
            </div>
            <apexchart :options="options" :series="series" height="100%" type="line" v-if="type === 'line'"
                       width="100%"></apexchart>
            <apexchart :options="options" :series="series" height="100%" type="area" v-else-if="type === 'area'"
                       width="100%"></apexchart>
            <apexchart :options="options" :series="series" height="100%" type="bar" v-else width="100%"></apexchart>
        </div>
    </div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts'

    export default {
        components: {
            apexchart: VueApexCharts,
        },
        data: function () {
            return {
                options: {
                    xaxis: {
                        labels: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function (val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    chart: {
                        fontFamily: 'inherit',
                        toolbar: {
                            show: false,
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        opacity: 1,
                    },
                    stroke: {
                        width: 2,
                        lineCap: "round",
                        curve: "straight",
                    },
                    colors: ["#206bc4"],
                },
                series: [{
                    name: '',
                    data: this.values
                }]
            }
        },
        props: {
            label: String,
            values: Array,
            type: String,
            edit: {
                type: Boolean,
                default: false
            },
            color: {
                default: null
            }
        }
    }
</script>
