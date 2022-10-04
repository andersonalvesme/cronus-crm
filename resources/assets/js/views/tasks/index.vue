<template>
    <div>
        <x-filterable :filter-group="filters" :sortable="sortable" :title="title"
                      :url="url" ref="filterable">
            <div class="float-right" slot="extra">
                <router-link class="btn btn-primary w-xs" to="/tasks/create">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="5" type="th">{{$t('subject')}}</x-td>
                <x-td size="2" type="th">{{$t('due_date')}}</x-td>
                <x-td size="2" type="th">{{$t('status')}}</x-td>
                <x-td size="2" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/tasks/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.subject}}</x-td>
                <x-td>{{item.due_date | toDate}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.status.color}`">
			    		<span class="status-text">{{item.status.name}}</span>
			    	</span>
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
                url: 'tasks',
                title: 'tasks'
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'number', 'person', 'organization', 'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('lead'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'number', type: 'lookup', resource: 'tasks'},
                        {name: 'person', type: 'lookup', resource: 'tasks'},
                        {name: 'organization', type: 'lookup', resource: 'tasks'},
                        {name: 'title', type: 'string'},
                        {name: 'department', type: 'string'},
                        {name: 'email', type: 'lookup', resource: 'tasks'},
                        {name: 'website', type: 'lookup', resource: 'tasks'},
                        {name: 'fax', type: 'lookup', resource: 'tasks'},
                        {name: 'phone', type: 'lookup', resource: 'tasks'},
                        {name: 'mobile', type: 'lookup', resource: 'tasks'},
                        {name: 'primary_address', type: 'string'},
                        {name: 'other_address', type: 'string'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }, {
                    title: this.$t('status'),
                    filters: [
                        {name: 'status.name', type: 'lookup', resource: 'lead_statuses', column: 'name'},
                    ]
                }];

                return groups
            }
        }
    }
</script>
