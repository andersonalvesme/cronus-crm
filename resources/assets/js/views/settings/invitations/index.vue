<template>
	<div>
		<x-filterable :exportable="false" :url="url" :sortable="sortable" :filter-group="filters"
			ref="filterable" :title="title">
			<div slot="extra" class="float-right">
				<router-link to="/settings/invitations/create" class="btn btn-primary w-xs">
					{{$t('new')}}
				</router-link>
			</div>
			<x-tr slot="heading">
			    <x-td type="th" size="1">{{$t('id')}}</x-td>
			    <x-td type="th" size="5">{{$t('name')}}</x-td>
			    <x-td type="th" size="5">{{$t('email')}}</x-td>
			    <x-td type="th" size="1">{{$t('created_at')}}</x-td>
			</x-tr>
			<x-tr slot-scope="{ item }" @click.native="$router.push(`/settings/invitations/${item.id}`)">
			    <x-td>{{item.id}}</x-td>
			    <x-td>{{item.name}}</x-td>
			    <x-td>{{item.email}}</x-td>
			    <x-td>{{item.created_at | toDate}}</x-td>
			</x-tr>
		</x-filterable>
	</div>
</template>
<script>
	import { indexable } from '@js/lib/mixins'
	export default {
		mixins: [indexable],
		data() {
			return {
				url: 'settings/invitations',
				title: 'invitations'
			}
		},
		computed: {
			sortable() {
				let columns = [
				  'id', 'email',
				  'created_at'
				]
				return columns
			},
			filters() {
			    let groups = [{
			        title: this.$t('item'),
			        filters: [
			            {name: 'id', type: 'numeric'},
			            {name: 'email', type: 'string'},
			            {name: 'token', type: 'string'},
			            {name: 'created_at', type: 'datetime'},
			        ]
			    }]

			    return groups
			}
		}
	}
</script>
