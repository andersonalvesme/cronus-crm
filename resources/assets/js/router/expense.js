export default [
	{
		path: '/expenses', component: require('@js/views/expenses/index.vue').default,
		meta: { resource: 'expenses' }
	},
	{
		path: '/expenses/create', component: require('@js/views/expenses/form.vue').default,
		meta: { resource: 'expenses', mode: 'create' }
	},
	{
		path: '/expenses/:id/edit', component: require('@js/views/expenses/form.vue').default,
		meta: { resource: 'expenses', mode: 'edit' }
	},
	{
		path: '/expenses/:id', component: require('@js/views/expenses/show.vue').default,
		meta: { resource: 'expenses'}
	}
]
