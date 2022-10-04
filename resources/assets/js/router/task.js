export default [
	{
		path: '/tasks', component: require('@js/views/tasks/index.vue'),
		meta: { resource: 'tasks' }
	},
	{
		path: '/tasks/create', component: require('@js/views/tasks/form.vue'),
		meta: { resource: 'tasks', mode: 'create' }
	},
	{
		path: '/tasks/:id/edit', component: require('@js/views/tasks/form.vue'),
		meta: { resource: 'tasks', mode: 'edit' }
	},
	{
		path: '/tasks/:id', component: require('@js/views/tasks/show.vue'),
		meta: { resource: 'tasks'}
	}
]
