<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/settings/invitations">{{$t('invitation')}}</router-link>
                / {{model.name}}
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/settings/invitations`" class="btn btn-white btn-sm btn-icon">
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
                <x-button @click="removeDB('settings/invitations', model.id)" icon="trash" size="sm" class="btn-white"
                          type="error"></x-button>
            </div>
            <x-row line>
                <x-group col="4" label="code">
                    <p>{{model.name}}</p>
                </x-group>
                <x-group col="4" label="email">
                    <pre>{{model.email}}</pre>
                </x-group>
                <x-group col="4" label="role">
                    <pre>{{model.role.name}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="4" label="token">
                    <pre>{{model.token}}</pre>
                </x-group>
                <x-group col="4" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
            </x-row>
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
