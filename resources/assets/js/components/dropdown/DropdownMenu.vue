<template>
    <div :class="`dropdown-menu dropdown-menu-${dir} show`">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        name: 'XDropdownMenu',
        props: {
            dir: {
                default: 'left'
            }
        }
    }
</script>
