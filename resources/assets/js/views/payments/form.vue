<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                {{$t(mode)}} {{$t('payment')}}
            </div>
            <x-row line>
                <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
                <x-form-group :errors="errors.contact_id" :label="$t('contact')" col="4">
                    <x-typeahead-table :columns="['number', 'name']" :params="{invoices: 1}" :value="form.contact"
                                       @input="onContactSelect" name="name"
                                       url="contacts">
                    </x-typeahead-table>
                </x-form-group>
                <x-form-group :errors="errors.payment_date" :label="$t('payment_date')" col="3" type="date"
                              v-model="form.payment_date"></x-form-group>
                <x-form-group :errors="errors.method_id" :label="$t('payment_method')" col="3">
                    <x-tag-input :value="form.method" @input="value => { form.method_id = value.id; form.method = value }" column="name"
                                 name="name"
                                 resource="payment_methods">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :label="$t('reference')" col="2" v-model="form.reference"></x-form-group>
                <x-form-group :errors="errors.deposit_id" :label="$t('deposit_to')" col="4">
                    <x-tag-input :value="form.deposit"
                                 @input="value => { form.deposit_id = value.id; form.deposit = value }" column="name" name="name"
                                 resource="payment_deposits">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <div class="fields row-line" v-if="form && form.custom_fields.length > 0">
                <div :class="[`field field-${field.width}`]" v-for="(field, fIndex) in form.custom_fields">
                    <field-item :editable="false" :field="field" page="contacts"></field-item>
                </div>
            </div>
            <x-row line>
                <x-form-group :label="$t('note')" col="12" optional source="textarea" v-model="form.note"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :label="$t('amount_received')" col="3" type="number"
                              v-model="form.amount_received"></x-form-group>
                <x-form-group :label="$t('bank_fees')" col="3" type="number" v-model="form.bank_fees"></x-form-group>

            </x-row>
        </x-panel>
        <x-panel margin>
            <div slot="title">{{$t('applied_invoices')}}</div>
            <x-table class="table-form">
                <x-thead>
                    <x-tr>
                        <x-td size="4" type="th">{{$t('invoice')}}</x-td>
                        <x-td size="4" type="th">{{$t('issue_date')}}</x-td>
                        <x-td size="4" type="th">{{$t('due_date')}}</x-td>
                        <x-td size="4" type="th">{{$t('grand_total')}}</x-td>
                        <x-td size="4" type="th">{{$t('balance')}}</x-td>
                        <x-td size="4" type="th">{{$t('amount_applied')}}</x-td>
                    </x-tr>
                </x-thead>
                <x-tbody v-if="form.lines.length > 0">
                    <x-tr :key="item.id" v-for="item in form.lines">
                        <x-td>
                            <span class="form-control">{{item.number}}</span>
                        </x-td>
                        <x-td>
                            <span class="form-control">{{item.issue_date | toDate}}</span>
                        </x-td>
                        <x-td>
                            <span class="form-control" v-if="item.due_date">{{item.due_date | toDate}}</span>
                            <span class="form-control" v-else>-</span>
                        </x-td>
                        <x-td>
                            <span class="form-control">{{item.grand_total | formatMoney}}</span>
                        </x-td>
                        <x-td>
                            <span class="form-control">{{item.balance | formatMoney}}</span>
                        </x-td>
                        <x-td>
                            <input class="form-control" type="number" v-model="item.amount_applied">
                        </x-td>
                    </x-tr>
                </x-tbody>

            </x-table>
            <x-row>
                <x-col offset="16" span="8">
                    <x-table class="table-form">
                        <x-tfoot>
                            <x-tr>
                                <x-td class="table-foot" size="12">{{$t('amount_received')}}</x-td>
                                <x-td align="right" class="table-foot" size="12">{{form.amount_received |
                                    formatMoney}}
                                </x-td>
                            </x-tr>
                            <x-tr>
                                <x-td class="table-foot" size="12">{{$t('amount_applied')}}</x-td>
                                <x-td align="right" class="table-foot" size="12">{{amountApplied | formatMoney}}</x-td>
                            </x-tr>
                        </x-tfoot>
                    </x-table>
                </x-col>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div v-if="showBtn">
                    <x-button :disabled="isSaving" @click="cancel">{{$t('cancel')}}</x-button>
                    <x-button :loading="isSaving" @click="save" type="primary">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {formable} from '@js/lib/mixins'
    import FieldItem from '@js/partials/CustomFieldItem.vue'

    export default {
        mixins: [formable],
        components: {FieldItem},
        data() {
            return {
                redirect: 'payments',
                form: {
                    lines: [],
                    custom_fields: [],
                    contact: {},
                    opportunity: {},
                    template: {}
                }
            }
        },
        computed: {
            amountApplied() {
                if (this.form.lines) {
                    return this.form.lines.reduce((carry, item) => {
                        return carry + Number(item.amount_applied)
                    }, 0)
                }
                return 0
            },
            showBtn() {
                return this.amountApplied === Number(this.form.amount_received) && (this.form.amount_received > 0 && this.amountApplied > 0)
            }
        },
        methods: {
            onContactSelect(value) {
                this.form.contact_id = value.id;
                this.form.contact = value;
                this.$set(this.form, 'lines', value.invoices)
            },
            onTemplateChange(value) {
                this.form.template_id = value.id;
                this.$set(this.form, 'custom_fields', value.custom_fields);
                this.form.template = {
                    id: value.id,
                    name: value.name
                }
            }
        }
    }
</script>
