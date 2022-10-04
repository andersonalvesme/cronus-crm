<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('payments')})}}</div>
            <div class="float-right" slot="extra">
                <x-button @click="toggleVarModal">{{$t('variables')}}</x-button>
            </div>
            <x-row line>
                <x-form-group :errors="errors.default_payment_method_id" :label="$t('default_payment_method_id')"
                              col="4">
                    <x-tag-input :value="form.default_payment_method"
                                 @input="value => { form.default_payment_method_id = value.id; form.default_payment_method = value }"
                                 column="name"
                                 name="name"
                                 resource="payment_methods">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_payment_deposit_id" :label="$t('default_payment_deposit_id')"
                              col="4">
                    <x-tag-input :value="form.default_payment_deposit"
                                 @input="value => { form.default_payment_deposit_id = value.id; form.default_payment_deposit = value }"
                                 column="name"
                                 name="name"
                                 resource="payment_deposits">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_payment_template_id" :label="$t('default_payment_template_id')"
                              col="4">
                    <x-tag-input :params="{type_id: '4'}" :value="form.default_payment_template"
                                 @input="value => { form.default_payment_template_id = value.id; form.default_payment_template = value }"
                                 column="name"
                                 name="name"
                                 resource="templates">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_email_subject" :label="$t('payment_email_subject')"
                              col="12"
                              v-model="form.payment_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_email_template" :label="$t('payment_email_template')" col="12">
                    <vue-trix v-model="form.payment_email_template"></vue-trix>
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
        <settings-custom-field title="payments"></settings-custom-field>

        <mini-crud title="payment_methods"
                   url="settings/payment_methods">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="9" type="th">{{$t('name')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" icon="trash" size="sm" class="float-right"></x-button>
                        <x-button @click="edit(item)" icon="pencil" size="sm" class="float-right mr-1"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-crud>
        <mini-crud title="payment_deposits"
                   url="settings/payment_deposits">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="9" type="th">{{$t('name')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" icon="trash" size="sm" class="float-right"></x-button>
                        <x-button @click="edit(item)" icon="pencil" size="sm" class="float-right mr-1"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-crud>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
        <email-variables-modal :items="options.email_variables" @cancel="toggleVarModal"
                               v-if="showVarModal"></email-variables-modal>
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'
    import MiniCrud from '@js/partials/MiniCrud.vue'
    import EmailVariablesModal from '@js/partials/EmailVariablesModal.vue'

    export default {
        mixins: [settings],
        components: {MiniCrud, SettingsCustomField, EmailVariablesModal},
        data() {
            return {
                redirect: 'settings/payments',
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
