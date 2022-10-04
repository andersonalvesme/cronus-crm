<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/opportunities">{{$t('opportunity')}}</router-link>
                / {{model.title}}
                <small>({{model.number}})</small>
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/opportunities`" class="btn btn-white btn-icon btn-sm">
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

                <x-dropdown icon="dots" size="sm" class="float-right ml-1">
                    <x-dropdown-menu slot="menu" dir="right">
                        <x-dropdown-item @click.native="markStatusAs('won')">{{$t('mark_as_won')}}</x-dropdown-item>
                        <x-dropdown-item @click.native="markStatusAs('lost')">{{$t('mark_as_lost')}}</x-dropdown-item>
                        <x-dropdown-item :divide="i === 0" :key="stage.id"
                                         @click.native="markAs(stage.id)"
                                         v-for="(stage, i) in model.all_stages">
                            {{$t('mark_as')}} {{stage.name}}
                        </x-dropdown-item>

                        <x-dropdown-link :to="`/opportunities/${model.id}/edit`" divide>
                            {{$t('edit')}}
                        </x-dropdown-link>
                        <a class="dropdown-item" href="javascript:void(0)" @click="removeDB('opportunities', model.id)">
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
                    <p v-else>-</p>
                </x-group>
                <x-group col="6" label="title">
                    <p>{{model.title || '-'}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="12" label="description">
                    <pre>{{model.description || '-'}}</pre>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="value">
                    <p>{{model.value | formatMoney}}</p>
                </x-group>
                <x-group col="3" label="start_date">
                    <p>{{model.start_date | toDate}}</p>
                </x-group>
                <x-group col="3" label="close_date">
                    <p>{{model.close_date | toDate}}</p>
                </x-group>
                <x-group col="3" label="category">
                    <p v-if="model.category">
                        {{model.category.name}}
                    </p>
                    <p v-else>-</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="source">
                    <p v-if="model.source">
                        {{model.source.name}}
                    </p>
                    <p v-else>-</p>
                </x-group>
                <x-group col="3" label="probability">
                    <pre>{{model.probability}} %</pre>
                </x-group>
            </x-row>
            <x-row line v-if="model.custom_fields && model.custom_fields.length > 0">
                <custom-field-preview :field="field" :key="field.name"
                                      v-for="field in model.custom_fields"/>
            </x-row>
            <x-row line>
                <x-group col="3" label="created_at">
                    <p>{{model.created_at | toDate}}</p>
                </x-group>
                <x-group col="3" label="status">
                    <p>
                        <x-status :id="model.status_id"></x-status>
                    </p>
                </x-group>
                <x-group col="3" label="stage">
					<span :class="`badge bg-${model.stage.color}`">
						{{model.stage.name}}
					</span>
                </x-group>
            </x-row>
        </x-panel>
        <x-mini :url="`proposals?opportunity_id=${this.model.id}`" title="proposals">
            <div class="float-right" slot="extra">
                <router-link :to="`/proposals/create?opportunity_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="2" type="th">{{$t('issue_date')}}</x-td>
                <x-td size="2" type="th">{{$t('expiry_date')}}</x-td>
                <x-td size="4" type="th">{{$t('contact')}}</x-td>
                <x-td size="2" type="th">{{$t('status')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/proposals/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.issue_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.expiry_date">{{item.expiry_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.contact.name}}</x-td>
                <x-td>
		    	<span :class="`badge bg-${item.status.color}`">
		    		<span class="status-text">{{item.status.name}}</span>
		    	</span>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>

        <x-mini :url="`expenses?opportunity_id=${this.model.id}`" title="expenses">
            <div class="float-right" slot="extra">
                <router-link :to="`/expenses/create?opportunity_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="3" type="th">{{$t('number')}}</x-td>
                <x-td size="3" type="th">{{$t('date')}}</x-td>
                <x-td size="4" type="th">{{$t('category')}}</x-td>
                <x-td size="7" type="th">{{$t('vendor')}}</x-td>
                <x-td size="4" type="th">{{$t('amount')}}</x-td>
                <x-td size="3" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/expenses/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.date | toDate}}</x-td>
                <x-td>{{item.category.name}}</x-td>
                <x-td>{{item.vendor.name}}</x-td>
                <x-td>{{item.amount | formatMoney}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'
    import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'

    export default {
        mixins: [showable],
        components: {CustomFieldPreview},
        data() {
            return {
                show: false,
                model: {
                    notes: [],
                    contact: {},
                    category: {},
                    source: {},
                    stage: {},
                    all_stages: []
                },
            }
        },
        methods: {
            markStatusAs(type) {
                this.$bar.start();
                this.$http.post(`/api/mark-as/opportunities/${this.model.id}/status`, {type: type})
                    .then((res) => {
                        if (res.data.saved) {
                            this.$set(this.model, 'status_id', res.data.status_id);
                            this.$set(this.model, 'stage', res.data.stage)
                        }
                    })
                    .finally((res) => {
                        this.$bar.finish()
                    })
            },
            markAs(type) {
                this.$bar.start();
                this.$http.post(`/api/mark-as/opportunities/${this.model.id}`, {type: type})
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
