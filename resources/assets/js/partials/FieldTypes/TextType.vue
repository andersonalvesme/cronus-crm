<template>
    <div>
        <field-tab :tabs="tabs">
            <div slot="basic">
                <x-row line>
                    <x-col span="12">
                        <div class="form-group mb-2">
                            <label class="form-label">
                                {{$t('field_label')}}
                            </label>
                            <x-input :value="form.label" @input="handleTitle"></x-input>
                        </div>
                    </x-col>
                </x-row>
                <x-row line>
                    <x-col span="12">
                        <div class="form-group mb-2">
                            <label class="form-label">
                                {{$t('default_value')}}
                            </label>
                            <x-input :type="type" v-model="form.model"></x-input>
                        </div>
                    </x-col>
                </x-row>
                <x-row line>
                    <x-col span="12">
                        <div class="form-group mb-2">
                            <label class="form-label">
                                {{$t('field_name')}}
                            </label>
                            <x-input disabled v-model="form.name"></x-input>
                        </div>
                    </x-col>
                </x-row>
            </div>
            <div slot="extra">
                <x-row>
                    <x-col span="12">
                        <div class="form-group">
                            <label class="form-label">
                                {{$t('width')}}
                            </label>
                            <x-width size="lg" v-model="form.width"></x-width>
                        </div>
                    </x-col>
                </x-row>
            </div>
        </field-tab>
    </div>
</template>
<script>
    import FieldTab from '@js/components/tabs/FieldTab.vue'
    import {snakeCase} from 'lodash'

    export default {
        name: 'TextType',
        props: {
            tabs: Array,
            form: Object,
            type: {
                default: 'text'
            }
        },
        components: {FieldTab},
        methods: {
            handleTitle(value) {
                this.form.label = value;
                this.form.name = snakeCase(value)
            },
        }
    }
</script>
