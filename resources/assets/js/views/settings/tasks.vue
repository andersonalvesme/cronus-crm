<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('tasks')})}}</div>
            <x-row line>
                <x-form-group :errors="errors.task_status_on_create_id" :label="$t('task_status_on_create_id')"
                              col="4">
                    <x-tag-input :value="form.task_status_on_create"
                                 @input="value => { form.task_status_on_create_id = value.id; form.task_status_on_create = value }"
                                 column="name"
                                 name="name"
                                 resource="task_statuses">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_task_type_id" :label="$t('default_task_type_id')" col="4">
                    <x-tag-input :params="{type_id: '2'}" :value="form.default_task_type"
                                 @input="value => { form.default_task_type_id = value.id; form.default_task_type = value }"
                                 column="name"
                                 name="name"
                                 resource="task_types">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <mini-crud title="task_types"
                   url="settings/task_types">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="8" type="th">{{$t('name')}}</x-td>
                <x-td size="2" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" class="float-right" icon="trash" size="sm"></x-button>
                        <x-button @click="edit(item)" class="float-right mr-1" icon="pencil" size="sm"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-crud>
        <mini-status-crud title="task_statuses"
                          url="settings/task_statuses">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="5" type="th">{{$t('name')}}</x-td>
                <x-td size="2" type="th">{{$t('color')}}</x-td>
                <x-td size="1" type="th">{{$t('locked')}}</x-td>
                <x-td size="2" type="th">{{$t('created_at')}}</x-td>
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
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'
    import MiniCrud from '@js/partials/MiniCrud.vue'
    import MiniStatusCrud from '@js/partials/MiniStatusCrud.vue'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'
    import EmailVariablesModal from '@js/partials/EmailVariablesModal.vue'

    export default {
        mixins: [settings],
        components: {MiniCrud, MiniStatusCrud, SettingsCustomField, EmailVariablesModal},
        data() {
            return {
                redirect: 'settings/contracts',
                form: {
                    fields: []
                },
                options: {},
                showFieldModal: false,
                showVarModal: false
            }
        },
        methods: {
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.$set(this.$data, 'options', res.data.options);
                this.$bar.finish();
                this.show = true
            },
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
            toggleVarModal() {
                this.showVarModal = !this.showVarModal
            }
        }
    }
</script>
