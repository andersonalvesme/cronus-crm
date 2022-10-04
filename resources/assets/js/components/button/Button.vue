<template>
    <button :class="[
			'btn',
			icon ? `btn-icon` : '',
            type ? `btn-${type}` : '',
            size ? `btn-${size}` : '',
            loading ? `btn-loading` : ''
        ]"
            :disabled="disabled || loading" @click="handleClick" type="button">
        <img alt="" class="icon" v-bind:src="'/icons/' + icon + '.svg'" v-if="icon && !loading">
        <slot v-if="$slots.default"></slot>
    </button>
</template>
<script>
    export default {
        name: 'XButton',
        props: {
            type: {
                type: String,
                default: 'white'
            },
            size: String,
            icon: {
                default: null
            },
            disabled: {
                type: Boolean,
                default: false
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            handleClick(evt) {
                this.$emit('click', evt)
            }
        }
    }
</script>
