export default [
	{
		path: '/payments', component: require('@js/views/payments/index.vue').default,
		meta: { resource: 'payments' }
	},
	{
		path: '/payments/create', component: require('@js/views/payments/form.vue').default,
		meta: { resource: 'payments', mode: 'create' }
	},
	{
		path: '/payments/:id/edit', component: require('@js/views/payments/form.vue').default,
		meta: { resource: 'payments', mode: 'edit' }
	},
	{
		path: '/payments/:id', component: require('@js/views/payments/show.vue').default,
		meta: { resource: 'payments'}
	}
]
