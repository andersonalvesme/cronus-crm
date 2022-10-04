<template>
    <div class="mt-2">
        <a @click="show = !show" href="javascrip:void(0)">
            <svg class="icon icon-tabler icon-tabler-chevron-right" fill="none" height="44" stroke="#2c3e50"
                 stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" v-if="!showList" viewBox="0 0 24 24"
                 width="44" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                <polyline points="9 6 15 12 9 18"/>
            </svg>
            <svg class="icon icon-tabler icon-tabler-chevron-down" fill="none" height="44"
                 stroke="#2c3e50" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" v-if="showList"
                 viewBox="0 0 24 24" width="44" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                <polyline points="6 9 12 15 18 9"/>
            </svg>
            {{title}}
        </a>
        <div class="mb-3" v-if="showList">
            <slot></slot>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            title: String,
            open: {
                default: false
            }
        },
        computed: {
            showList() {
                return this.show
            }
        },
        data() {
            return {
                show: this.open
            }
        }
    }
</script>
