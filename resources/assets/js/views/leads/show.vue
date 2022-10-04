<template>
	<div class="content-inner" v-if="show">
		<x-panel padding>
			<div slot="title">
				<router-link to="/leads">{{$t('lead')}}</router-link> / {{model.person}}
				<small>({{model.number}})</small>
			</div>
			<div slot="extra" class="float-right">
				<router-link :to="`/leads`" class="btn btn-white btn-icon btn-sm">
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
				<x-dropdown size="sm" icon="dots" class="float-right ml-1">
					<x-dropdown-menu slot="menu" dir="right">
						<x-dropdown-item v-for="(status, i) in model.all_status"
							:key="status.id"
							@click.native="markAs(status.id)">
							{{$t('mark_as')}} {{status.name}}
						</x-dropdown-item>
						<x-dropdown-link divide :to="`/leads/${model.id}/edit`">
							{{$t('edit')}}
						</x-dropdown-link>
                        <a class="dropdown-item" href="javascript:void(0)" @click="removeDB('leads', model.id)">
                            {{$t('delete')}}
                        </a>
					</x-dropdown-menu>
				</x-dropdown>
			</div>
			<x-row line>
				<x-group col="2" label="number">
					<p>{{model.number}}</p>
				</x-group>
				<x-group col="4" label="person">
					<p>{{model.person || '-'}}</p>
				</x-group>
				<x-group col="6" label="email">
					<p>{{model.email || '-'}}</p>
				</x-group>
				<x-group col="6" label="organization">
					<p v-if="model.organization">
						{{model.organization}}
					</p>
					<p v-else>-</p>
				</x-group>
				<x-group col="2" label="title">
					<p>{{model.title || '-'}}</p>
				</x-group>
				<x-group col="3" label="department">
					<p>{{model.department || '-'}}</p>
				</x-group>
			</x-row>
			<x-row line>
				<x-group col="3" label="phone">
					<p>{{model.phone || '-'}}</p>
				</x-group>
				<x-group col="3" label="mobile">
					<p>{{model.mobile || '-'}}</p>
				</x-group>
				<x-group col="3" label="fax">
					<p>{{model.fax || '-'}}</p>
				</x-group>
				<x-group col="3" label="website">
					<p>{{model.website || '-'}}</p>
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
			<x-row v-if="model.custom_fields && model.custom_fields.length > 0" line>
				<custom-field-preview :field="field" :key="field.name"
					v-for="field in model.custom_fields" />
			</x-row>
			<x-row line>
				<x-group col="3" label="created_at">
					<pre>{{model.created_at | toDate}}</pre>
				</x-group>
				<x-group col="3" label="status">
					<span :class="`badge bg-${model.status.color}`">
						<span class="status-text">{{model.status.name}}</span>
					</span>
				</x-group>
			</x-row>
		</x-panel>
	</div>
</template>
<script>
	import { showable } from '@js/lib/mixins'
	import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'
	export default {
		mixins: [ showable ],
		components: { CustomFieldPreview },
		data() {
			return {
				show: false,
				activeType: 'text',
				model: {
					status: {},
					all_status: {},
					custom_fields: []
				}
			}
		},
		methods: {
			markAs(type) {
				this.$bar.start()
				this.$http.post(`/api/mark-as/leads/${this.model.id}`, {type: type})
					.then((res) => {
						if(res.data.saved) {
							this.model.status = res.data.status
						}
					})
					.finally((res) => {
						this.$bar.finish()
					})
			}
		}
	}
</script>
