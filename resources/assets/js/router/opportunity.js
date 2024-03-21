export default [
	{
		path: '/opportunities', component: require('@js/views/opportunities/index.vue').default,
		meta: { resource: 'opportunities' }
	},
	{
		path: '/opportunities/create', component: require('@js/views/opportunities/form.vue').default,
		meta: { resource: 'opportunities', mode: 'create' }
	},
	{
		path: '/opportunities/:id/edit', component: require('@js/views/opportunities/form.vue').default,
		meta: { resource: 'opportunities', mode: 'edit' }
	},
	{
		path: '/opportunities/:id', component: require('@js/views/opportunities/show.vue').default,
		meta: { resource: 'opportunities'}
	}
]
