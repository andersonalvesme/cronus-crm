export default [
	{
		path: 'users', component: require('@js/views/settings/users/index.vue').default,
		meta: { resource: 'settings/users' }
	},
	{
		path: 'users/create', component: require('@js/views/settings/users/form.vue').default,
		meta: { resource: 'settings/users', mode: 'create' }
	},
	{
		path: 'users/:id/edit', component: require('@js/views/settings/users/form.vue').default,
		meta: { resource: 'settings/users', mode: 'edit' }
	},
	{
		path: 'users/:id', component: require('@js/views/settings/users/show.vue').default,
		meta: { resource: 'settings/users'}
	}
]
