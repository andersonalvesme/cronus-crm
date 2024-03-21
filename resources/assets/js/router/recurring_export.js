export default [
	{
		path: '/recurring_exports', component: require('@js/views/recurring_exports/index.vue').default,
		meta: { resource: 'recurring_exports' }
	},
	{
		path: '/recurring_exports/:id', component: require('@js/views/recurring_exports/show.vue').default,
		meta: { resource: 'recurring_exports'}
	}
]
