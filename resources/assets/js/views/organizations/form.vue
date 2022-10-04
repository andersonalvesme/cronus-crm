<template>
    <x-form :saving="isSaving" @cancel="cancel" @save="save" padding v-if="show">
        <div slot="title">{{$t(mode)}} {{$t('organization')}}</div>
        <x-row line>
            <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
            <x-form-group :errors="errors.organization_category_id" :label="$t('category')" col="4">
                <x-tag-input :value="form.category" @input="value => { form.organization_category_id = value.id; form.category = value }" column="name" name="name"
                             resource="organization_categories">
                </x-tag-input>
            </x-form-group>
            <x-form-group :errors="errors.name" :label="$t('name')" col="6" v-model="form.name"></x-form-group>
        </x-row>
        <x-row line>
            <x-form-group :errors="errors.email" :label="$t('email')" col="6" optional
                          v-model="form.email"></x-form-group>
            <x-form-group :errors="errors.website" :label="$t('website')" col="2" optional
                          v-model="form.website"></x-form-group>
            <x-form-group :errors="errors.phone" :label="$t('phone')" col="2" optional
                          v-model="form.phone"></x-form-group>
            <x-form-group :errors="errors.fax" :label="$t('fax')" col="2" optional v-model="form.fax"></x-form-group>
        </x-row>
        <x-row line>
            <x-form-group :errors="errors.primary_address" :label="$t('primary_address')" col="6" source="textarea"
                          v-model="form.primary_address"></x-form-group>
            <x-form-group :errors="errors.other_address" :label="$t('other_address')" col="6" optional
                          source="textarea" v-model="form.other_address"></x-form-group>
        </x-row>
        <div class="fields row-line" v-if="form && form.custom_fields.length > 0">
            <div :class="[`field field-${field.width}`]" v-for="(field, fIndex) in form.custom_fields">
                <field-item :editable="false" :field="field" page="contacts"></field-item>
            </div>
        </div>
    </x-form>
</template>
<script>
    import {formable} from '@js/lib/mixins'
    import FieldItem from '@js/partials/CustomFieldItem.vue'

    export default {
        mixins: [formable],
        components: {FieldItem},
        data() {
            return {
                redirect: 'organizations'
            }
        }
    }
</script>
