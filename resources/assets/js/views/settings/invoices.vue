<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('invoices')})}}</div>
            <div class="float-right" slot="extra">
                <x-button @click="toggleVarModal">{{$t('variables')}}</x-button>
            </div>
            <x-row line>
                <x-form-group :errors="errors.invoice_status_on_create_id" :label="$t('invoice_status_on_create_id')"
                              col="4">
                    <x-tag-input :value="form.invoice_status_on_create"
                                 @input="value => { form.invoice_status_on_create_id = value.id; form.invoice_status_on_create = value }"
                                 column="name"
                                 name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.invoice_status_on_email_sent_id"
                              :label="$t('invoice_status_on_email_sent_id')"
                              col="4">
                    <x-tag-input :value="form.invoice_status_on_email_sent"
                                 @input="value => { form.invoice_status_on_email_sent_id = value.id; form.invoice_status_on_email_sent = value }"
                                 column="name"
                                 name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.invoice_status_on_payment_request_id"
                              :label="$t('invoice_status_on_payment_request_id')"
                              col="4">
                    <x-tag-input :value="form.invoice_status_on_payment_request"
                                 @input="value => { form.invoice_status_on_payment_request_id = value.id; form.invoice_status_on_payment_request = value }"
                                 column="name" name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.invoice_status_on_partial_payment_id"
                              :label="$t('invoice_status_on_partial_payment_id')"
                              col="4">
                    <x-tag-input :value="form.invoice_status_on_partial_payment"
                                 @input="value => { form.invoice_status_on_partial_payment_id = value.id; form.invoice_status_on_partial_payment = value }"
                                 column="name" name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.invoice_status_on_complete_payment_id"
                              :label="$t('invoice_status_on_complete_payment_id')"
                              col="4">
                    <x-tag-input :value="form.invoice_status_on_complete_payment"
                                 @input="value => { form.invoice_status_on_complete_payment_id = value.id; form.invoice_status_on_complete_payment = value }"
                                 column="name" name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_invoice_template_id" :label="$t('default_invoice_template_id')"
                              col="4">
                    <x-tag-input :params="{type_id: '3'}" :value="form.default_invoice_template"
                                 @input="value => { form.default_invoice_template_id = value.id; form.default_invoice_template = value }"
                                 column="name"
                                 name="name"
                                 resource="templates">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row>
                <x-form-group :errors="errors.due_date_after_days" :label="$t('due_date_after_days')" col="4"
                              type="number" v-model="form.due_date_after_days"></x-form-group>
                <x-form-group :errors="errors.receive_payment_on_status_ids"
                              :label="$t('receive_payment_on_status_ids')"
                              col="4">
                    <x-tag-input :value="form.receive_payment_on_status_ids"
                                 @input="value => { form.receive_payment_on_status_ids = value; }" column="name"
                                 multiple name="name"
                                 resource="invoice_statuses">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.invoice_email_subject" :label="$t('invoice_email_subject')"
                              col="12"
                              v-model="form.invoice_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.invoice_email_template" :label="$t('invoice_email_template')" col="12">
                    <vue-trix v-model="form.invoice_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="float-right w-xs">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <settings-custom-field title="invoices"></settings-custom-field>
        <mini-status-crud title="invoice_statuses"
                          url="settings/invoice_statuses">
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
                redirect: 'settings/invoices',
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
