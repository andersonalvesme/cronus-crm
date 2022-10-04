<template>
    <div class="container-xl w-50" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('personal_settings')}}</div>
            <x-form-group :errors="errors.name" :label="$t('name')" v-model="form.name"></x-form-group>
            <x-switch :label="$t('change_password')" @change="onPassword"
                      v-model="change_password" class="mb-2"/>
            <x-form-group :errors="errors.old_password" :label="$t('old_password')" optional type="password"
                          v-if="change_password" v-model="form.old_password"></x-form-group>
            <x-form-group :errors="errors.new_password" :label="$t('new_password')" optional type="password"
                          v-if="change_password" v-model="form.new_password"></x-form-group>
            <x-form-group :errors="errors.new_password_confirmation" :label="$t('new_password_confirmation')" optional
                          type="password" v-if="change_password"
                          v-model="form.new_password_confirmation"></x-form-group>

            <div class="text-right" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary">{{$t('save')}}</x-button>
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
                redirect: 'personal_settings',
                change_password: 0,
                form: {},
            }
        },
        methods: {
            onPassword(e) {
                if (this.change_password) {
                    this.$set(this.form, 'old_password', null);
                    this.$set(this.form, 'new_password', null);
                    this.$set(this.form, 'new_password_confirmation', null)
                } else {
                    this.$delete(this.form, 'old_password');
                    this.$delete(this.form, 'new_password');
                    this.$delete(this.form, 'new_password_confirmation')
                }
            },
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
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
                        this.$set(window.app.user, 'name', this.form.name);
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
