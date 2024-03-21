export default [
	{
		path: '/templates', component: require('@js/views/templates/index.vue').default,
		meta: { resource: 'templates' }
	},
	{
		path: '/templates/create', component: require('@js/views/templates/form.vue').default,
		meta: { resource: 'templates', mode: 'create' }
	},
	{
		path: '/templates/:id/edit', component: require('@js/views/templates/form.vue').default,
		meta: { resource: 'templates', mode: 'edit' }
	},
	{
		path: '/templates/:id', component: require('@js/views/templates/show.vue').default,
		meta: { resource: 'templates'}
	}
]
