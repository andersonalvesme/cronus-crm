<template>
    <x-modal @cancel="$emit('cancel')">
        <div slot="title">
            <div v-if="field">
                <span>{{$t('edit')}} {{$t('custom_field').toLowerCase()}}</span>
            </div>
            <div v-else>{{$t('add')}} {{$t('custom_field').toLowerCase()}}</div>
        </div>
        <div>
            <x-row>
                <x-col span="12">
                    <x-form-group :label="$t('field_type')">
                        <select :disabled="field" :value="form.type" @change="onSelect" class="form-select">
                            <option :selected="form.type === type" :value="type"
                                    v-for="type in types">{{$t(type)}}
                            </option>
                        </select>
                    </x-form-group>
                </x-col>
                <x-col span="12">
                    <x-form-group :label="$t('field_label')">
                        <x-input :value="form.label" @input="handleTitle"></x-input>
                    </x-form-group>
                </x-col>
                <x-col span="12">
                    <x-form-group :label="$t('field_name')">
                        <x-input disabled v-model="form.name"></x-input>
                    </x-form-group>
                </x-col>
                <x-col span="12">
                    <x-form-group :label="$t('default_value')">
                        <x-input v-if="activeType ==='text'" v-model="form.model"></x-input>
                        <x-input type="number" v-if="activeType ==='number'" v-model="form.model"></x-input>
                        <x-input type="date" v-if="activeType ==='date'" v-model="form.model"></x-input>
                        <x-input type="number" v-if="activeType ==='currency'" v-model="form.model"></x-input>
                        <x-textarea v-if="activeType ==='textarea'" v-model="form.model"></x-textarea>
                        <field-image v-if="activeType === 'image'" v-model="form.model"></field-image>
                        <select class="form-select" v-if="activeType === 'select'" v-model="form.model">
                            <option :value="o" v-for="o in form.options">{{o}}</option>
                        </select>
                    </x-form-group>
                </x-col>
            </x-row>

            <div v-if="activeType === 'currency'">
                <x-row>
                    <x-form-group :label="$t('currency_code')" col="12" v-model="form.currency.code"></x-form-group>
                    <x-form-group :label="$t('precision')" col="12" v-model="form.currency.precision"></x-form-group>
                </x-row>
                <x-row>
                    <x-form-group :label="$t('separator')" col="8" v-model="form.currency.separator"></x-form-group>
                    <x-form-group :label="$t('thousands_separator')" col="8"
                                  v-model="form.currency.thousands"></x-form-group>
                    <x-col span="8">
                        <div class="form-group">
                            <label class="form-label">{{$t('placement')}}</label>
                            <select class="form-select" v-model="form.currency.placement">
                                <option value="before">{{$t('before')}}</option>
                                <option value="after">{{$t('after')}}</option>
                            </select>
                        </div>
                    </x-col>
                </x-row>
            </div>
            <div class="form-group" v-if="activeType === 'select'">
                <label class="form-label">
                    {{$t('options')}}
                </label>
                <div class="form-list" v-for="(m, i) in form.options">
                    <input :placeholder="`${$t('option')} ${i + 1}`" class="form-control" type="text"
                           v-model="form.options[i]">
                    <span @click="form.options.splice(i, 1)" class="form-list-remove">
				  	<i class="icon icon-close"></i>
				  </span>
                </div>
                <x-button @click="form.options.push('')" icon="plus" size="sm"
                          type="success">{{$t('add')}}
                </x-button>
            </div>
            <div class="form-group" v-if="activeType === 'date'">
                <label class="form-label">
                    {{$t('date_format')}}
                </label>
                <select class="form-select" v-model="form.format">
                    <option :value="format" v-for="format in formats">{{format}}</option>
                </select>
            </div>

            <x-form-group :label="$t('width')">
                <div class="btn-group w-100">
                    <x-button :class="{'active': (form.width === 1)}" @click="form.width = 1">
                        1 {{$t('column')}}
                    </x-button>
                    <x-button :class="{'active': (form.width === 3)}" @click="form.width = 6">
                        3 {{$t('columns')}}
                    </x-button>
                    <x-button :class="{'active': (form.width === 6)}" @click="form.width = 6">
                        6 {{$t('columns')}}
                    </x-button>
                    <x-button :class="{'active': (form.width === 9)}" @click="form.width = 9">
                        9 {{$t('columns')}}
                    </x-button>
                    <x-button :class="{'active': (form.width === 12)}" @click="form.width = 12">
                        12 {{$t('columns')}}
                    </x-button>
                </div>
            </x-form-group>
        </div>
        <template slot="footer">
            <div></div>
            <div>
                <x-button @click="$emit('cancel')">{{$t('cancel')}}</x-button>
                <x-button @click="addField" type="primary">
                    {{field ? this.$t('ok') : this.$t('add')}}
                </x-button>
            </div>
        </template>
    </x-modal>
</template>
<script>
    import {snakeCase} from 'lodash'
    import FieldImage from '@js/partials/FieldImage.vue'
    import XRow from "../components/grid/Row";
    import XButton from "../components/button/Button";

    export default {
        components: {XButton, XRow, FieldImage},
        props: {
            field: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                edit: false,
                activeType: 'text',
                activeTab: 'menu',
                types: [
                    'text',
                    'number',
                    'textarea',
                    'select',
                    'image',
                    'date',
                    'currency'
                ],
                formats: [
                    'd-m-Y',
                    'Y-m-d',
                    'd-M-Y',
                    'Y-M-d',
                    'd/m/Y',
                    'Y/m/d'
                ],
                form: {
                    type: 'text',
                    label: this.$t('new_field'),
                    name: snakeCase(this.$t('new_field')),
                    width: 3,
                    model: '',
                    format: this.$s('application.date_format'), // get from settins
                    options: [''],
                    currency: {
                        code: this.$s('currency.code'),
                        precision: this.$s('currency.precision'),
                        separator: this.$s('currency.decimal_separator'),
                        thousands: this.$s('currency.thousands_separator'),
                        placement: this.$s('currency.placement') // get from settings
                    }
                }
            }
        },
        mounted() {
            if (this.field) {
                this.$set(this.$data, 'form', JSON.parse(JSON.stringify(this.field)));

                const found = this.types.find((type) => {
                    return this.field.type == type
                });

                this.selectType(found)
            }
        },
        methods: {
            onSelect(e) {
                this.form.type = e.target.value;
                this.selectType(e.target.value)
            },
            handleTitle(value) {
                this.form.label = value;
                this.form.name = snakeCase(value)
            },
            selectType(type) {
                this.activeType = type
            },
            addField() {
                const payload = this.getPayload();
                this.$emit(this.field ? 'update' : 'add', {
                    target: {
                        value: payload
                    }
                })
            },
            getPayload() {
                let payload = {};
                switch (this.activeType) {
                    case 'text':
                    case 'number':
                    case 'textarea':
                    case 'image':
                        payload = {
                            type: this.activeType,
                            label: this.form.label,
                            name: this.form.name,
                            model: this.form.model,
                            width: this.form.width
                        };
                        break;
                    case 'date':
                        payload = {
                            type: this.activeType,
                            label: this.form.label,
                            name: this.form.name,
                            model: this.form.model,
                            width: this.form.width,
                            format: this.form.format
                        };
                        break;
                    case 'select':
                        payload = {
                            type: this.activeType,
                            label: this.form.label,
                            name: this.form.name,
                            model: this.form.model,
                            options: this.form.options,
                            width: this.form.width
                        };
                        break;
                    case 'currency':
                        payload = {
                            type: this.activeType,
                            label: this.form.label,
                            name: this.form.name,
                            model: this.form.model,
                            width: this.form.width,
                            currency: this.form.currency
                        };
                        break;
                }

                return payload
            }
        }
    }
</script>
