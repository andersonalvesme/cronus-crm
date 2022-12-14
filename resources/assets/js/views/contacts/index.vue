<template>
    <x-filterable :filter-group="filters" :sortable="sortable" :title="title"
                  :url="url" ref="filterable">
        <div slot="extra" class="float-right">
            <router-link class="btn btn-primary w-xs" to="/contacts/create">
                {{$t('new')}}
            </router-link>
        </div>
        <x-tr slot="heading">
            <x-td size="1" type="th">{{$t('number')}}</x-td>
            <x-td size="5" type="th">{{$t('name')}}</x-td>
            <x-td size="5" type="th">{{$t('organization')}}</x-td>
            <x-td size="1" type="th">{{$t('created_at')}}</x-td>
        </x-tr>
        <x-tr @click.native="$router.push(`/contacts/${item.id}`)" slot-scope="{ item }">
            <x-td>{{item.number}}</x-td>
            <x-td>{{item.name}}</x-td>
            <x-td>{{item.organization ? item.organization.name : '-'}}</x-td>
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
                url: 'contacts',
                title: 'contacts'
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'number', 'name', 'total_revenue',
                    'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('contact'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'number', type: 'lookup', resource: 'contacts'},
                        {name: 'name', type: 'lookup', resource: 'contacts'},
                        {name: 'title', type: 'string'},
                        {name: 'department', type: 'string'},
                        {name: 'email', type: 'lookup', resource: 'contacts'},
                        {name: 'website', type: 'lookup', resource: 'contacts'},
                        {name: 'fax', type: 'lookup', resource: 'contacts'},
                        {name: 'phone', type: 'lookup', resource: 'contacts'},
                        {name: 'mobile', type: 'lookup', resource: 'contacts'},
                        {name: 'primary_address', type: 'string'},
                        {name: 'other_address', type: 'string'},
                        {name: 'total_revenue', type: 'numeric'},
                        {name: 'last_contact', type: 'datetime'},
                        {name: 'last_project', type: 'datetime'},
                        {name: 'last_invoice', type: 'datetime'},
                        {name: 'last_payment', type: 'datetime'},
                        {name: 'last_proposal', type: 'datetime'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('organization'),
                    filters: [
                        {name: 'organization.id', type: 'numeric'},
                        {name: 'organization.number', type: 'lookup', resource: 'organizations', column: 'number'},
                        {name: 'organization.name', type: 'lookup', resource: 'organizations', column: 'name'},
                        {name: 'organization.created_at', type: 'datetime'},
                    ]
                }];

                return groups
            }
        }
    }
</script>
