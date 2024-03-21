export default [
	{
		path: '/proposals', component: require('@js/views/proposals/index.vue').default,
		meta: { resource: 'proposals' }
	},
	{
		path: '/proposals/create', component: require('@js/views/proposals/form.vue').default,
		meta: { resource: 'proposals', mode: 'create' }
	},
	{
		path: '/proposals/:id/edit', component: require('@js/views/proposals/form.vue').default,
		meta: { resource: 'proposals', mode: 'edit' }
	},
	{
		path: '/proposals/:id', component: require('@js/views/proposals/show.vue').default,
		meta: { resource: 'proposals'}
	}
]
