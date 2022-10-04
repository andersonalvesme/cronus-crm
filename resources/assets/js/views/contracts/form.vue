<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                {{$t(mode)}} {{$t('contract')}}
            </div>
            <x-row line>
                <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
                <x-form-group :errors="errors.contact_id" :label="$t('contact')" col="4" optional>
                    <x-typeahead-table :columns="['number', 'name']" :value="form.contact" @input="value => { form.contact_id = value.id; form.contact = value }"
                                       name="name"
                                       url="contacts">
                    </x-typeahead-table>
                </x-form-group>
                <x-form-group :errors="errors.template_id" :label="$t('template')" col="6">
                    <x-tag-input :params="{type_id: '2'}" :value="form.template"
                                 @input="onTemplateChange" column="name" name="name"
                                 resource="templates">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.title" :label="$t('title')" col="6" v-model="form.title"></x-form-group>
                <x-form-group :errors="errors.value" :label="$t('value')" col="3" v-model="form.value"></x-form-group>
                <x-form-group :errors="errors.type_id" :label="$t('type')" col="3">
                    <x-tag-input :value="form.type"
                                 @input="value => { form.type_id = value.id; form.type = value }" column="name" name="name"
                                 resource="contract_types">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.proposal_id" :label="$t('proposal')" col="6" optional>
                    <x-tag-input :params="{contact_id: form.contact_id}" :value="form.proposal"
                                 @input="value => { form.proposal_id = value.id; form.proposal = value }" column="number" name="number"
                                 resource="proposals">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.start_date" :label="$t('start_date')" col="3" type="date"
                              v-model="form.start_date"></x-form-group>
                <x-form-group :errors="errors.expiry_date" :label="$t('expiry_date')" col="3" type="date"
                              v-model="form.expiry_date"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.auto_renewal" :label="$t('auto_renewal')" :value="form.auto_renewal"
                              @input="value => { form.auto_renewal = Number(value); form.expiry_date = '' }"
                              col="3" source="switch"></x-form-group>
                <x-form-group :errors="errors.no_of_months" :label="$t('no_of_months')" col="3" type="number"
                              v-if="form.auto_renewal" v-model="form.no_of_months"></x-form-group>
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
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">{{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {formable} from '@js/lib/mixins'
    import FieldItem from '@js/partials/FieldItem.vue'
    import CustomFieldItem from '@js/partials/CustomFieldItem.vue'

    export default {
        mixins: [formable],
        components: {FieldItem, CustomFieldItem},
        data() {
            return {
                redirect: 'contracts',
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
