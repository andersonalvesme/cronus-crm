<template>
    <div :class="[
		'card',
		margin ? 'panel-margin' : ''
	]">
        <div class="card-header border-bottom-0" v-if="$slots.title || $slots.extra">
            <div class="card-title" v-if="$slots.title">
                <slot name="title"></slot>
            </div>
            <div class="col-auto ml-auto" v-if="true">
                <slot name="extra"></slot>
            </div>
        </div>
        <div class="card-body" v-if="$slots.default">
            <slot></slot>
        </div>
        <slot name="table"></slot>
        <div class="card-footer" v-if="$slots.footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        name: 'XPanel',
        props: {
            margin: {
                type: [Boolean, String],
                default: false
            },
            alt: {
                type: [Boolean, String],
                default: false
            },
            loading: {
                type: Boolean,
                default: false
            },
            padding: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
