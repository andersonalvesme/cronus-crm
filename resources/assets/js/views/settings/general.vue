<template>
    <div v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('settings_system')}}</div>
            <x-row line>
                <x-form-group :col="3" :errors="errors.application_date_format" :label="$t('application_date_format')">
                    <select class="form-select" v-model="form.application_date_format">
                        <option>d-m-Y</option>
                        <option>Y-m-d</option>
                        <option>d-M-Y</option>
                        <option>Y-M-d</option>
                        <option>d/m/Y</option>
                        <option>Y/m/d</option>
                    </select>
                </x-form-group>
                <x-form-group :col="3" :errors="errors.application_timezone" :label="$t('application_timezone')">
                    <select class="form-select" v-model="form.application_timezone">
                        <option :value="key"
                                v-for="(value, key) in options.timezones">
                            {{value}}
                        </option>
                    </select>
                </x-form-group>
            </x-row>
            <x-row class="mt-3" line>
                <x-col span="12">
                    <h3>{{$t('currency')}}</h3>
                </x-col>
                <x-form-group :errors="errors.currency_code" :label="$t('currency_code')"
                              v-model="form.currency_code" :col="3"></x-form-group>
                <x-form-group :errors="errors.currency_precision" :label="$t('currency_precision')"
                              v-model="form.currency_precision" :col="3"></x-form-group>
                <x-form-group :errors="errors.decimal_separator" :label="$t('decimal_separator')"
                              v-model="form.decimal_separator" :col="3"></x-form-group>
                <x-form-group :errors="errors.thousands_separator" :label="$t('thousands_separator')"
                              v-model="form.thousands_separator" :col="3"></x-form-group>
                <x-form-group :errors="errors.placement" :label="$t('placement')" :col="3">
                    <select class="form-select" v-model="form.placement">
                        <option value="before">{{$t('before')}}</option>
                        <option value="after">{{$t('after')}}</option>
                    </select>
                </x-form-group>
            </x-row>
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
                redirect: 'settings',
                form: {},
                options: {
                    timezones: []
                }
            }
        },
        methods: {
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.$set(this.$data, 'options', res.data.options);
                this.$bar.finish();
                this.show = true
            },
            save() {
                this.isSaving = true;
                this.errors = {};

                const {url, method} = this.getForm();

                this.$http[method](url, this.form)
                    .then((res) => {
                        const id = Math.random().toString(36).substring(7);
                        this.$set(window.app.currency, 'code', this.form.currency_code);
                        this.$set(window.app.currency, 'precision', this.form.currency_precision);
                        this.$set(window.app.currency, 'decimal_separator', this.form.decimal_separator);
                        this.$set(window.app.currency, 'thousands_separator', this.form.thousands_separator);
                        this.$set(window.app.currency, 'placement', this.form.placement);

                        this.$router.push(`/${this.redirect}?id=${id}`);
                        this.$message.success(this.$t('saved_success'))
                    })
                    .catch(this.catch)
                    .finally(() => {
                        this.isSaving = false
                    })
            },
        }
    }
</script>
