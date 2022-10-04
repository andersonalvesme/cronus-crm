<template>
    <div class="content-inner" v-if="show">
        <x-panel margin padding>
            <div slot="title">{{$t('x_settings', {title: $t('opportunities')})}}</div>
            <x-row line>
                <x-form-group :errors="errors.default_opportunity_category_id" :label="$t('default_opportunity_category_id')"
                              col="4">
                    <x-tag-input :value="form.default_opportunity_category" @input="value => { form.default_opportunity_category_id = value.id; form.default_opportunity_category = value }"
                                 column="name" name="name"
                                 resource="opportunity_categories">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.default_opportunity_source_id" :label="$t('default_opportunity_source_id')"
                              col="4">
                    <x-tag-input :value="form.default_opportunity_source" @input="value => { form.default_opportunity_source_id = value.id; form.default_opportunity_source = value }" column="name"
                                 name="name"
                                 resource="opportunity_sources">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.opportunity_stage_on_create_id" :label="$t('opportunity_stage_on_create_id')"
                              col="4">
                    <x-tag-input :value="form.opportunity_stage_on_create" @input="value => { form.opportunity_stage_on_create_id = value.id; form.opportunity_stage_on_create = value }" column="name"
                                 name="name"
                                 resource="opportunity_stages">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.opportunity_stage_on_win_id" :label="$t('opportunity_stage_on_win_id')"
                              col="4">
                    <x-tag-input :value="form.opportunity_stage_on_win" @input="value => { form.opportunity_stage_on_win_id = value.id; form.opportunity_stage_on_win = value }" column="name"
                                 name="name"
                                 resource="opportunity_stages">
                    </x-tag-input>
                </x-form-group>
                <x-form-group :errors="errors.opportunity_stage_on_lost_id" :label="$t('opportunity_stage_on_lost_id')"
                              col="4">
                    <x-tag-input :value="form.opportunity_stage_on_lost" @input="value => { form.opportunity_stage_on_lost_id = value.id; form.opportunity_stage_on_lost = value }" column="name"
                                 name="name"
                                 resource="opportunity_stages">
                    </x-tag-input>
                </x-form-group>
            </x-row>
            <x-row line>
                <x-form-group :errors="errors.close_after_x_days" :label="$t('close_after_x_days')" col="4"
                              type="number" v-model="form.close_after_x_days"></x-form-group>
                <x-form-group :errors="errors.default_probability" :label="$t('default_probability')" col="4" size="lg"
                              source="width" v-model="form.default_probability"></x-form-group>
            </x-row>
            <div class="flex flex-end" slot="footer">
                <div>
                    <x-button :loading="isSaving" @click="save" type="primary" class="w-xs float-right">
                        {{$t('save')}}
                    </x-button>
                </div>
            </div>
        </x-panel>
        <settings-custom-field title="opportunities"></settings-custom-field>
        <mini-crud title="opportunity_categories"
                   url="settings/opportunity_categories">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="9" type="th">{{$t('name')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
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
        <mini-crud title="opportunity_sources"
                   url="settings/opportunity_sources">
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="9" type="th">{{$t('name')}}</x-td>
                <x-td size="1" type="th">{{$t('created_at')}}</x-td>
                <x-td size="1" type="th"></x-td>
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
        <mini-status-crud title="opportunity_stages"
                          url="settings/opportunity_stages">
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
                        <x-button @click="remove(item)" icon="trash" size="sm" class="float-right"></x-button>
                        <x-button @click="edit(item)" icon="pencil" size="sm" class="float-right mr-1"></x-button>
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
    import MiniCrud from '@js/partials/MiniCrud.vue'
    import MiniStatusCrud from '@js/partials/MiniStatusCrud.vue'
    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'

    export default {
        mixins: [settings],
        components: {MiniCrud, MiniStatusCrud, SettingsCustomField},
        data() {
            return {
                redirect: 'settings/opportunities',
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
