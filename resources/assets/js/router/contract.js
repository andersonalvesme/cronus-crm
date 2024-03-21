export default [
	{
		path: '/contracts', component: require('@js/views/contracts/index.vue').default,
		meta: { resource: 'contracts' }
	},
	{
		path: '/contracts/create', component: require('@js/views/contracts/form.vue').default,
		meta: { resource: 'contracts', mode: 'create' }
	},
	{
		path: '/contracts/:id/edit', component: require('@js/views/contracts/form.vue').default,
		meta: { resource: 'contracts', mode: 'edit' }
	},
	{
		path: '/contracts/:id', component: require('@js/views/contracts/show.vue').default,
		meta: { resource: 'contracts'}
	}
]
