<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                {{$t(mode)}} {{$t('invoice')}}
            </div>
            <x-row line>
                <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
                <x-form-group :errors="errors.contact_id" :label="$t('contact')" col="4">
                    <x-typeahead-table :columns="['number', 'name']" :value="form.contact" @input="value => { form.contact_id = value.id; form.contact = value }"
                                       name="name"
                                       url="contacts">
                    </x-typeahead-table>
                </x-form-group>
                <x-form-group :errors="errors.template_id" :label="$t('template')" col="6">
                    <x-tag-input :params="{type_id: '3'}" :value="form.template"
                                 @input="onTemplateChange" column="name" name="name"
                                 resource="templates">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.proposal_id" :label="$t('proposal')" col="6" optional>
                    <x-tag-input :params="{contact_id: form.contact_id}" :value="form.proposal" @input="value => { form.proposal_id = value.id; form.proposal = value }"
                                 column="number" name="number" removable
                                 resource="proposals">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.contract_id" :label="$t('contract')" col="6" optional>
                    <x-tag-input :params="{contact_id: form.contact_id}" :value="form.contract" @input="value => { form.contract_id = value.id; form.contract = value }"
                                 column="number" name="number" removable
                                 resource="contracts">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :label="$t('reference')" col="6" optional v-model="form.reference"></x-form-group>
                <x-form-group :errors="errors.issue_date" :label="$t('issue_date')" col="3" type="date"
                              v-model="form.issue_date"></x-form-group>
                <x-form-group :errors="errors.due_date" :label="$t('due_date')" col="3" type="date"
                              v-model="form.due_date"></x-form-group>
            </x-row>
            <div class="fields row-line" v-if="form && form.custom_fields_2.length > 0">
                <div :class="[`field field-${field.width}`]" v-for="(field, fIndex) in form.custom_fields_2">
                    <custom-field-item :editable="false" :field="field" page="contacts"></custom-field-item>
                </div>
            </div>
            <template v-for="page in form.custom_fields">
                <x-row line v-if="showSection(page)">
                    <x-col span="24">
                        <x-row>
                            <x-col span="12">
                                <div class="template-instruction">
                                    <h3>{{page.title}}</h3>
                                    <small>{{page.instruction}}</small>
                                </div>
                            </x-col>
                        </x-row>
                        <div v-for="(section, index) in page.user_fields">
                            <div class="fields" v-if="section && section.fields.length > 0">
                                <div :class="[`field field-${field.width}`]" v-for="(field, fIndex) in section.fields">
                                    <field-item :editable="false" :field="field" page="customer"></field-item>
                                </div>
                            </div>
                        </div>
                    </x-col>
                </x-row>
            </template>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :disabled="isSaving" @click="cancel" class="w-xs">{{$t('cancel')}}</x-button>
                    <x-button :loading="isSaving" @click="save" type="primary" class="w-xs float-right">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {formable} from '@js/lib/mixins'
    import FieldItem from '@js/partials/FieldItem.vue'
    import CustomFieldItem from '@js/partials/CustomFieldItem.vue'
    import XRow from "../../components/grid/Row";

    export default {
        mixins: [formable],
        components: {XRow, FieldItem, CustomFieldItem},
        data() {
            return {
                redirect: 'invoices',
                form: {
                    custom_fields: [],
                    custom_fields_2: [],
                    contact: {},
                    opportunity: {},
                    template: {}
                }
            }
        },
        computed: {
            showSection() {
                return (page) => {
                    let count = 0;
                    page.user_fields.forEach((section) => {
                        if (section.fields.length) {
                            count++
                        }
                    });
                    return count > 0
                }
            }
        },
        methods: {
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
