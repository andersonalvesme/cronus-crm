<template>
    <x-form :saving="isSaving" @cancel="cancel" @save="save" padding v-if="show">
        <div slot="title">{{$t(mode)}} {{$t('task')}}</div>
        <x-row line>
            <x-form-group :label="$t('number')" col="2" disabled v-model="form.number"></x-form-group>
            <x-form-group :errors="errors.subject" :label="$t('subject')" col="4" v-model="form.subject"></x-form-group>
            <x-form-group :errors="errors.type_id" :label="$t('type')" col="3">
                <x-tag-input :value="form.type"
                             @input="value => { form.type_id = value.id; form.type = value }" column="name" name="name"
                             resource="task_types">
                </x-tag-input>
            </x-form-group>
            <x-form-group :errors="errors.due_date" :label="$t('due_date')" col="3" type="date"
                          v-model="form.due_date"></x-form-group>
        </x-row>
        <x-row line>
            <x-form-group :errors="errors.description" :label="$t('description')" col="12" optional
                          source="textarea" v-model="form.description"></x-form-group>
        </x-row>
    </x-form>
</template>
<script>
    import {formable} from '@js/lib/mixins'

    export default {
        mixins: [formable],
        data() {
            return {
                redirect: 'tasks'
            }
        }
    }
</script>
