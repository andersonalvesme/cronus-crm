<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/templates">{{$t('template')}}</router-link>
                / {{model.name}}
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/templates`" class="btn btn-white btn-icon btn-sm mr-1">
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
                <x-dropdown class="float-right" icon="dots" size="sm">
                    <x-dropdown-menu dir="right" slot="menu">
                        <x-dropdown-item>
                            <a :href="`/api/templates/${model.id}/export`" target="_blank">
                                {{$t('export')}}
                            </a>
                        </x-dropdown-item>
                        <x-dropdown-link :to="`/templates/${model.id}/edit`" divide>
                            {{$t('edit')}}
                        </x-dropdown-link>
                        <a @click="removeDB('templates', model.id)" class="dropdown-item" href="javascript:void(0)">
                            {{$t('delete')}}
                        </a>
                    </x-dropdown-menu>
                </x-dropdown>
            </div>
            <x-row line>
                <x-group col="6" label="name">
                    <p>{{model.name}}</p>
                </x-group>
                <x-group col="3" label="type">
                    <p v-if="model.type">
                        {{model.type}}
                    </p>
                </x-group>
                <x-group col="3" label="page_size">
                    <p v-if="model.page_size">
                        {{model.page_size}}
                    </p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="orientation">
                    <p>{{model.orientation}}</p>
                </x-group>
                <x-group col="3" label="header_height">
                    <p v-if="model.header_height">
                        {{model.header_height}}
                    </p>
                </x-group>
                <x-group col="3" label="footer_height">
                    <p v-if="model.footer_height">
                        {{model.footer_height}}
                    </p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
            </x-row>
        </x-panel>
        <x-panel>
            <div slot="title">{{$t('preview')}}</div>
            <div class="float-right" slot="extra">
                <a :href="`/api/templates/${model.id}/preview`" class="btn btn-default btn-sm" target="_blank">
                    <small class="icon icon-android-download"></small>
                </a>
            </div>
            <div class="template-preview">
                <object :data="`/api/templates/${model.id}/preview`" height="100%" type="application/pdf" width="100%">
                </object>
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
                    pages: [],
                }
            }
        }
    }
</script>
