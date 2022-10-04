<template>
    <div>
        <ul :class="['nav', 'nav-tabs', 'mb-3']">
            <li class="nav-item" v-for="tab in tabs">
                <a :class="['nav-link', tab && tab.name === activeTab ? 'active' : '']" @click="setActive(tab)">{{tab.title}}</a>
            </li>
        </ul>
        <slot :name="tab.name" v-for="tab in tabs" v-if="tab && tab.name === activeTab"/>
    </div>
</template>
<script>
    export default {
        name: 'XFieldTab',
        props: {
            tabs: Array
        },
        data() {
            return {
                active: null
            }
        },
        computed: {
            activeTab() {
                if (this.active) {
                    return this.active
                } else {
                    return this.tabs[0].name
                }
            }
        },
        methods: {
            setActive(tab) {
                this.active = tab.name
            }
        }
    }
</script>
