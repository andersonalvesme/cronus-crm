<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/settings/roles">{{$t('role')}}</router-link>
                / {{model.name}}
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/settings/roles`" class="btn btn-white btn-sm btn-icon">
                    <svg class="icon icon-tabler icon-tabler-arrow-left" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <line x1="5" x2="19" y1="12" y2="12"></line>
                        <line x1="5" x2="11" y1="12" y2="18"></line>
                        <line x1="5" x2="11" y1="12" y2="6"></line>
                    </svg>
                </router-link>
                <router-link :to="`/settings/roles/${model.id}/edit`" class="btn btn-white btn-sm btn-icon">
                    <svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
                </router-link>
                <x-button @click="removeDB('settings/roles', model.id)" class="btn-white" icon="trash"
                          size="sm"></x-button>
            </div>
            <x-row line>
                <x-group col="12" label="code">
                    <p>{{model.name}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="12" label="description">
                    <pre>{{model.description}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="4" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
            </x-row>
        </x-panel>
        <x-panel padding>
            <div slot="title">{{$t('permissions')}}</div>
            <div>
                <x-row :key="permission.name" line v-for="permission in model.permissions">
                    <x-group :label="permission.name" col="12">
                        <x-row line>
                            <x-col :key="key" span="2" v-for="(value, key) in permission.actions">
                                <span v-if="value">
                                    <svg class="icon text-success" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                       <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                       <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                </span>
                                <span v-else>
                                    <svg class="icon text-danger" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <line x1="18" x2="6" y1="6" y2="18"></line>
                                        <line x1="6" x2="18" y1="6" y2="18"></line>
                                    </svg>
                                </span>
                                <span class="permission-text">{{$t(key)}}</span>
                            </x-col>
                        </x-row>
                    </x-group>
                </x-row>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'

    export default {
        mixins: [showable],
        data() {
            return {
                show: false,
                model: {
                    permissions: []
                }
            }
        }
    }
</script>
