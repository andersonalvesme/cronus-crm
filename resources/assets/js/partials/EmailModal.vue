<template>
    <x-modal :loading="isProcessing" @cancel="$emit('cancel')" width="820">
        <div slot="title">
            <div>
                <span>{{$t('sent_email', {type: $t(type)})}}</span>
            </div>
        </div>
        <div>
            <div class="form-alert alert alert--error" v-if="warning">
                {{warning}}
            </div>
            <x-row>
                <x-form-group :errors="errors.email_to" :label="$t('email_to')" col="12"
                              v-model="form.email_to"></x-form-group>
                <x-form-group :errors="errors.bcc" :label="$t('bcc')" col="12" v-model="form.bcc"></x-form-group>
            </x-row>
            <x-form-group :errors="errors.subject" :label="$t('subject')" v-model="form.subject"></x-form-group>
            <x-form-group :errors="errors.message" :label="$t('message')" v-if="show">
                <vue-trix v-model="form.message"></vue-trix>
            </x-form-group>
        </div>
        <template slot="footer">
            <x-button :disabled="isProcessing" @click="$emit('cancel')" class="mr-auto w-xs">{{$t('cancel')}}
            </x-button>
            <x-button :disabled="isProcessing" @click="save" class="w-xs" type="primary">
                {{$t('sent')}}
            </x-button>

        </template>
    </x-modal>
</template>
<script>
    export default {
        props: {
            type: String,
            id: Number
        },
        data() {
            return {
                warning: null,
                isProcessing: false,
                show: false,
                form: {},
                errors: {}
            }
        },
        mounted() {
            this.isProcessing = true;
            this.$http.get(`/api/emails?type=${this.type}&id=${this.id}`)
                .then(res => {
                    this.receiveData(res)
                })
        },
        methods: {
            receiveData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.warning = res.data.warning;
                this.show = true;
                this.isProcessing = false
            },
            save(fd) {
                this.isProcessing = true;
                this.$http.post(`/api/emails?type=${this.type}&id=${this.id}`, this.form)
                    .then((res) => {
                        if (res.data.saved) {
                            this.$message.success(this.$t('email_sent'));
                            this.$emit('ok')
                        }
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
                    })
                    .finally(() => {
                        this.isProcessing = false
                    })
            },
        }
    }
</script>
