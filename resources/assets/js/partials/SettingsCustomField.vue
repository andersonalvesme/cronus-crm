<template>
    <x-panel :loading="isSaving || loading" margin>
        <div slot="title">{{$t('custom_fields')}}</div>
        <div slot="extra">
            <x-button @click="toggleFieldModal" class="w-xs">{{$t('add')}}</x-button>
        </div>
        <div>
            <div class="row" v-if="form.fields.length > 0">
                <div :class="[`col col-${field.width}`]" v-for="(field, fIndex) in form.fields">
                    <field-item
                        :field="field"
                        :page="title"
                        @remove-field="handleRemoveField(fIndex, form.fields)"
                        @update="handleUpdateField(fIndex, form.fields, $event)"
                    />
                </div>
            </div>
            <div v-else>
                <div class="table-no_results">{{$t('no_custom_fields')}}</div>
            </div>
        </div>
        <div class="flex flex-end" slot="footer">
            <div>
                <x-button :loading="isSaving" @click="save" class="float-right w-xs" type="primary">
                    {{$t('save')}}
                </x-button>
            </div>
        </div>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
    </x-panel>
</template>
<script>
    import FieldItem from '@js/partials/CustomFieldItem.vue'
    import FieldTypeModal from '@js/partials/CustomFieldModal.vue'
    import MiniCrud from '@js/partials/MiniCrud.vue'

    export default {
        components: {FieldItem, FieldTypeModal, MiniCrud},
        props: {
            title: String,
            url: String,
        },
        data() {
            return {
                form: {
                    fields: []
                },
                errors: {},
                isSaving: false,
                loading: true,
                showFieldModal: false
            }
        },
        mounted() {
            this.fetch()
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
            getForm() {
                let r = this.url;
                let id = this.id;
                let url = `/api/settings/custom_fields?type=${this.title}`;
                let method = 'post';

                return {
                    url,
                    method
                }
            },
            save() {
                this.isSaving = true;
                this.errors = {};

                const {url, method} = this.getForm();

                this.$http[method](url, this.form)
                    .then((res) => {
                        this.showModal = false;
                        // this.fetch()
                        this.$message.success(this.$t('saved_success'))
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
                    })
                    .finally(() => {
                        this.isSaving = false
                    })
            },
            fetch() {
                this.loading = true;
                this.errors = {};

                let params = {
                    type: this.type,
                    id: this.id,
                    ...this.query
                };

                this.$http.get(`/api/settings/custom_fields?type=${this.title}`, {params: params})
                    .then((res) => {
                        this.setData(res)
                    })
            },
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.loading = false
            },
        }
    }
</script>
