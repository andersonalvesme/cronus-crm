export default [
	{
		path: 'invitations', component: require('@js/views/settings/invitations/index.vue').default,
		meta: { resource: 'settings/invitations' }
	},
	{
		path: 'invitations/create', component: require('@js/views/settings/invitations/form.vue').default,
		meta: { resource: 'settings/invitations', mode: 'create' }
	},
	{
		path: 'invitations/:id/edit', component: require('@js/views/settings/invitations/form.vue').default,
		meta: { resource: 'settings/invitations', mode: 'edit' }
	},
	{
		path: 'invitations/:id', component: require('@js/views/settings/invitations/show.vue').default,
		meta: { resource: 'settings/invitations'}
	}
]
