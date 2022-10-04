<template>
    <div>
        <div class="page">
            <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex">
                <div class="container-xl">
                    <a class="navbar-brand d-none-navbar-horizontal pr-0 pr-md-3" href="/">
                        <img alt="Cronus" class="navbar-brand-image" src="../images/brands/favicon-32x32.png">
                    </a>
                    <div class="navbar-nav flex-row order-md-last">
                        <div @mouseleave="dropDownUserExpanded = false" @mouseover="dropDownUserExpanded = true"
                             class="nav-item dropdown">
                            <a class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown"
                               href="javascript:void(0)">
                                <span class="avatar rounded bg-blue-lt">
                                    <svg class="icon icon-tabler icon-tabler-user" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"
                                 v-bind:class="{ show: dropDownUserExpanded }">
                                <span @click="toggleDarkMode" class="dropdown-item form-switch">
                                    <input :checked="darkMode" class="form-check-input m-0 mr-2" type="checkbox">
                                    {{ $t('dark_mode') }}
                                </span>
                                <router-link :to="`/personal_settings`" @click.native="dropDownUserExpanded = false"
                                             class="dropdown-item">
                                    <svg class="icon dropdown-item-icon" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    {{$t('personal_settings')}}
                                </router-link>
                                <template v-for="link in links">
                                    <router-link :to="link.to" @click.native="dropDownUserExpanded = false"
                                                 class="dropdown-item" exact-active-class="active"
                                                 v-if="link.parent === 'settings'">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                            <div v-html="link.icon"></div>
                                        </span>
                                        <span class="nav-link-title">{{$t(link.title)}}</span>
                                    </router-link>
                                </template>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout">
                                    <svg class="icon dropdown-item-icon" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                                        <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                                    </svg>
                                    {{$t('logout')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse">
                        <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                            <ul class="navbar-nav">
                                <!-- overview -->
                                <template v-for="link in links">
                                    <li class="nav-item" v-if="link.to === '/'"
                                        v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'overview' ? '' : $route.meta.resource))) }">
                                        <router-link :exact="link.to == '/' ? true : false" :to="link.to">
                                            <div class="nav-link"
                                                 v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'overview' ? '' : $route.meta.resource))) }">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </div>
                                        </router-link>
                                    </li>
                                </template>

                                <!-- sales_funnel -->
                                <li @mouseleave="showSalesFunnelMenu = false" @mouseover="showSalesFunnelMenu = true"
                                    class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                            <svg class="icon icon-tabler icon-tabler-filter"
                                                 fill="none" height="24" stroke="currentColor"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                                <path
                                                    d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">{{$t('sales_funnel')}}</span>
                                    </a>
                                    <ul class="dropdown-menu" v-bind:class="{show: showSalesFunnelMenu}">
                                        <li @click="showSalesFunnelMenu=false" v-for="link in links"
                                            v-if="link.parent === 'sales_funnel'">
                                            <router-link :to="link.to" class="dropdown-item"
                                                         exact-active-class="active">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>
                                <!-- tasks -->
                                <template v-for="link in links">
                                    <li class="nav-item" v-if="link.to === '/tasks'"
                                        v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'tasks' ? '' : $route.meta.resource))) }">
                                        <router-link :exact="link.to == '/' ? true : false" :to="link.to">
                                            <div class="nav-link"
                                                 v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'tasks' ? '' : $route.meta.resource))) }">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </div>
                                        </router-link>
                                    </li>
                                </template>
                                <!-- clients -->
                                <li @mouseleave="showClientMenu = false" @mouseover="showClientMenu = true"
                                    class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                            <svg class="icon icon-tabler icon-tabler-users"
                                                 fill="none" height="24" stroke="currentColor"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 width="24" xmlns="http://www.w3.org/2000/svg">
                                               <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                               <circle cx="9" cy="7" r="4"></circle>
                                               <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                               <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                               <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">{{$t('clients')}}</span>
                                    </a>
                                    <ul class="dropdown-menu" v-bind:class="{show: showClientMenu}">
                                        <li @click="showClientMenu=false" v-for="link in links"
                                            v-if="link.parent === 'clients'">
                                            <router-link :to="link.to" class="dropdown-item"
                                                         exact-active-class="active">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>
                                <!-- financial -->
                                <li @mouseleave="showFinancialMenu = false" @mouseover="showFinancialMenu = true"
                                    class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                            <svg class="icon icon-tabler icon-tabler-coin"
                                                 fill="none" height="24" stroke="currentColor"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <path
                                                    d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                                <path d="M12 6v2m0 8v2"></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">{{$t('financial')}}</span>
                                    </a>
                                    <ul class="dropdown-menu" v-bind:class="{show: showFinancialMenu}">
                                        <li @click="showFinancialMenu=false" v-for="link in links"
                                            v-if="link.parent === 'financial'">
                                            <router-link :to="link.to" class="dropdown-item"
                                                         exact-active-class="active">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>
                                <!-- items -->
                                <template v-for="link in links">
                                    <li class="nav-item" v-if="link.to === '/items'"
                                        v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'items' ? '' : $route.meta.resource))) }">
                                        <router-link :exact="link.to == '/' ? true : false" :to="link.to">
                                            <div class="nav-link"
                                                 v-bind:class="{ active: (link.to === ('/' + ($route.meta.resource === 'items' ? '' : $route.meta.resource))) }">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block mr-1">
                                                    <div v-html="link.icon"></div>
                                                </span>
                                                <span class="nav-link-title">{{$t(link.title)}}</span>
                                            </div>
                                        </router-link>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content container-xl">
                <router-view :key="$route.path"></router-view>
            </div>
        </div>
    </div>

</template>
<script>
    import {includes} from 'lodash'

    export default {
        computed: {
            links() {
                const list = [
                    {
                        title: 'overview',
                        to: '/',
                        break: true,
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <circle cx="12" cy="13" r="2"></circle>\n' +
                            '   <line x1="13.45" y1="11.55" x2="15.5" y2="9.5"></line>\n' +
                            '   <path d="M6.4 20a9 9 0 1 1 11.2 0z"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'leads',
                        to: '/leads',
                        parent: 'sales_funnel',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <circle cx="9" cy="7" r="4"></circle>\n' +
                            '   <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>\n' +
                            '   <path d="M16 11h6m-3 -3v6"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'opportunities',
                        to: '/opportunities',
                        parent: 'sales_funnel',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-flame" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -1.532 -1.056 -3.94 -2 -5c-1.786 3 -2.791 3 -4 2z"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'proposals',
                        to: '/proposals',
                        parent: 'sales_funnel',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>\n' +
                            '   <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>\n' +
                            '   <line x1="9" y1="9" x2="10" y2="9"></line>\n' +
                            '   <line x1="9" y1="13" x2="15" y2="13"></line>\n' +
                            '   <line x1="9" y1="17" x2="15" y2="17"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'contracts',
                        to: '/contracts',
                        parent: 'sales_funnel',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-like" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <rect x="3" y="16" width="3" height="5" rx="1"></rect>\n' +
                            '   <path d="M6 20a1 1 0 0 0 1 1h3.756a1 1 0 0 0 .958 -.713l1.2 -3c.09 -.303 .133 -.63 -.056 -.884c-.188 -.254 -.542 -.403 -.858 -.403h-2v-2.467a1.1 1.1 0 0 0 -2.015 -.61l-1.985 3.077v4z"></path>\n' +
                            '   <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>\n' +
                            '   <path d="M5 12.1v-7.1a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-2.3"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'projects',
                        to: '/projects',
                        parent: 'sales_funnel',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline>\n' +
                            '   <line x1="12" y1="12" x2="20" y2="7.5"></line>\n' +
                            '   <line x1="12" y1="12" x2="12" y2="21"></line>\n' +
                            '   <line x1="12" y1="12" x2="4" y2="7.5"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'tasks',
                        to: '/tasks',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>\n' +
                            '   <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>\n' +
                            '   <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>\n' +
                            '   <line x1="11" y1="6" x2="20" y2="6"></line>\n' +
                            '   <line x1="11" y1="12" x2="20" y2="12"></line>\n' +
                            '   <line x1="11" y1="18" x2="20" y2="18"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'organizations',
                        to: '/organizations',
                        parent: 'clients',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <line x1="3" y1="21" x2="21" y2="21"></line>\n' +
                            '   <line x1="9" y1="8" x2="10" y2="8"></line>\n' +
                            '   <line x1="9" y1="12" x2="10" y2="12"></line>\n' +
                            '   <line x1="9" y1="16" x2="10" y2="16"></line>\n' +
                            '   <line x1="14" y1="8" x2="15" y2="8"></line>\n' +
                            '   <line x1="14" y1="12" x2="15" y2="12"></line>\n' +
                            '   <line x1="14" y1="16" x2="15" y2="16"></line>\n' +
                            '   <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'contacts',
                        to: '/contacts',
                        parent: 'clients',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <circle cx="9" cy="7" r="4"></circle>\n' +
                            '   <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>\n' +
                            '   <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>\n' +
                            '   <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'invoices',
                        to: '/invoices',
                        parent: 'financial',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>\n' +
                            '   <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>\n' +
                            '   <line x1="9" y1="7" x2="10" y2="7"></line>\n' +
                            '   <line x1="9" y1="13" x2="15" y2="13"></line>\n' +
                            '   <line x1="13" y1="17" x2="15" y2="17"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'payments',
                        to: '/payments',
                        parent: 'financial',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <circle cx="12" cy="12" r="9"></circle>\n' +
                            '   <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>\n' +
                            '   <path d="M12 6v2m0 8v2"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'payment_requests',
                        to: '/payment_requests',
                        parent: 'financial',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <rect x="3" y="5" width="18" height="14" rx="3"></rect>\n' +
                            '   <line x1="3" y1="10" x2="21" y2="10"></line>\n' +
                            '   <line x1="7" y1="15" x2="7.01" y2="15"></line>\n' +
                            '   <line x1="11" y1="15" x2="13" y2="15"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'vendors',
                        to: '/vendors',
                        parent: 'financial',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <rect x="3" y="4" width="18" height="16" rx="3"></rect>\n' +
                            '   <circle cx="9" cy="10" r="2"></circle>\n' +
                            '   <line x1="15" y1="8" x2="17" y2="8"></line>\n' +
                            '   <line x1="15" y1="12" x2="17" y2="12"></line>\n' +
                            '   <line x1="7" y1="16" x2="17" y2="16"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'expenses',
                        to: '/expenses',
                        parent: 'financial',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <rect x="7" y="9" width="14" height="10" rx="2"></rect>\n' +
                            '   <circle cx="14" cy="14" r="2"></circle>\n' +
                            '   <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>\n' +
                            '</svg>'
                    },
                    // {icon: 'android-refresh', title: this.$t('recurring_invoices'), to: '/recurring-invoices'},
                    {
                        title: 'items',
                        to: '/items',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>\n' +
                            '   <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>\n' +
                            '   <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>\n' +
                            '   <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>\n' +
                            '   <rect x="5" y="11" width="1" height="2"></rect>\n' +
                            '   <line x1="10" y1="11" x2="10" y2="13"></line>\n' +
                            '   <rect x="14" y="11" width="1" height="2"></rect>\n' +
                            '   <line x1="19" y1="11" x2="19" y2="13"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'templates',
                        to: '/templates',
                        parent: 'settings',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <rect x="4" y="4" width="16" height="4" rx="1"></rect>\n' +
                            '   <rect x="4" y="12" width="6" height="8" rx="1"></rect>\n' +
                            '   <line x1="14" y1="12" x2="20" y2="12"></line>\n' +
                            '   <line x1="14" y1="16" x2="20" y2="16"></line>\n' +
                            '   <line x1="14" y1="20" x2="20" y2="20"></line>\n' +
                            '</svg>'
                    },
                    {
                        title: 'recurring_exports',
                        to: '/recurring_exports',
                        parent: 'settings',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-repeat" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M4 12v-3a3 3 0 0 1 3 -3h13m-3 -3l3 3l-3 3"></path>\n' +
                            '   <path d="M20 12v3a3 3 0 0 1 -3 3h-13m3 3l-3 -3l3 -3"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'media_library',
                        to: '/media_library',
                        parent: 'settings',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5"></path>\n' +
                            '</svg>'
                    },
                    {
                        title: 'settings',
                        to: '/settings',
                        parent: 'settings',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                            '   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                            '   <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>\n' +
                            '   <circle cx="12" cy="12" r="3"></circle>\n' +
                            '</svg>'
                    },
                ];

                const available = window.app.links || [];

                // enable auth
                return list.filter((item) => {
                    return includes(available, item.title)
                })
            }
        },
        data() {
            return {
                dropDownUserExpanded: false,
                showSalesFunnelMenu: false,
                showClientMenu: false,
                showFollowUpMenu: false,
                showFinancialMenu: false,
                showItemsMenu: false,
                darkMode: false,
                user: window.app.user,
            }
        },
        created() {
            let darkMode = localStorage.getItem('cronus.darkMode');
            this.darkMode = (darkMode === 'true');

            if (this.darkMode) {
                document.getElementById("bodySystem").classList.add("theme-dark");
            } else {
                document.getElementById("bodySystem").classList.remove("theme-dark");
            }
        },
        methods: {
            toggleDarkMode() {
                this.darkMode = !this.darkMode;

                localStorage.setItem('cronus.darkMode', this.darkMode);

                if (this.darkMode) {
                    document.getElementById("bodySystem").classList.add("theme-dark");
                } else {
                    document.getElementById("bodySystem").classList.remove("theme-dark");
                }
            }
        }
    }
</script>
