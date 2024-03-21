import role from './settings/role'
import user from './settings/user'
import invitation from './settings/invitation'

export default [
	{
		path: '/settings', component: require('@js/views/settings/base.vue').default,
		children: [
			...role,
			...user,
			...invitation,
			{
				path: '', component: require('@js/views/settings/general.vue').default,
				meta: { resource: 'settings/general' }
			},
			{
				path: 'contacts', component: require('@js/views/settings/contacts.vue').default,
				meta: { resource: 'settings/custom_fields?type=contacts' }
			},
			{
				path: 'organizations', component: require('@js/views/settings/organizations.vue').default,
				meta: { resource: 'settings/organizations' }
			},
			{
				path: 'items', component: require('@js/views/settings/items.vue').default,
				meta: { resource: 'settings/items' }
			},
			{
				path: 'leads', component: require('@js/views/settings/leads.vue').default,
				meta: { resource: 'settings/leads' }
			},
			{
				path: 'opportunities', component: require('@js/views/settings/opportunities.vue').default,
				meta: { resource: 'settings/opportunities' }
			},
			{
				path: 'proposals', component: require('@js/views/settings/proposals.vue').default,
				meta: { resource: 'settings/proposals' }
			},
			{
				path: 'contracts', component: require('@js/views/settings/contracts.vue').default,
				meta: { resource: 'settings/contracts' }
			},
			{
				path: 'projects', component: require('@js/views/settings/projects.vue').default,
				meta: { resource: 'settings/projects' }
			},
            {
                path: 'tasks', component: require('@js/views/settings/tasks.vue').default,
                meta: { resource: 'settings/tasks' }
            },
			{
				path: 'invoices', component: require('@js/views/settings/invoices.vue').default,
				meta: { resource: 'settings/invoices' }
			},
			{
				path: 'payments', component: require('@js/views/settings/payments.vue').default,
				meta: { resource: 'settings/payments' }
			},
			{
				path: 'expenses', component: require('@js/views/settings/expenses.vue').default,
				meta: { resource: 'settings/expenses' }
			},
			{
				path: 'vendors', component: require('@js/views/settings/vendors.vue').default,
				meta: { resource: 'settings/vendors' }
			},
			{
				path: 'email', component: require('@js/views/settings/email.vue').default,
				meta: { resource: 'settings/email_base' }
			},
			{
				path: 'web_payment', component: require('@js/views/settings/web_payment.vue').default,
				meta: { resource: 'settings/web_payments' }
			},
			{
				path: 'globals', component: require('@js/views/settings/globals.vue').default,
				meta: { resource: 'settings/globals' }
			}
		]
	}
]
