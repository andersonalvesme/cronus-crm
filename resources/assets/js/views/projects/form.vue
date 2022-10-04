<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">
                {{$t(mode)}} {{$t('project')}}
            </div>
            <x-row line>
                <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
                <x-form-group :errors="errors.contact_id" :label="$t('contact')" col="4">
                    <x-typeahead-table :columns="['number', 'name']" :value="form.contact"
                                       @input="value => { form.contact_id = value.id; form.contact = value }"
                                       name="name"
                                       url="contacts">
                    </x-typeahead-table>
                </x-form-group>
                <x-form-group :errors="errors.category_id" :label="$t('category')" col="6">
                    <x-tag-input :value="form.category"
                                 @input="value => { form.category_id = value.id; form.category = value }" column="name"
                                 name="name"
                                 resource="project_categories">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.title" :label="$t('title')" col="6" v-model="form.title"></x-form-group>
                <x-form-group :errors="errors.proposal_id" :label="$t('proposal')" col="6" optional>
                    <x-tag-input :params="{contact_id: form.contact_id}" :value="form.proposal"
                                 @input="value => { form.proposal_id = value.id; form.proposal = value }"
                                 column="number" name="number"
                                 resource="proposals">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.description" :label="$t('description')" col="12" source="textarea"
                              v-model="form.description"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.start_date" :label="$t('start_date')" col="3" type="date"
                              v-model="form.start_date"></x-form-group>
                <x-form-group :errors="errors.estimated_finish_date" :label="$t('estimated_finish_date')" col="3"
                              type="date"
                              v-model="form.estimated_finish_date"></x-form-group>
                <x-form-group :errors="errors.deadline_date" :label="$t('deadline_date')" col="3" optional
                              type="date" v-model="form.deadline_date"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.actual_start_date" :label="$t('actual_start_date')" col="3" optional
                              type="date" v-model="form.actual_start_date"></x-form-group>
                <x-form-group :errors="errors.actual_end_date" :label="$t('actual_end_date')" col="3" optional
                              type="date" v-model="form.actual_end_date"></x-form-group>
                <x-form-group :errors="errors.estimated_cost" :label="$t('estimated_cost')" col="3" type="number"
                              v-model="form.estimated_cost"></x-form-group>
            </x-row>
            <div class="fields row-line" v-if="form && form.custom_fields.length > 0">
                <div :class="[`field field-${field.width}`]" v-for="(field, fIndex) in form.custom_fields">
                    <field-item :editable="false" :field="field" page="contacts"></field-item>
                </div>
            </div>
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
    import FieldItem from '@js/partials/CustomFieldItem.vue'

    export default {
        mixins: [formable],
        components: {FieldItem},
        data() {
            return {
                redirect: 'projects',
                form: {
                    custom_fields: [],
                    contact: {},
                    opportunity: {},
                    template: {}
                }
            }
        }
    }
</script>
