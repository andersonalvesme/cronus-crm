<template>
    <div class="message-container col-3">
        <x-message-item :item="item" :key="item.id" @close="onClose(index)"
                        v-for="(item, index) in messages"></x-message-item>
    </div>
</template>
<script>
    import XMessageItem from './Message.vue'

    export default {
        name: 'XMessageList',
        components: {XMessageItem},
        data() {
            return {
                counter: 1,
                messages: []
            }
        },
        methods: {
            onClose(i) {
                this.messages.splice(i, 1)
            },
            getNewId() {
                return this.counter++
            },
            push(type, text, duration = 3000) {
                const id = this.getNewId();
                const message = {
                    id: id,
                    type: type,
                    text: text,
                    duration: duration
                };

                this.messages.push(message);
                return message
            },
            info(text) {
                return this.push('info', text)
            },
            success(text) {
                return this.push('success', text)
            },
            error(text, duration = 4000) {
                return this.push('danger', text, duration)
            },
            warning(text) {
                return this.push('warning', text)
            }
        }
    }
</script>
