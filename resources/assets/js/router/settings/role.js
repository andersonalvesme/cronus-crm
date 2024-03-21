export default [
	{
		path: 'roles', component: require('@js/views/settings/roles/index.vue').default,
		meta: { resource: 'settings/roles' }
	},
	{
		path: 'roles/create', component: require('@js/views/settings/roles/form.vue').default,
		meta: { resource: 'settings/roles', mode: 'create' }
	},
	{
		path: 'roles/:id/edit', component: require('@js/views/settings/roles/form.vue').default,
		meta: { resource: 'settings/roles', mode: 'edit' }
	},
	{
		path: 'roles/:id', component: require('@js/views/settings/roles/show.vue').default,
		meta: { resource: 'settings/roles'}
	}
]
