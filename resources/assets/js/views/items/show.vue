<template>
    <div class="w-50 mx-auto" v-if="show">
        <x-panel padding>
            <div slot="title">
                <router-link to="/items">{{$t('item')}}</router-link>
                / {{model.code}}
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/items`" class="btn btn-white btn-icon btn-sm">
                    <svg class="icon icon-tabler icon-tabler-arrow-left" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <line x1="5" x2="19" y1="12" y2="12"></line>
                        <line x1="5" x2="11" y1="12" y2="18"></line>
                        <line x1="5" x2="11" y1="12" y2="6"></line>
                    </svg>
                </router-link>
                <router-link :to="`/items/${model.id}/edit`" class="btn btn-white btn-icon btn-sm">
                    <svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
                </router-link>
                <x-button @click="removeDB('items', model.id)" class="btn btn-icon btn-sm" size="sm" type="danger">
                    <svg class="icon icon-tabler icon-tabler-trash" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <line x1="4" x2="20" y1="7" y2="7"></line>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    </svg>
                </x-button>
            </div>
            <x-row line>
                <x-group col="4" label="code">
                    <p>{{model.code}}</p>
                </x-group>
                <x-group col="8" label="category">
                    <p v-if="model.category">
                        {{model.category.name}}
                    </p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="12" label="description">
                    <pre>{{model.description}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="8" label="uom">
                    <p v-if="model.uom">
                        {{model.uom.name}}
                    </p>
                </x-group>
                <x-group col="4" label="unit_price">
                    <p>{{model.unit_price | formatMoney}}</p>
                </x-group>
            </x-row>
            <x-row line v-if="model.custom_fields && model.custom_fields.length > 0">
                <custom-field-preview :field="field" :key="field.name"
                                      v-for="field in model.custom_fields"/>
            </x-row>
            <x-row line>
                <x-group col="8" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
            </x-row>
        </x-panel>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'
    import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'
    import XRow from "../../components/grid/Row";

    export default {
        mixins: [showable],
        components: {XRow, CustomFieldPreview},
        data() {
            return {
                show: false,
                model: {
                    custom_fields: [],
                    category: {}
                }
            }
        }
    }
</script>
