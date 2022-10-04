<template>
    <div class="content-inner" v-if="show">
        <x-panel padding>
            <div slot="title">
                <router-link to="/tasks">{{$t('task')}}</router-link>
                / {{model.person}}
                <small>({{model.number}})</small>
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/tasks`" class="btn btn-white btn-icon btn-sm">
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
                <x-dropdown class="float-right ml-1" icon="dots" size="sm">
                    <x-dropdown-menu dir="right" slot="menu">
                        <x-dropdown-item :key="status.id"
                                         @click.native="markAs(status.id)"
                                         v-for="(status, i) in model.all_statuses">
                            {{$t('mark_as')}} {{status.name}}
                        </x-dropdown-item>
                        <x-dropdown-link :to="`/tasks/${model.id}/edit`" divide>
                            {{$t('edit')}}
                        </x-dropdown-link>
                        <a @click="removeDB('tasks', model.id)" class="dropdown-item" href="javascript:void(0)">
                            {{$t('delete')}}
                        </a>
                    </x-dropdown-menu>
                </x-dropdown>
            </div>
            <x-row line>
                <x-group col="2" label="number">
                    <p>{{model.number}}</p>
                </x-group>
                <x-group col="4" label="subject">
                    <p>{{model.subject || '-'}}</p>
                </x-group>
                <x-group col="3" label="type">
                    <p>{{model.type.name}}</p>
                </x-group>
                <x-group col="3" label="due_date">
                    {{model.due_date | toDate}}
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="12" label="description">
                    <pre>{{model.description}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
                <x-group col="3" label="status">
					<span :class="`badge bg-${model.status.color}`">
						<span class="status-text">{{model.status.name}}</span>
					</span>
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
                activeType: 'text',
                model: {
                    status: {},
                    all_statuses: {},
                }
            }
        },
        methods: {
            markAs(type) {
                this.$bar.start();
                this.$http.post(`/api/mark-as/tasks/${this.model.id}`, {type: type})
                    .then((res) => {
                        if (res.data.saved) {
                            this.model.status = res.data.status
                        }
                    })
                    .finally((res) => {
                        this.$bar.finish()
                    })
            }
        }
    }
</script>
