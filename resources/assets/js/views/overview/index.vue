<template>
    <div>
        <x-row class="align-items-center mb-3" line>
            <div class="col-auto">
                <h2 class="page-title">
                    {{$t('overview')}}
                </h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <x-button @click="toggleEdit" class="float-right" icon="pencil" size="sm" type="white"
                          v-if="!showEdit"></x-button>
                <x-button @click="toggleEdit" class="float-right" icon="x" size="sm" type="white"
                          v-if="showEdit"></x-button>
                <x-button @click="savePositions" class="float-right mr-2" size="sm" type="white"
                          v-if="showEdit">{{$t('save_layout')}}
                </x-button>
                <x-button @click="toggleFieldModal" class="float-right mr-2" size="sm" type="white"
                          v-if="showEdit">{{$t('add_card')}}
                </x-button>
            </div>
        </x-row>
        <grid-layout :col-num="12"
                     :is-draggable="showEdit"
                     :is-resizable="showEdit"
                     :layout.sync="metrics"
                     :row-height="44"
                     :use-css-transforms="true"
                     :vertical-compact="true"
                     style="margin: -10px">
            <grid-item :h="metric.h"
                       :i="metric.id"
                       :min-h="2"
                       :min-w="2"
                       :w="metric.w"
                       :x="metric.x"
                       :y="metric.y"
                       v-bind:key="metric.id"
                       v-for="metric in metrics">
                <value-card :edit="showEdit"
                            :label="metric.card_label"
                            :value="metric.values"
                            @remove="removeMetric(metric)"
                            v-if="metric.type === 'value'"></value-card>
                <chart-card :color="metric.color" :edit="showEdit"
                            :label="metric.card_label"
                            :type="metric.chart_type"
                            :values="metric.values"
                            @remove="removeMetric(metric)"
                            v-else></chart-card>
            </grid-item>
        </grid-layout>
        <metrics-modal @add="handleAddCard"
                       @cancel="toggleFieldModal" v-if="showModal"></metrics-modal>
    </div>
</template>
<script>
    import {indexable} from '@js/lib/mixins'
    import MetricsModal from '@js/partials/MetricsModal.vue'
    import ChartCard from '@js/partials/ChartCard.vue'
    import ValueCard from '@js/partials/ValueCard.vue'
    import {GridItem, GridLayout} from 'vue-grid-layout';

    export default {
        mixins: [indexable],
        components: {
            MetricsModal,
            ChartCard,
            ValueCard,
            GridLayout,
            GridItem
        },
        data() {
            return {
                showEdit: false,
                showModal: false,
                show: false,
                metrics: []
            }
        },
        methods: {
            removeMetric(item) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }

                this.$http.delete(`/api/user_metrics/${item.id}`)
                    .then((res) => {
                        if (res.data.deleted) {
                            const id = Math.random().toString(36).substring(7);
                            this.showEdit = false;
                            this.$router.push(`/?id=${id}`);
                            this.$message.success(this.$t('success_delete'))
                        }
                    })
                    .catch((error) => {
                        if (error && error.response.status === 422) {
                            this.$message.error(error.response.data.message)
                        }
                    })
            },
            handleAddCard() {

            },
            toggleEdit() {
                this.showEdit = !this.showEdit
            },
            toggleFieldModal() {
                this.showModal = !this.showModal
            },
            setData(res) {
                this.$set(this.$data, 'metrics', res.data.metrics);
            },
            savePositions() {
                this.$http.post(`/api/overview`, this.metrics)
                    .then((res) => {
                        console.log(res);
                        if (res.data.saved) {
                            this.showEdit = false;
                            this.$message.success(this.$t('saved_success'))
                        }
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
                    })
            }
        }
    }
</script>
