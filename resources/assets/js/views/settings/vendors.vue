<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('vendors')})}}</div>
            <x-row line>
                <x-form-group :errors="errors.default_vendor_category_id" :label="$t('default_vendor_category_id')"
                              col="4">
                    <x-tag-input :value="form.default_vendor_category" @input="value => { form.default_vendor_category_id = value.id; form.default_vendor_category = value }" column="name"
                                 name="name"
                                 resource="vendor_categories">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="float-right w-xs">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <settings-custom-field title="vendors"></settings-custom-field>

        <mini-crud title="vendor_categories"
                   url="settings/vendor_categories">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="9" type="th">{{$t('name')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
            </x-tr>
            <x-tr slot-scope="{ item, edit, remove }">
                <x-td>{{item.id}}</x-td>
                <x-td>{{item.name}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <div class="align-items-right">
                        <x-button @click="remove(item)" icon="trash" size="sm" class="float-right"></x-button>
                        <x-button @click="edit(item)" icon="pencil" size="sm" class="float-right mr-1"></x-button>
                    </div>
                </x-td>
            </x-tr>
        </mini-crud>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
    </div>
</template>
<script>
    import {settings} from '@js/lib/mixins'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'
    import MiniCrud from '@js/partials/MiniCrud.vue'

    export default {
        mixins: [settings],
        components: {MiniCrud, SettingsCustomField},
        data() {
            return {
                redirect: 'settings/vendors',
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
