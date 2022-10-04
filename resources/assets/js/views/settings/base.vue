<template>
    <div class="row">
        <div class="col-2 p-0">
            <div class="sticky-top">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <ul class="dropdown-menu dropdown-menu-demo show p-0 m-0">
                            <h6 class="dropdown-header">{{$t('settings')}}</h6>
                            <template v-for="item in items">
                                <div class="dropdown-divider" v-if="item.break"></div>
                                <router-link :to="item.to" class="dropdown-item" exact-active-class="active">
                                    {{$t(item.title)}}
                                </router-link>
                            </template>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-10">
            <transition mode="out-in" name="fade">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                items: [
                    {to: '/settings', title: 'system'},
                    {to: '/settings/email', title: 'email_send'},
                    {to: '/settings/globals', title: 'custom_fields'},
                    {to: '/settings/organizations', title: 'organizations', break: true},
                    {to: '/settings/contacts', title: 'contacts'},
                    {to: '/settings/items', title: 'items'},
                    {to: '/settings/leads', title: 'leads'},
                    {to: '/settings/opportunities', title: 'opportunities'},
                    {to: '/settings/proposals', title: 'proposals'},
                    {to: '/settings/contracts', title: 'contracts'},
                    {to: '/settings/projects', title: 'projects'},
                    {to: '/settings/tasks', title: 'tasks'},
                    {to: '/settings/invoices', title: 'invoices'},
                    {to: '/settings/payments', title: 'payments'},
                    {to: '/settings/expenses', title: 'expenses'},
                    {to: '/settings/vendors', title: 'vendors'},
                    {to: '/settings/web_payment', title: 'web_payments', break: true},
                    {to: '/settings/users', title: 'users'},
                    {to: '/settings/invitations', title: 'invitations'},
                    {to: '/settings/roles', title: 'roles_and_permission'}
                ]
            }
        }
    }
</script>
