<template>
    <div>
        <div class="dropdown-divider" v-if="divide"></div>
        <a class="dropdown-item" href="javascript:void(0)">
            <slot></slot>
        </a>
    </div>
</template>
<script>
    export default {
        name: 'XDropdownItem',
        props: {
            divide: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
