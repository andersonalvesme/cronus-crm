<template>
	<div class="content-inner" v-if="show">
		<x-panel padding margin>
			<div slot="title">
				<router-link to="/vendors">{{$t('vendor')}}</router-link> / {{model.name}}
				<small>({{model.number}})</small>
			</div>
			<div slot="extra" class="float-right">
				<router-link :to="`/vendors`" class="btn btn-default btn-sm">
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
				<router-link :to="`/vendors/${model.id}/edit`" class="btn btn-default btn-sm">
					<svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
				</router-link>
				<x-button size="sm" type="error" icon="trash-b" @click="removeDB('vendors', model.id)"></x-button>
			</div>
			<x-row line>
				<x-group col="8" label="number">
					<p>{{model.number}}</p>
				</x-group>
				<x-group col="8" label="category">
					<p v-if="model.category">
						{{model.category.name}}
					</p>
				</x-group>
				<x-group col="8" label="name">
					<p>{{model.name || '-'}}</p>
				</x-group>
				<x-group col="8" label="email">
					<p>{{model.email || '-'}}</p>
				</x-group>
		</x-row>
		<x-row line>
			<x-group col="8" label="phone">
				<p>{{model.phone || '-'}}</p>
			</x-group>
			<x-group col="8" label="mobile">
				<p>{{model.mobile || '-'}}</p>
			</x-group>
			<x-group col="8" label="fax">
				<p>{{model.fax || '-'}}</p>
			</x-group>
			<x-group col="8" label="website">
				<p>{{model.website || '-'}}</p>
			</x-group>
		</x-row>
		<x-row line>
			<x-group col="8" label="primary_address">
				<pre>{{model.primary_address || '-'}}</pre>
			</x-group>
			<x-group col="8" label="other_address">
				<pre>{{model.other_address || '-'}}</pre>
			</x-group>
		</x-row>
		<x-row v-if="model.custom_fields && model.custom_fields.length > 0" line>
			<custom-field-preview :field="field" :key="field.name"
				v-for="field in model.custom_fields" />
		</x-row>
		<x-row line>
			<x-group col="8" label="created_at">
				<pre>{{model.created_at | toDate}}</pre>
			</x-group>
			<x-group col="8" label="total_expense">
				<pre>{{model.total_expense | formatMoney}}</pre>
			</x-group>
		</x-row>
		</x-panel>
		<x-mini :url="`expenses?vendor_id=${this.model.id}`" title="expenses">
			<div slot="extra" class="float-right">
		    <router-link :to="`/expenses/create?vendor_id=${model.id}`" class="btn btn-primary w-xs">
		    	{{$t('new')}}
		    </router-link>
			</div>
			<x-tr slot="heading">
				<x-td type="th" size="3">{{$t('number')}}</x-td>
				<x-td type="th" size="3">{{$t('date')}}</x-td>
				<x-td type="th" size="4">{{$t('category')}}</x-td>
				<x-td type="th" size="4">{{$t('amount')}}</x-td>
		    <x-td type="th" size="4">{{$t('created_at')}}</x-td>
			</x-tr>
			<x-tr slot-scope="{ item }" @click.native="$router.push(`/expenses/${item.id}`)">
			  <x-td>{{item.number}}</x-td>
			  <x-td>{{item.date | toDate}}</x-td>
			  <x-td>{{item.category.name}}</x-td>
			  <x-td>{{item.amount | formatMoney}}</x-td>
		    <x-td>{{item.created_at | toDate}}</x-td>
			</x-tr>
		</x-mini>
	</div>
</template>
<script>
	import { showable } from '@js/lib/mixins'
	import Activity from '@js/partials/Activity.vue'
	import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'
	export default {
		mixins: [ showable ],
		components: { Activity, CustomFieldPreview },
		data() {
			return {
				show: false,
				model: {
					custom_fields: [],
					notes: [],
					organization: {}
				}
			}
		},
		methods: {

		}
	}
</script>
