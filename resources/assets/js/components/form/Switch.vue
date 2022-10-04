<template>
    <transition name="fade">
        <label class="form-check form-switch">
            <input :checked="value" :disabled="disabled" @click="toggleSwitch" @keydown.space.prevent="toggleSwitch"
                   class="form-check-input" type="checkbox">
            <span class="form-check-label" v-if="label">{{ label }}</span>
        </label>
    </transition>
</template>
<script>
    export default {
        name: 'XSwitch',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: [Boolean, Number],
            label: [String, Number],
            disabled: {
                type: Boolean,
                default: false
            },
            tabindex: {
                default: 0
            }
        },
        methods: {
            toggleSwitch(e) {
                if (this.disabled) return;
                this.$emit('input', !this.value)
            }
        }
    }
</script>
