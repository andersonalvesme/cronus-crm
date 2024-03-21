export default [
	{
		path: '/tasks', component: require('@js/views/tasks/index.vue').default,
		meta: { resource: 'tasks' }
	},
	{
		path: '/tasks/create', component: require('@js/views/tasks/form.vue').default,
		meta: { resource: 'tasks', mode: 'create' }
	},
	{
		path: '/tasks/:id/edit', component: require('@js/views/tasks/form.vue').default,
		meta: { resource: 'tasks', mode: 'edit' }
	},
	{
		path: '/tasks/:id', component: require('@js/views/tasks/show.vue').default,
		meta: { resource: 'tasks'}
	}
]
