<template>
<textarea :disabled="disabled" :placeholder="placeholder"
          :value="value" @input="handleInput"
          class="form-control"></textarea>
</template>
<script>
    export default {
        name: 'XTextarea',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
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
