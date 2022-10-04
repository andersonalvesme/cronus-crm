<template>
    <input :disabled="disabled" :placeholder="placeholder" :type="type"
           :value="value" @input="handleInput"
           class="form-control"/>
</template>
<script>
    export default {
        name: 'XInput',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            type: {
                default: 'text'
            },
            value: [String, Number],
            placeholder: String,
            disabled: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            handleInput(e) {
                this.$emit('input', e.target.value)
            }
        }
    }
</script>
