<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/organizations">{{$t('organization')}}</router-link>
                / {{model.name}}
                <small>({{model.number}})</small>
            </div>
            <div slot="extra" class="float-right">
                <router-link :to="`/organizations`" class="btn btn-white btn-icon btn-sm">
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
                <router-link :to="`/organizations/${model.id}/edit`" class="btn btn-white btn-icon btn-sm">
                    <svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
                </router-link>
                <x-button @click="removeDB('organizations', model.id)" class="btn-icon" size="sm" type="danger">
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
                <x-group col="2" label="number">
                    <p>{{model.number}}</p>
                </x-group>
                <x-group col="4" label="category">
                    <p v-if="model.category">
                        {{model.category.name}}
                    </p>
                </x-group>
                <x-group col="6" label="name">
                    <p>{{model.name || '-'}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="6" label="email">
                    <p>{{model.email || '-'}}</p>
                </x-group>
                <x-group col="2" label="website">
                    <p>{{model.website || '-'}}</p>
                </x-group>
                <x-group col="2" label="phone">
                    <p>{{model.phone || '-'}}</p>
                </x-group>
                <x-group col="2" label="fax">
                    <p>{{model.fax || '-'}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="6" label="primary_address">
                    <pre>{{model.primary_address || '-'}}</pre>
                </x-group>
                <x-group col="6" label="other_address">
                    <pre>{{model.other_address || '-'}}</pre>
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
        <x-mini :url="`contacts?organization_id=${this.model.id}`" title="contacts">
            <div slot="extra" class="float-right">
                <router-link :to="`/contacts/create?organization_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="5" type="th">{{$t('name')}}</x-td>
                <x-td size="5" type="th">{{$t('email')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/contacts/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>{{item.email}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'
    import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'

    export default {
        mixins: [showable],
        components: {CustomFieldPreview},
        data() {
            return {
                show: false,
                model: {
                    notes: [],
                    category: {},
                    custom_fields: []
                },
            }
        }
    }
</script>
