<template>
	<div class="content-inner">
		<x-panel :padding="padding" alt>
			<div slot="title">
				<slot name="title"></slot>
			</div>
			<div slot="extra">
				<slot name="extra"></slot>
			</div>
			<div>
				<slot></slot>
			</div>
			<div slot="footer" class="flex flex-end">
				<div>
					<x-button @click="$emit('cancel')" type="white" :loading="saving" class="w-xs">{{$t('cancel')}}</x-button>
					<x-button @click="$emit('save')" type="primary" :loading="saving" class="float-right w-xs">{{$t('save')}}</x-button>
				</div>
			</div>
		</x-panel>
	</div>
</template>
<script>
	export default {
		name: 'XForm',
		props: {
			saving: Boolean,
			padding: Boolean,
		}
	}
</script>
