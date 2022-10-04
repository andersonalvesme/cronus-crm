<template>
    <div class="btn-group">
        <button :class="[`btn btn-white btn-sm`, selected === x ? 'active' : '']" @click="select(x)"
                type="button" v-for="x in [1, 3, 6, 9, 12]">{{x}}
        </button>
    </div>
</template>
<script>
    export default {
        name: 'XWidth',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            size: {
                default: null
            },
            value: [String, Number]
        },
        data() {
            return {
                isHovering: false,
                hoveringOver: this.value
            }
        },
        computed: {
            selected() {
                if (this.isHovering) {
                    return this.hoveringOver;
                }

                return this.value;
            }
        },
        methods: {
            select(x) {
                this.$emit('input', x)
            }
        }
    }
</script>
