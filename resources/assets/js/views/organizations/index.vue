<template>
    <x-filterable :filter-group="filters" :sortable="sortable" :title="title"
                  :url="url" ref="filterable">
        <div slot="extra" class="float-right">
            <router-link class="btn btn-primary w-xs" to="/organizations/create">
                {{$t('new')}}
            </router-link>
        </div>
        <x-tr slot="heading">
            <x-td size="1" type="th">{{$t('number')}}</x-td>
            <x-td size="3" type="th">{{$t('category')}}</x-td>
            <x-td size="7" type="th">{{$t('name')}}</x-td>
            <x-td size="1" type="th">{{$t('created_at')}}</x-td>
        </x-tr>
        <x-tr @click.native="$router.push(`/organizations/${item.id}`)" slot-scope="{ item }">
            <x-td>{{item.number}}</x-td>
            <x-td>{{item.category.name}}</x-td>
            <x-td>{{item.name}}</x-td>
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
                url: 'organizations',
                title: 'organizations'
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'number', 'name',
                    'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('organization'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'number', type: 'lookup', resource: 'organizations'},
                        {name: 'name', type: 'lookup', resource: 'organizations'},
                        {name: 'email', type: 'lookup', resource: 'organizations'},
                        {name: 'website', type: 'lookup', resource: 'organizations'},
                        {name: 'fax', type: 'lookup', resource: 'organizations'},
                        {name: 'phone', type: 'lookup', resource: 'organizations'},
                        {name: 'mobile', type: 'lookup', resource: 'organizations'},
                        {name: 'primary_address', type: 'string'},
                        {name: 'other_address', type: 'string'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('category'),
                    filters: [
                        {name: 'category.name', type: 'lookup', resource: 'organization_categories', column: 'name'}
                    ]
                }];

                return groups
            }
        }
    }
</script>
