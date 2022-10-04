<template>
    <div>
        <div aria-hidden="true" class="modal modal-blur show" id="modal-simple" role="dialog" style="display: block"
             tabindex="-1">
            <div :class="`modal-dialog modal-dialog-centered modal-dialog-scrollable modal-${size}`" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="$slots.title">
                            <slot name="title"></slot>
                        </h5>
                        <button @click="handleMaskClick" aria-label="Close" class="close" data-dismiss="modal"
                                type="button">
                            <svg class="icon" fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" stroke="none"/>
                                <line x1="18" x2="6" y1="6" y2="18"/>
                                <line x1="6" x2="18" y1="6" y2="18"/>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer bg-white" v-if="footer">
                        <template v-if="$slots.footer">
                            <slot name="footer"></slot>
                        </template>
                        <template v-else>
                            <x-button @click="cancel" class="w-xs mr-auto">{{cancelText}}</x-button>
                            <x-button @click="ok" type="primary" class="w-xs">{{okText}}</x-button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>
<script>
    export default {
        name: 'XModal',
        props: {
            alt: {
                type: [Boolean, String],
                default: false
            },
            okText: {
                default: 'Ok'
            },
            cancelText: {
                default: 'Cancelar'
            },
            size: {
                default: 'md'
            },
            loading: {
                type: Boolean,
                default: false
            },
            footer: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            handleClose(e) {
                this.$emit('close');
                this.close()
            },
            handleMaskClick(e) {
                this.close()
            },
            cancel() {
                this.$emit('cancel')
            },
            ok() {
                this.$emit('ok')
            },
            close() {
                this.cancel()
            },
            handleWrapperClick() {
                this.close()
            },
            handleKeyCode(evt) {
                if (evt.keyCode === 27) { // esc
                    this.close()
                }
            },
        },
        mounted() {
            document.addEventListener('keydown', this.handleKeyCode)
        },
        beforeDestory() {
            document.removeEventListener('keydown', this.handleKeyCode)
        }
    }
</script>
