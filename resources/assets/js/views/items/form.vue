<template>
    <x-form :saving="isSaving" @cancel="cancel" @save="save" class="w-50 mx-auto" padding v-if="show">
        <div slot="title">{{$t(mode)}} {{$t('item')}}</div>
        <x-row line>
            <x-form-group :label="$t('code')" col="4" disabled v-model="form.code"></x-form-group>
            <x-form-group :errors="errors.category_id" :label="$t('category')" col="8">
                <x-tag-input :value="form.category" @input="value => { form.category_id = value.id; form.category = value }" column="name" name="name"
                             resource="item_categories">
                </x-tag-input>
            </x-form-group>
        </x-row>
        <x-row line>
            <x-form-group :errors="errors.description" :label="$t('description')" col="12"
                          v-model="form.description"></x-form-group>
        </x-row>
        <x-row line>
            <x-form-group :errors="errors.uom_id" :label="$t('uom')" col="8">
                <x-tag-input :value="form.uom" @input="value => { form.uom_id = value.id; form.uom = value }" column="name" name="name"
                             resource="uoms">
                </x-tag-input>
            </x-form-group>
            <x-form-group :errors="errors.unit_price" :label="$t('unit_price')" col="4"
                          v-model="form.unit_price"></x-form-group>
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
                redirect: 'items'
            }
        }
    }
</script>
