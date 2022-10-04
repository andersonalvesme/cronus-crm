<template>
    <div class="dropdown">
        <div ref="button">
            <slot :toggle="toggle" name="button">
                <x-button :icon="icon" :size="size" @click.stop="toggle()">
                    <span v-if="title">{{title}}</span>
                </x-button>
            </slot>
        </div>
        <div ref="inside">
            <slot name="menu" v-if="show"></slot>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'XDropdown',
        props: {
            icon: {
                default: null
            },
            title: String,
            size: String
        },
        data() {
            return {
                show: false
            }
        },
        beforeDestroy() {
            this.close()
        },
        methods: {
            toggle() {
                if (this.show) {
                    this.close()
                } else {
                    this.open()
                }
            },
            open() {
                this.show = true;
                this.$nextTick(() => {
                    document.addEventListener('click', this.clickOutEvent);
                    document.addEventListener('keydown', this.handleKeyCode)
                });
            },
            close() {
                document.removeEventListener('click', this.clickOutEvent);
                document.removeEventListener('keydown', this.handleKeyCode);
                this.show = false
            },
            clickOutEvent(evt) {
                var $dd = this.$refs.inside;
                if (evt.target !== $dd && !$dd.contains(evt.target)) {
                    this.close()
                } else {
                    // close when click items
                    this.close()
                }
            },
            handleKeyCode(evt) {
                if (evt.keyCode === 27) {
                    this.close()
                }
            }
        }
    }
</script>
