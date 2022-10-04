<template>
	<div class="content-inner" v-if="show">
		<x-panel margin padding>
			<div slot="title">
				<router-link to="/settings/users">{{$t('user')}}</router-link> / {{model.name}}
			</div>
			<div slot="extra" class="float-right">
				<router-link :to="`/settings/users`" class="btn btn-sm btn-white btn-icon">
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
				<router-link :to="`/settings/users/${model.id}/edit`" class="btn btn-sm btn-white btn-icon">
					<svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
				</router-link>
				<x-button size="sm" type="error" icon="trash" class="btn-white"
					@click="removeDB('settings/users', model.id)"></x-button>
			</div>
				<x-row line>
					<x-group col="4" label="code">
						<p>{{model.name}}</p>
					</x-group>
					<x-group col="4" label="email">
						<pre>{{model.email}}</pre>
					</x-group>
					<x-group col="4" label="role">
						<p v-if="model.role">
							<router-link :to="`/settings/roles/${model.role_id}`">
								{{model.role.name}}
							</router-link>
						</p>
					</x-group>
					<x-group col="4" label="created_at">
						<pre>{{model.created_at | toDate}}</pre>
					</x-group>
			</x-row>
		</x-panel>

	</div>
</template>
<script>
	import { showable } from '@js/lib/mixins'

	export default {
		mixins: [ showable ],
		data() {
			return {
				show: false,
				model: {
					permissions: []
				}
			}
		}
	}
</script>
