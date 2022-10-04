<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('web_payment')})}}</div>
            <x-row line>
                <x-form-group :errors="errors.active_payment_gateway" :label="$t('active_payment_gateway')" col="4">
                    <select class="form-select" v-model="form.active_payment_gateway">
                        <option value="stripe">{{$t('stripe')}}</option>
                        <option value="paypal">{{$t('paypal')}}</option>
                        <option value="razorpay">{{$t('razorpay')}}</option>
                    </select>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_notification_email" :label="$t('payment_notification_email')"
                              col="12" optional
                              v-model="form.payment_notification_email">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.web_payment_notification_email_subject"
                              :label="$t('web_payment_notification_email_subject')"
                              col="12"
                              v-model="form.web_payment_notification_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.web_payment_notification_email_template"
                              :label="$t('web_payment_notification_email_template')"
                              col="12">
                    <vue-trix v-model="form.web_payment_notification_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.web_payment_email_subject" :label="$t('web_payment_email_subject')"
                              col="12"
                              v-model="form.web_payment_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_success_email" :label="$t('payment_success_email')"
                              col="12">
                    <vue-trix v-model="form.payment_success_email"></vue-trix>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_request_email_subject"
                              :label="$t('payment_request_email_subject')"
                              col="12"
                              v-model="form.payment_request_email_subject">
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.payment_request_email_template"
                              :label="$t('payment_request_email_template')"
                              col="12">
                    <vue-trix v-model="form.payment_request_email_template"></vue-trix>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('stripe')})}}</div>
            <div class="float-right" slot="extra">
                <x-switch v-model="form.enable_stripe"></x-switch>
            </div>
            <div v-if="form.enable_stripe">
                <x-row line>
                    <x-form-group :errors="errors.stripe_publishable_key" :label="$t('stripe_publishable_key')"
                                  col="4"
                                  v-model="form.stripe_publishable_key">
                    </x-form-group>
                    <x-form-group :errors="errors.stripe_secret_key" :label="$t('stripe_secret_key')"
                                  col="4"
                                  v-model="form.stripe_secret_key">
                    </x-form-group>
                    <x-form-group :errors="errors.stripe_title" :label="$t('stripe_title')"
                                  col="4"
                                  v-model="form.stripe_title">
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.stripe_description" :label="$t('stripe_description')"
                                  col="4"
                                  v-model="form.stripe_description">
                    </x-form-group>
                    <x-form-group :errors="errors.stripe_logo_url" :label="$t('stripe_logo_url')"
                                  col="4"
                                  v-model="form.stripe_logo_url">
                    </x-form-group>
                    <x-form-group :errors="errors.stripe_payment_method_id" :label="$t('stripe_payment_method_id')"
                                  col="4">
                        <x-tag-input :value="form.stripe_payment_method"
                                     @input="value => { form.stripe_payment_method_id = value.id; form.stripe_payment_method = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_methods">
                        </x-tag-input>
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.stripe_payment_deposit_id" :label="$t('stripe_payment_deposit_id')"
                                  col="4">
                        <x-tag-input :value="form.stripe_payment_deposit"
                                     @input="value => { form.stripe_payment_deposit_id = value.id; form.stripe_payment_deposit = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_deposits">
                        </x-tag-input>
                    </x-form-group>
                </x-row>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('razorpay')})}}</div>
            <div class="float-right" slot="extra">
                <x-switch v-model="form.enable_razorpay"></x-switch>
            </div>
            <div v-if="form.enable_razorpay">
                <x-row line>
                    <x-form-group :errors="errors.razorpay_api_key" :label="$t('razorpay_api_key')"
                                  col="4"
                                  v-model="form.razorpay_api_key">
                    </x-form-group>
                    <x-form-group :errors="errors.razorpay_secret_key" :label="$t('razorpay_secret_key')"
                                  col="4"
                                  v-model="form.razorpay_secret_key">
                    </x-form-group>
                    <x-form-group :errors="errors.razorpay_title" :label="$t('razorpay_title')"
                                  col="4"
                                  v-model="form.razorpay_title">
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.razorpay_description" :label="$t('razorpay_description')"
                                  col="4"
                                  v-model="form.razorpay_description">
                    </x-form-group>
                    <x-form-group :errors="errors.razorpay_logo_url" :label="$t('razorpay_logo_url')"
                                  col="4"
                                  v-model="form.razorpay_logo_url">
                    </x-form-group>
                    <x-form-group :errors="errors.razorpay_payment_method_id" :label="$t('razorpay_payment_method_id')"
                                  col="4">
                        <x-tag-input :value="form.razorpay_payment_method"
                                     @input="value => { form.razorpay_payment_method_id = value.id; form.razorpay_payment_method = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_methods">
                        </x-tag-input>
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.razorpay_payment_deposit_id"
                                  :label="$t('razorpay_payment_deposit_id')"
                                  col="4">
                        <x-tag-input :value="form.razorpay_payment_deposit"
                                     @input="value => { form.razorpay_payment_deposit_id = value.id; form.razorpay_payment_deposit = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_deposits">
                        </x-tag-input>
                    </x-form-group>
                </x-row>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('paypal')})}}</div>
            <div class="float-right" slot="extra">
                <x-switch v-model="form.enable_paypal"></x-switch>
            </div>
            <div v-if="form.enable_paypal">
                <x-row line>
                    <x-form-group :errors="errors.paypal_mode" :label="$t('paypal_mode')" col="4">
                        <select class="form-select" v-model="form.paypal_mode">
                            <option value="sandbox">{{$t('sandbox')}}</option>
                            <option value="production">{{$t('production')}}</option>
                        </select>
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_sandbox_client_id" :label="$t('paypal_sandbox_client_id')"
                                  col="4"
                                  v-model="form.paypal_sandbox_client_id">
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_sandbox_secret" :label="$t('paypal_sandbox_secret')"
                                  col="4"
                                  v-model="form.paypal_sandbox_secret">
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.paypal_production_client_id"
                                  :label="$t('paypal_production_client_id')"
                                  col="4"
                                  v-model="form.paypal_production_client_id">
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_production_secret" :label="$t('paypal_production_secret')"
                                  col="4"
                                  v-model="form.paypal_production_secret">
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_locale" :label="$t('paypal_locale')"
                                  col="4"
                                  v-model="form.paypal_locale">
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.paypal_size" :label="$t('paypal_size')"
                                  col="4"
                                  v-model="form.paypal_size">
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_color" :label="$t('paypal_color')"
                                  col="4"
                                  v-model="form.paypal_color">
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_shape" :label="$t('paypal_shape')"
                                  col="4"
                                  v-model="form.paypal_shape">
                    </x-form-group>
                </x-row>
                <x-row line>
                    <x-form-group :errors="errors.paypal_payment_method_id" :label="$t('paypal_payment_method_id')"
                                  col="4">
                        <x-tag-input :value="form.paypal_payment_method"
                                     @input="value => { form.paypal_payment_method_id = value.id; form.paypal_payment_method = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_methods">
                        </x-tag-input>
                    </x-form-group>
                    <x-form-group :errors="errors.paypal_payment_deposit_id" :label="$t('paypal_payment_deposit_id')"
                                  col="4">
                        <x-tag-input :value="form.paypal_payment_deposit"
                                     @input="value => { form.paypal_payment_deposit_id = value.id; form.paypal_payment_deposit = value }"
                                     column="name"
                                     name="name"
                                     resource="payment_deposits">
                        </x-tag-input>
                    </x-form-group>
                </x-row>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
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
                redirect: 'settings/web_payment',
                form: {},
            }
        }
    }
</script>
