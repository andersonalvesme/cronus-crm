<template>
    <div>
        <x-filterable :filter-group="filters" :sortable="sortable" :title="title"
                      :url="url" ref="filterable">
            <div class="float-right" slot="extra">
                <router-link class="btn btn-primary w-xs" to="/opportunities/create">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="3" type="th">{{$t('category')}}</x-td>
                <x-td size="3" type="th">{{$t('title')}}</x-td>
                <x-td size="2" type="th">{{$t('stage')}}</x-td>
                <x-td size="2" type="th">{{$t('status')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/opportunities/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.category.name}}</x-td>
                <x-td>{{item.title | trim(40)}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.stage.color}`">
			    		{{item.stage.name}}
			    	</span>
                </x-td>
                <x-td>
                    <x-status :id="item.status_id"></x-status>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-filterable>
    </div>
</template>
<script>
    import {indexable} from '@js/lib/mixins'

    export default {
        mixins: [indexable],
        data() {
            return {
                url: 'opportunities',
                title: 'opportunities'
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'number', 'value', 'probability', 'start_date', 'close_date', 'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('opportunity'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'number', type: 'lookup', resource: 'opportunities'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'},
                        {name: 'start_date', type: 'datetime'},
                        {name: 'close_date', type: 'datetime'},
                        {name: 'value', type: 'numeric'},
                        {name: 'probability', type: 'numeric'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('contact'),
                    filters: [
                        {name: 'contact.id', type: 'numeric'},
                        {name: 'contact.number', type: 'lookup', resource: 'contacts', column: 'number'},
                        {name: 'contact.name', type: 'lookup', resource: 'contacts', column: 'name'},
                        {name: 'contact.created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('category'),
                    filters: [
                        {name: 'category.name', type: 'lookup', resource: 'opportunity_categories', column: 'name'},
                    ]
                }, {
                    title: this.$t('source'),
                    filters: [
                        {name: 'source.name', type: 'lookup', resource: 'opportunity_sources', column: 'name'}
                    ]
                }, {
                    title: this.$t('status'),
                    filters: [
                        {
                            name: 'status_id', type: 'static_lookup', options: [
                                'open', 'won', 'lost'
                            ]
                        },
                    ]
                }, {
                    title: this.$t('stage'),
                    filters: [
                        {name: 'stage.name', type: 'lookup', resource: 'opportunity_stages', column: 'name'}
                    ]
                }
                ];

                return groups
            }
        }
    }
</script>
