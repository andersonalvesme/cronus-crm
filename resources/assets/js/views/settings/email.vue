<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('settings_send_mail')}}</div>
            <x-row line>
                <x-form-group :errors="errors.email_from_name" :label="$t('email_from_name')" col="4"
                              v-model="form.email_from_name"></x-form-group>
                <x-form-group :errors="errors.email_from_address" :label="$t('email_from_address')" col="4"
                              v-model="form.email_from_address"></x-form-group>
                <x-form-group :errors="errors.global_bcc" :label="$t('global_bcc')" col="4" optional
                              v-model="form.global_bcc"></x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.recurring_export_email_subject"
                              :label="$t('recurring_export_email_subject')"
                              col="12" v-model="form.recurring_export_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.recurring_export_email_template"
                              :label="$t('recurring_export_email_template')"
                              col="12">
                    <vue-trix v-model="form.recurring_export_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.user_invite_email_subject" :label="$t('user_invite_email_subject')"
                              col="12"
                              v-model="form.user_invite_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.user_invite_email_template" :label="$t('user_invite_email_template')"
                              col="12">
                    <vue-trix v-model="form.user_invite_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="float-right w-xs">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-panel>

        <x-panel margin>
            <div slot="title">{{$t('email_base_html')}}</div>
            <div>
                <x-form-group :errors="errors.email_base_html" :label="$t('email_base_html')">
                    <codemirror :options="{mode: 'text/html'}" v-model="form.email_base_html" class="border"></codemirror>
                </x-form-group>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="float-right w-xs">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-panel>

        <x-panel margin>
            <div slot="title">{{$t('email_stylesheet')}}</div>
            <div>
                <x-form-group :errors="errors.email_stylesheet" :label="$t('email_stylesheet')">
                    <codemirror :options="{mode: 'text/css'}" v-model="form.email_stylesheet" class="border"></codemirror>
                </x-form-group>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="float-right w-xs">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'


    export default {
        mixins: [settings],
        data() {
            return {
                redirect: 'settings/email',
                form: {}
            }
        },
        methods: {}
    }
</script>
