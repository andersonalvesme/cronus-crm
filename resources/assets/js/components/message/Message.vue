<template>
    <transition name="move-up">
        <div :class="['alert', 'alert-dismissible', `alert-${item.type}`]">
            <img alt="" class="icon mr-1" v-bind:src="`/icons/${iconClass}.svg`">
            {{item.text}}
            <a @click="close" class="close" href="javascript:void(0)" v-if="item.duration === 0">×</a>
        </div>
    </transition>
</template>
<script>
    export default {
        name: 'XMessageItem',
        props: {
            item: {
                required: true
            }
        },
        computed: {
            iconClass() {
                const classArr = {
                    'success': 'check',
                    'danger': 'alert-octagon',
                    'warning': 'alert-triangle',
                    'info': 'info-circle'
                };

                return this.icon || classArr[this.item.type]
            }
        },
        mounted() {
            this.startTimer()
        },
        methods: {
            startTimer() {
                if (this.item.duration === 0) return;
                setTimeout(() => {
                    this.$emit('close', this.item.id)
                }, this.item.duration)
            },
            close() {
                this.$emit('close', this.item.id)
            }
        }
    }
</script>
