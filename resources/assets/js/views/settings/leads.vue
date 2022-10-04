<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('leads')})}}</div>
            <x-row line>
                <x-form-group :errors="errors.lead_status_on_create_id" :label="$t('lead_status_on_create')" col="4">
                    <x-tag-input :value="form.lead_status_on_create"
                                 @input="value => { form.lead_status_on_create_id = value.id; form.lead_status_on_create = value }"
                                 column="name" name="name"
                                 resource="lead_statuses">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="w-xs float-right" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <settings-custom-field title="leads"></settings-custom-field>
        <mini-status-crud title="lead_statuses" url="settings/lead_statuses">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="6" type="th">{{$t('name')}}</x-td>
                <x-td size="2" type="th">{{$t('color')}}</x-td>
                <x-td size="1" type="th">{{$t('locked')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>
		    	<span :class="`badge bg-${item.color}`">
		    		{{item.color}}
		    	</span>
                </x-td>
                <x-td>{{item.locked ? $t('yes') : $t('no')}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" class="float-right" icon="trash" size="sm"></x-button>
                        <x-button @click="edit(item)" class="float-right mr-1" icon="pencil" size="sm"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-status-crud>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'
    import MiniStatusCrud from '@js/partials/MiniStatusCrud.vue'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'

    export default {
        mixins: [settings],
        components: {MiniStatusCrud, SettingsCustomField},
        data() {
            return {
                redirect: 'settings/leads',
                form: {
                    fields: []
                },
                showFieldModal: false
            }
        },
        methods: {
            handleUpdateField(i, fields, e) {
                const f = e.target.value;
                this.$set(this.form.fields, i, f)
            },
            handleRemoveField(index, fields) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }
                fields.splice(index, 1)
            },
            handleAddField(e) {
                const f = e.target.value;
                this.form.fields.push(f);
                this.toggleFieldModal();
            },
            toggleFieldModal() {
                this.showFieldModal = !this.showFieldModal
            },
        }
    }
</script>
