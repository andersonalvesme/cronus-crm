export default [
	{
		path: '/projects', component: require('@js/views/projects/index.vue').default,
		meta: { resource: 'projects' }
	},
	{
		path: '/projects/create', component: require('@js/views/projects/form.vue').default,
		meta: { resource: 'projects', mode: 'create' }
	},
	{
		path: '/projects/:id/edit', component: require('@js/views/projects/form.vue').default,
		meta: { resource: 'projects', mode: 'edit' }
	},
	{
		path: '/projects/:id', component: require('@js/views/projects/show.vue').default,
		meta: { resource: 'projects'}
	}
]
