<template>
    <x-filterable :filter-group="filters" :sortable="sortable" :title="title"
                  :url="url" ref="filterable">
        <div slot="extra" class="float-right">
            <router-link class="btn btn-primary w-xs" to="/items/create">
                {{$t('new')}}
            </router-link>
        </div>
        <x-tr slot="heading">
            <x-td size="1" type="th">{{$t('code')}}</x-td>
            <x-td size="4" type="th">{{$t('category')}}</x-td>
            <x-td size="6" type="th">{{$t('description')}}</x-td>
            <x-td size="1" type="th">{{$t('created_at')}}</x-td>
        </x-tr>
        <x-tr @click.native="$router.push(`/items/${item.id}`)" slot-scope="{ item }">
            <x-td>{{item.code}}</x-td>
            <x-td>{{item.category.name}}</x-td>
            <x-td>{{item.description | trim(70)}}</x-td>
            <x-td>{{item.created_at | toDate}}</x-td>
        </x-tr>
    </x-filterable>
</template>
<script>
    import {indexable} from '@js/lib/mixins'

    export default {
        mixins: [indexable],
        data() {
            return {
                url: 'items',
                title: 'items'
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'code', 'description', 'unit_price',
                    'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('item'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'code', type: 'lookup', resource: 'items'},
                        {name: 'description', type: 'string'},
                        {name: 'unit_price', type: 'numeric'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('category'),
                    filters: [
                        {name: 'category.name', type: 'lookup', resource: 'item_categories', column: 'name'},
                    ]
                }, {
                    title: this.$t('uom'),
                    filters: [
                        {name: 'uom.name', type: 'lookup', resource: 'uoms', column: 'name'},
                    ]
                }];

                return groups
            }
        }
    }
</script>
