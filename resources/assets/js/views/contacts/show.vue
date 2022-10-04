<template>
    <div v-if="show">
        <x-panel margin padding>
            <div slot="title">
                <router-link to="/contacts">{{$t('contact')}}</router-link>
                / {{model.name}}
                <small>({{model.number}})</small>
            </div>
            <div class="float-right" slot="extra">
                <router-link :to="`/contacts`" class="btn btn-white btn-icon btn-sm">
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
                <router-link :to="`/contacts/${model.id}/edit`" class="btn btn-white btn-icon btn-sm">
                    <svg class="icon icon-tabler icon-tabler-pencil" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <line x1="13.5" x2="17.5" y1="6.5" y2="10.5"></line>
                    </svg>
                </router-link>
                <x-button @click="removeDB('contacts', model.id)" class="btn-icon" size="sm" type="danger">
                    <svg class="icon icon-tabler icon-tabler-trash" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                        <line x1="4" x2="20" y1="7" y2="7"></line>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    </svg>
                </x-button>
            </div>
            <x-row line>
                <x-group col="2" label="number">
                    <p>{{model.number}}</p>
                </x-group>
                <x-group col="4" label="organization">
                    <p v-if="model.organization">
                        <router-link :to="`/organizations/${model.organization_id}`">
                            {{model.organization.name}}
                        </router-link>
                    </p>
                    <p v-else>-</p>
                </x-group>
                <x-group col="6" label="name">
                    <p>{{model.name || '-'}}</p>
                </x-group>
                <x-group col="6" label="email">
                    <p>{{model.email || '-'}}</p>
                </x-group>
                <x-group col="6" label="title">
                    <p>{{model.title || '-'}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="3" label="department">
                    <p>{{model.department || '-'}}</p>
                </x-group>
                <x-group col="3" label="website">
                    <p>{{model.website || '-'}}</p>
                </x-group>
                <x-group col="2" label="phone">
                    <p>{{model.phone || '-'}}</p>
                </x-group>
                <x-group col="2" label="mobile">
                    <p>{{model.mobile || '-'}}</p>
                </x-group>
                <x-group col="2" label="fax">
                    <p>{{model.fax || '-'}}</p>
                </x-group>
            </x-row>
            <x-row line>
                <x-group col="6" label="primary_address">
                    <pre>{{model.primary_address || '-'}}</pre>
                </x-group>
                <x-group col="6" label="other_address">
                    <pre>{{model.other_address || '-'}}</pre>
                </x-group>
            </x-row>
            <x-row line v-if="model.custom_fields && model.custom_fields.length > 0">
                <custom-field-preview :field="field" :key="field.name"
                                      v-for="field in model.custom_fields"/>
            </x-row>
            <x-row line>
                <x-group col="8" label="created_at">
                    <pre>{{model.created_at | toDate}}</pre>
                </x-group>
            </x-row>
        </x-panel>
        <x-mini :url="`opportunities?contact_id=${this.model.id}`" title="opportunities">
            <div class="float-right" slot="extra">
                <router-link :to="`/opportunities/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="2" type="th">{{$t('category')}}</x-td>
                <x-td size="4" type="th">{{$t('title')}}</x-td>
                <x-td size="2" type="th">{{$t('stage')}}</x-td>
                <x-td size="2" type="th">{{$t('status')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/opportunities/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.category.name}}</x-td>
                <x-td>{{item.title | trim(40)}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.stage.color}`">
			    		{{item.stage.name}}
			    	</span>
                </x-td>
                <x-td>
                    <x-status :id="item.status_id"></x-status>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
        <x-mini :url="`proposals?contact_id=${this.model.id}`" title="proposals">
            <div class="float-right" slot="extra">
                <router-link :to="`/proposals/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('number')}}</x-td>
                <x-td size="2" type="th">{{$t('issue_date')}}</x-td>
                <x-td size="2" type="th">{{$t('expiry_date')}}</x-td>
                <x-td size="3" type="th">{{$t('opportunity')}}</x-td>
                <x-td size="3" type="th">{{$t('status')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/proposals/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.issue_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.expiry_date">{{item.expiry_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.opportunity ? item.opportunity.number : '-'}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.status.color}`">
			    		<span class="status-text">{{item.status.name}}</span>
			    	</span>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
        <x-mini :url="`contracts?contact_id=${this.model.id}`" title="contracts">
            <div class="float-right" slot="extra">
                <router-link :to="`/contracts/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="4" type="th">{{$t('number')}}</x-td>
                <x-td size="3" type="th">{{$t('start_date')}}</x-td>
                <x-td size="3" type="th">{{$t('expiry_date')}}</x-td>
                <x-td size="8" type="th">{{$t('title')}}</x-td>
                <x-td size="3" type="th">{{$t('status')}}</x-td>
                <x-td size="4" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/contracts/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.start_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.expiry_date">{{item.expiry_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.title}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.status.color}`">
			    		<span class="status-text">{{item.status.name}}</span>
			    	</span>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
        <x-mini :url="`projects?contact_id=${this.model.id}`" title="projects">
            <div class="float-right" slot="extra">
                <router-link :to="`/projects/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="4" type="th">{{$t('number')}}</x-td>
                <x-td size="4" type="th">{{$t('start_date')}}</x-td>
                <x-td size="4" type="th">{{$t('deadline_date')}}</x-td>
                <x-td size="4" type="th">{{$t('progress')}}</x-td>
                <x-td size="4" type="th">{{$t('stage')}}</x-td>
                <x-td size="4" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/projects/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.start_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.deadline_date">{{item.deadline_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.progress}} %</x-td>
                <x-td>
		    	<span :class="`badge bg-${item.stage.color}`">
		    		<span class="status-text">{{item.stage.name}}</span>
		    	</span>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
        <x-mini :url="`invoices?contact_id=${this.model.id}`" title="invoices">
            <div class="float-right" slot="extra">
                <router-link :to="`/invoices/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="4" type="th">{{$t('number')}}</x-td>
                <x-td size="4" type="th">{{$t('issue_date')}}</x-td>
                <x-td size="4" type="th">{{$t('due_date')}}</x-td>
                <x-td size="4" type="th">{{$t('grand_total')}}</x-td>
                <x-td size="4" type="th">{{$t('status')}}</x-td>
                <x-td size="4" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/invoices/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.issue_date | toDate}}</x-td>
                <x-td>
                    <span v-if="item.due_date">{{item.due_date | toDate}}</span>
                    <span v-else>-</span>
                </x-td>
                <x-td>{{item.grand_total}}</x-td>
                <x-td>
			  	<span :class="`badge bg-${item.status.color}`">
			  		<span class="status-text">{{item.status.name}}</span>
			  	</span>
                </x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
        <x-mini :url="`payments?contact_id=${this.model.id}`" title="payments">
            <div class="float-right" slot="extra">
                <router-link :to="`/payments/create?contact_id=${model.id}`" class="btn btn-primary w-xs">
                    {{$t('new')}}
                </router-link>
            </div>
            <x-tr slot="heading">
                <x-td size="3" type="th">{{$t('number')}}</x-td>
                <x-td size="4" type="th">{{$t('payment_date')}}</x-td>
                <x-td size="6" type="th">{{$t('deposit_to')}}</x-td>
                <x-td size="5" type="th">{{$t('amount_received')}}</x-td>
                <x-td size="4" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr @click.native="$router.push(`/payments/${item.id}`)" slot-scope="{ item }">
                <x-td>{{item.number}}</x-td>
                <x-td>{{item.payment_date | toDate}}</x-td>
                <x-td>{{item.deposit.name}}</x-td>
                <x-td>{{item.amount_received}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
            </x-tr>
        </x-mini>
    </div>
</template>
<script>
    import {showable} from '@js/lib/mixins'
    import Activity from '@js/partials/Activity.vue'
    import CustomFieldPreview from '@js/partials/CustomFieldPreview.vue'

    export default {
        mixins: [showable],
        components: {Activity, CustomFieldPreview},
        data() {
            return {
                show: false,
                model: {
                    notes: [],
                    organization: {}
                }
            }
        },
        methods: {}
    }
</script>
