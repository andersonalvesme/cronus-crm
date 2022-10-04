<template>
    <x-col :offset="offset" :span="col" v-if="col">
        <div class="form-group mb-2">
            <label class="form-label">
                <slot name="label" v-if="$slots.label"></slot>
                <template v-else>
                    {{label}}
                </template>
                <span class="text-danger" v-if="!optional">*</span>
            </label>
            <slot :class="{'is-invalid': errors && errors.length}" v-if="$slots.default"></slot>
            <component :class="{'is-invalid': errors && errors.length}" :is="`x-${source}`" @input="handleInput"
                       v-bind="$props" v-else></component>
            <div class="invalid-feedback" v-if="errors && errors.length">{{errors[0]}}</div>
        </div>
    </x-col>
    <div class="form-group mb-2" v-else>
        <label class="form-label">
            <slot name="label" v-if="$slots.label"></slot>
            <template v-else>
                {{label}}
            </template>
            <span class="text-danger" v-if="!optional">*</span>
        </label>
        <slot :class="{'is-invalid': errors && errors.length}" v-if="$slots.default"></slot>
        <component :class="{'is-invalid': errors && errors.length}" :is="`x-${source}`" @input="handleInput"
                   v-bind="$props" v-else></component>
        <div class="invalid-feedback" v-if="errors && errors.length">{{errors[0]}}</div>
    </div>
</template>
<script>
    export default {
        name: 'XFormGroup',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            type: {
                default: 'text'
            },
            value: [String, Number, Object, Array, Boolean],
            options: Array,
            tabindex: [String, Number],
            placeholder: String,
            disabled: {
                type: Boolean,
                default: false
            },
            optional: {
                type: Boolean,
                default: false
            },
            source: {
                type: String,
                default: 'input'
            },
            errors: {
                default: null
            },
            label: String,
            col: {
                default: null
            },
            offset: {
                default: null
            },
            size: {
                default: null
            }
        },
        methods: {
            handleInput(input) {
                this.$emit('input', input)
            }
        }
    }
</script>
