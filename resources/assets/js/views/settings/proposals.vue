<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('proposals')})}}</div>
            <div class="float-right" slot="extra">
                <x-button @click="toggleVarModal">{{$t('variables')}}</x-button>
            </div>
            <x-row line>
                <x-form-group :errors="errors.proposal_status_on_create_id" :label="$t('proposal_status_on_create_id')"
                              col="4">
                    <x-tag-input :value="form.proposal_status_on_create"
                                 @input="value => { form.proposal_status_on_create_id = value.id; form.proposal_status_on_create = value }"
                                 column="name"
                                 name="name"
                                 resource="proposal_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.proposal_status_on_email_sent_id"
                              :label="$t('proposal_status_on_email_sent_id')"
                              col="4">
                    <x-tag-input :value="form.proposal_status_on_email_sent"
                                 @input="value => { form.proposal_status_on_email_sent_id = value.id; form.proposal_status_on_email_sent = value }"
                                 column="name"
                                 name="name"
                                 resource="proposal_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_proposal_template_id" :label="$t('default_proposal_template_id')"
                              col="4">
                    <x-tag-input :params="{type_id: '1'}" :value="form.default_proposal_template"
                                 @input="value => { form.default_proposal_template_id = value.id; form.default_proposal_template = value }"
                                 column="name"
                                 name="name"
                                 resource="templates">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.close_proposal_after_days" :label="$t('close_proposal_after_days')"
                              col="4"
                              type="number"
                              v-model="form.close_proposal_after_days"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.proposal_email_subject" :label="$t('proposal_email_subject')"
                              col="12"
                              v-model="form.proposal_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.proposal_email_template" :label="$t('proposal_email_template')" col="24">
                    <vue-trix v-model="form.proposal_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <settings-custom-field title="proposals"></settings-custom-field>
        <mini-status-crud title="proposal_statuses"
                          url="settings/proposal_statuses">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="6" type="th">{{$t('name')}}</x-td>
                <x-td size="2" type="th">{{$t('color')}}</x-td>
                <x-td size="1" type="th">{{$t('locked')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>
			    	<span :class="`badge bg-${item.color}`">
			    		{{item.color}}
			    	</span>
                </x-td>
                <x-td>{{item.locked ? $t('yes') : $t('no')}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" icon="trash" size="sm" class="float-right"></x-button>
                        <x-button @click="edit(item)" icon="pencil" size="sm" class="float-right mr-1"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-status-crud>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
        <email-variables-modal :items="options.email_variables" @cancel="toggleVarModal"
                               v-if="showVarModal"></email-variables-modal>
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'

    import MiniCrud from '@js/partials/MiniCrud.vue'
    import MiniStatusCrud from '@js/partials/MiniStatusCrud.vue'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'
    import EmailVariablesModal from '@js/partials/EmailVariablesModal.vue'

    export default {
        mixins: [settings],
        components: {MiniCrud, MiniStatusCrud, SettingsCustomField, EmailVariablesModal},
        data() {
            return {
                redirect: 'settings/proposals',
                form: {
                    fields: []
                },
                options: {},
                showFieldModal: false,
                showVarModal: false
            }
        },
        methods: {
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.$set(this.$data, 'options', res.data.options);
                this.$bar.finish();
                this.show = true
            },
            handleUpdateField(i, fields, e) {
                const f = e.target.value;
                this.$set(this.form.fields, i, f)
            },
            handleRemoveField(index, fields) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }
                fields.splice(index, 1)
            },
            handleAddField(e) {
                const f = e.target.value;
                this.form.fields.push(f);
                this.toggleFieldModal();
            },
            toggleFieldModal() {
                this.showFieldModal = !this.showFieldModal
            },
            toggleVarModal() {
                this.showVarModal = !this.showVarModal
            }
        }
    }
</script>
