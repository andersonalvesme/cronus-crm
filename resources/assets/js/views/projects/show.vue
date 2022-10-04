<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/projects">{{$t('projects')}}</router-link>
                / {{model.number}}
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/projects`" class="btn btn-white btn-icon btn-sm">
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
                        <x-dropdown-item :key="stage.id"
                                         @click.native="markAs(stage.id)"
                                         v-for="(stage, i) in model.all_stages">
                            {{$t('mark_as')}} {{stage.name}}
                        </x-dropdown-item>
                        <x-dropdown-link :to="`/projects/${model.id}/edit`" divide>
                            {{$t('edit')}}
                        </x-dropdown-link>
                        <a @click="removeDB('projects', model.id)" class="dropdown-item" href="javascript:void(0)">
                            {{$t('delete')}}
                        </a>
                    </x-dropdown-menu>
                </x-dropdown>
            </div>
            <x-row line>
                <x-group col="2" label="number">
                    <p>{{model.number}}</p>
                </x-group>
                <x-group col="4" label="contact">
                    <p v-if="model.contact">
                        <router-link :to="`/contacts/${model.contact_id}`">
                            {{model.contact.name}}
                        </router-link>
                    </p>
                </x-group>
                <x-group col="6" label="category">
                    <p v-if="model.category">
                        {{model.category.name}}
                    </p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="6" label="title">
                    <p>{{model.title}}</p>
                </x-group>
                <x-group col="6" label="proposal">
                    <p v-if="model.proposal">
                        <router-link :to="`/proposals/${model.proposal_id}`">
                            {{model.proposal.number}}
                        </router-link>
                    </p>
                    <p v-else>-</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="12" label="description">
                    <pre>{{model.description}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="start_date">
                    <p>{{model.start_date | toDate}}</p>
                </x-group>
                <x-group col="3" label="estimated_finish_date">
                    <p>{{model.estimated_finish_date | toDate}}</p>
                </x-group>
                <x-group col="3" label="deadline_date">
                    <p v-if="model.deadline_date">{{model.deadline_date | toDate}}</p>
                    <p v-else>-</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="actual_start_date">
                    <p v-if="model.actual_start_date">{{model.actual_start_date | toDate}}</p>
                    <p v-else>-</p>
                </x-group>
                <x-group col="3" label="actual_end_date">
                    <p v-if="model.actual_end_date">{{model.actual_end_date | toDate}}</p>
                    <p v-else>-</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="estimated_cost">
                    <p v-if="model.estimated_cost">{{model.estimated_cost | formatMoney}}</p>
                    <p v-else>-</p>
                </x-group>
                <x-group col="3" label="actual_cost">
                    <p v-if="model.actual_cost">{{model.actual_cost | formatMoney}}</p>
                    <p v-else>-</p>
                </x-group>
                <x-group col="3" label="cost_consumption">
                    <p>{{model.cost_consumption}}%</p>
                </x-group>
            </x-row>
            <x-row line v-if="model.custom_fields && model.custom_fields.length > 0">
                <custom-field-preview :field="field" :key="field.name"
                                      v-for="field in model.custom_fields"/>
            </x-row>
            <x-row line>
                <x-group col="3" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
                <x-group col="3" label="stage">
					<span :class="`badge bg-${model.stage.color}`">
						{{model.stage.name}}
					</span>
                </x-group>
            </x-row>
        </x-panel>
        <project-tasks :project="this.model.id" :url="`project_tasks`" title="project_tasks">
            <x-tr slot="heading">
                <x-td size="5" type="th">{{$t('title')}}</x-td>
                <x-td size="3" type="th">{{$t('start_date')}}</x-td>
                <x-td size="3" type="th">{{$t('due_date')}}</x-td>
                <x-td size="8" type="th">{{$t('description')}}</x-td>
                <x-td colspan="2" size="5" type="th">{{$t('stage')}}</x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.title}}</x-td>
                <x-td>{{item.start_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.due_date">{{item.start_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.description}}</x-td>
                <x-td>
			  	<span :class="`badge bg-${item.stage.color}`">
		    		<span class="status-text">{{item.stage.name}}</span>
		    	</span>
                </x-td>
                <x-td>
                    <div>
                        <x-button @click="edit(item)" icon="edit" size="sm"></x-button>
                        <x-button @click="remove(item)" icon="trash-b" size="sm" type="error"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </project-tasks>
        <x-mini :url="`expenses?project_id=${this.model.id}`" title="expenses">
            <div class="float-right" slot="extra">
                <router-link :to="`/expenses/create?project_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="3" type="th">{{$t('number')}}</x-td>
                <x-td size="3" type="th">{{$t('date')}}</x-td>
                <x-td size="4" type="th">{{$t('category')}}</x-td>
                <x-td size="4" type="th">{{$t('amount')}}</x-td>
                <x-td size="4" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/expenses/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.date | toDate}}</x-td>
                <x-td>{{item.category.name}}</x-td>
                <x-td>{{item.amount | formatMoney}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'
    import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'
    import ProjectTasks from '@js/partials/ProjectTasks.vue'
    import XRow from "../../components/grid/Row";

    export default {
        mixins: [showable],
        components: {XRow, CustomFieldPreview, ProjectTasks},
        data() {
            return {
                show: false,
                model: {
                    notes: [],
                    contact: {},
                    proposal: {},
                    catgory: {},
                    stage: {},
                    all_stages: []
                },
            }
        },
        methods: {

            markAs(type) {
                this.$bar.start();
                this.$http.post(`/api/mark-as/projects/${this.model.id}`, {type: type})
                    .then((res) => {
                        if (res.data.saved) {
                            this.$set(this.model, 'stage', res.data.stage)
                        }
                    })
                    .finally((res) => {
                        this.$bar.finish()
                    })
            }
        }
    }
</script>
