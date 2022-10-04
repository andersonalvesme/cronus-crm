<template>
    <div v-if="show">
        <settings-custom-field title="contacts"></settings-custom-field>
        <field-type-modal @add="handleAddField" @cancel="toggleFieldModal"
                          v-if="showFieldModal"></field-type-modal>
    </div>
</template>
<script>
    // import { settings } from '@js/lib/mixins'

    import SettingsCustomField from '@js/partials/SettingsCustomField.vue'

    export default {
        // mixins: [ settings ],
        components: {SettingsCustomField},
        data() {
            return {
                show: true,
                redirect: 'settings/contacts',
                form: {
                    fields: []
                },
                showFieldModal: false
            }
        },
        mounted() {
            this.show = true;
            this.$bar.finish()
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
