<template>
    <x-form :saving="isSaving" @cancel="cancel" @save="save" padding v-if="show">
        <div slot="title">{{$t(mode)}} {{$t('invite')}}</div>
        <x-row line>
            <x-form-group :errors="errors.name" :label="$t('name')" col="4" v-model="form.name"></x-form-group>
            <x-form-group :errors="errors.email" :label="$t('email')" col="4" v-model="form.email"></x-form-group>
            <x-form-group :errors="errors.role_id" :label="$t('role')" col="4">
                <x-tag-input :value="form.role" @input="value => { form.role_id = value.id; form.role = value }" column="name" name="name"
                             resource="roles">
                </x-tag-input>
            </x-form-group>
        </x-row>
    </x-form>
</template>
<script>
    import {formable} from '@js/lib/mixins'

    export default {
        mixins: [formable],
        data() {
            return {
                redirect: 'settings/invitations',
                form: {
                    password: null
                }
            }
        }
    }
</script>
