export default [
	{
		path: '/leads', component: require('@js/views/leads/index.vue').default,
		meta: { resource: 'leads' }
	},
	{
		path: '/leads/create', component: require('@js/views/leads/form.vue').default,
		meta: { resource: 'leads', mode: 'create' }
	},
	{
		path: '/leads/:id/edit', component: require('@js/views/leads/form.vue').default,
		meta: { resource: 'leads', mode: 'edit' }
	},
	{
		path: '/leads/:id', component: require('@js/views/leads/show.vue').default,
		meta: { resource: 'leads'}
	}
]
