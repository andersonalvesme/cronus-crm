<template>
    <div class="form-group">
        <label @mouseenter="isHovering = true"
               @mouseleave="isHovering = false"
               class="form-label">
            <x-button @click="removeField" class="float-right" icon="trash" size="sm" v-if="isEdit"></x-button>
            <x-button @click="toggleFieldModal" class="float-right mr-1" icon="pencil" size="sm"
                      v-if="isEdit"></x-button>
            <x-width class="float-right mr-1" v-if="isEdit" v-model="field.width"></x-width>
            <span v-if="!isEdit">{{field.label}}</span>
            <span v-if="isEdit">&nbsp;</span>
        </label>
        <div v-if="field.type === 'select'">
            <select class="form-select" v-model="field.model">
                <option v-for="option in field.options">{{option}}</option>
            </select>
        </div>
        <div v-if="field.type === 'text'">
            <input class="form-control" type="text" v-model="field.model">
        </div>
        <div v-if="field.type === 'number'">
            <input class="form-control" type="number" v-model="field.model">
        </div>
        <div v-if="field.type === 'date'">
            <input class="form-control" type="date" v-model="field.model">
        </div>
        <div v-if="field.type === 'image'">
            <field-image v-model="field.model"></field-image>
        </div>
        <div v-if="field.type === 'currency'">
            <input class="form-control" type="number" v-model="field.model">
        </div>
        <div v-if="field.type === 'textarea'">
            <textarea class="form-control" v-model="field.model"></textarea>
        </div>
        <div v-if="field.type === 'list'">
            <div class="form-list" v-for="(m, i) in field.list_model">
                <input class="form-control" type="text" v-model="field.list_model[i]">
                <span @click="field.list_model.splice(i, 1)" class="form-list-remove">
                    <i class="icon icon-trash-b"></i>
                </span>
            </div>
            <x-button @click="field.list_model.push('')" icon="plus" size="sm"></x-button>
        </div>
        <div v-if="field.type === 'table'">
            <field-table :field="field"></field-table>
        </div>
        <field-type-modal :field="field" @cancel="toggleFieldModal"
                          @update="onUpdate" v-if="showFieldModal"></field-type-modal>
    </div>
</template>
<script>
    import FieldTypeModal from '@js/partials/FieldTypeModal.vue'
    import FieldImage from '@js/partials/FieldImage.vue'
    import FieldTable from '@js/partials/FieldTable.vue'

    export default {
        components: {FieldTypeModal, FieldImage, FieldTable},
        props: {
            field: Object,
            page: String,
            editable: {
                default: true
            }
        },
        data() {
            return {
                isHovering: false,
                showFieldModal: false
            }
        },
        computed: {
            varName() {
                return `${this.page}.${field.name}`
            },
            isEdit() {
                return this.isHovering && this.editable
            }
        },
        methods: {
            onUpdate(e) {
                this.$emit('update', e);
                this.toggleFieldModal();
            },
            toggleFieldModal() {
                this.showFieldModal = !this.showFieldModal
            },
            removeField() {
                this.$emit('remove-field')
            }
        }
    }
</script>
