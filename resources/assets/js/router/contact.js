export default [
	{
		path: '/contacts', component: require('@js/views/contacts/index.vue').default,
		meta: { resource: 'contacts' }
	},
	{
		path: '/contacts/create', component: require('@js/views/contacts/form.vue').default,
		meta: { resource: 'contacts', mode: 'create' }
	},
	{
		path: '/contacts/:id/edit', component: require('@js/views/contacts/form.vue').default,
		meta: { resource: 'contacts', mode: 'edit' }
	},
	{
		path: '/contacts/:id', component: require('@js/views/contacts/show.vue').default,
		meta: { resource: 'contacts'}
	}
]
