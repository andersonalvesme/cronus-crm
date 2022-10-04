<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t(mode)}} {{$t('role')}}</div>
            <x-row line>
                <x-form-group :errors="errors.name" :label="$t('name')" col="12" v-model="form.name"></x-form-group>
                <x-form-group :errors="errors.description" :label="$t('description')" col="12" source="textarea"
                              v-model="form.description"></x-form-group>
            </x-row>
        </x-panel>
        <x-panel padding>
            <div slot="title">{{$t('permissions')}}</div>
            <div>
                <x-row :key="permission.name" line v-for="permission in form.permissions">
                    <x-group :label="permission.name" col="12">
                        <x-row line>
                            <x-col :key="key" span="2" v-for="(value, key) in permission.actions">
                                <label :key="key" class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" v-model="permission.actions[key]">
                                    <span class="form-check-label">{{$t(key)}}</span>
                                </label>
                            </x-col>
                        </x-row>
                    </x-group>
                </x-row>
            </div>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :disabled="isSaving" @click="cancel" class="w-xs">{{$t('cancel')}}</x-button>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">{{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
    </div>
</template>
<script>
    import {formable} from '@js/lib/mixins'

    export default {
        mixins: [formable],
        data() {
            return {
                form: {
                    permissions: []
                },
                redirect: 'settings/roles'
            }
        }
    }
</script>
