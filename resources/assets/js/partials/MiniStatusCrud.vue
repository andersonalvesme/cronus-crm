<template>
    <div class="filterable">
        <x-panel :loading="loading" alt margin>
            <div slot="title">
                <div class="filters-title">
                    <span>{{$t(title)}}</span>
                </div>
            </div>
            <div slot="extra">
                <x-button @click="toggleModal" class="w-xs">{{$t('add')}}</x-button>
            </div>
            <div class="table-responsive" slot="table">
                <x-table class="table table-vcenter table-hover border-top m-0">
                    <thead>
                    <slot name="heading"></slot>
                    </thead>
                    <x-tbody v-if="collection.data && collection.data.length">
                        <slot :edit="edit" :item="item" :remove="remove" v-for="item in collection.data"></slot>
                    </x-tbody>
                    <x-tbody v-else>
                        <x-tr>
                            <x-td colspan="10">
                                <div class="table-no_results">{{$t('no_results_found')}}</div>
                            </x-td>
                        </x-tr>
                    </x-tbody>
                </x-table>
            </div>
            <div class="d-flex align-items-center border-top-0" slot="footer">
                <select :disabled="loading" @input="updateLimit"
                        class="form-select mr-2" style="width: auto;">
                    <option :selected="query.limit === 5" value="5">5</option>
                    <option :selected="query.limit === 15" value="15">15</option>
                </select>
                <div class="m-0 text-muted">
                    {{$t('showing', {from: collection.from || 0, to: collection.to || 0, total:
                    collection.total})}}
                </div>
                <div class="ml-auto simple_numbers">
                    <ul class="pagination m-0 ms-auto">
                        <li @click="prevPage" class="page-item"
                            v-bind:class="{'disabled': !collection.prev_page_url || loading}">
                            <a aria-disabled="true" class="page-link" href="#" tabindex="-1">
                                <svg class="icon" fill="none" height="24" stroke="currentColor"
                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     viewBox="0 0 24 24"
                                     width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                    <polyline points="15 6 9 12 15 18"></polyline>
                                </svg>
                                {{$t('prev')}}
                            </a>
                        </li>
                        <li @click="nextPage" class="page-item"
                            v-bind:class="{'disabled': !collection.next_page_url || loading}">
                            <a class="page-link" href="#">
                                {{$t('next')}}
                                <svg class="icon" fill="none" height="24" stroke="currentColor"
                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     viewBox="0 0 24 24"
                                     width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                    <polyline points="9 6 15 12 9 18"></polyline>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </x-panel>
        <x-modal :loading="isSaving" :okText="$t('save')" @cancel="onCancel" @ok="save" v-if="showModal" width="450">
            <div slot="title">
                <div v-if="isEdit">
                    <span>{{$t('edit')}}</span>
                </div>
                <div v-else>{{$t('add')}}</div>
            </div>
            <x-form-group :errors="errors.name" :label="$t('name')" v-model="form.name"></x-form-group>
            <x-form-group :errors="errors.color" :label="$t('color')">
                <div class="row row-sm">
                    <div class="col-auto" v-for="color in colors">
                        <label class="form-colorinput">
                            <input :checked="form.color === color" @click="select(color)" class="form-colorinput-input"
                                   name="color" type="radio">
                            <span :class="`form-colorinput-color bg-${color}`"></span>
                        </label>
                    </div>
                </div>
            </x-form-group>
            <x-form-group :errors="errors.locked" :label="$t('locked')" source="switch"
                          v-model="form.locked"></x-form-group>
        </x-modal>
    </div>
</template>
<script>
    export default {
        name: 'XMiniStatusCrud',
        props: {
            title: String,
            url: String,
            type: String
        },
        data() {
            return {
                colors: [
                    'blue',
                    'azure',
                    'indigo',
                    'purple',
                    'pink',
                    'red',
                    'orange',
                    'yellow',
                    'lime',
                    'green',
                    'teal',
                    'cyan',
                    'gray',
                    'blue-lt',
                    'azure-lt',
                    'indigo-lt',
                    'purple-lt',
                    'pink-lt',
                    'red-lt',
                    'orange-lt',
                    'yellow-lt',
                    'lime-lt',
                    'green-lt',
                    'teal-lt',
                    'cyan-lt',
                    'gray-lt',
                ],
                isSaving: false,
                loading: true,
                collection: {
                    data: []
                },
                errors: {},
                query: {
                    sort_column: 'created_at',
                    sort_direction: 'desc',
                    filter_match: 'and',
                    limit: 5,
                    page: 1
                },
                form: {
                    name: ''
                },
                id: null,
                showModal: false,
                isEdit: false
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            getForm() {
                let r = this.url;
                let id = this.id;
                let url = `/api/${r}`;
                let method = 'post';

                if (this.isEdit) {
                    url = `/api/${r}/${id}`;
                    method = 'put'
                }

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
                        this.fetch();
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
            toggleModal() {
                if (!this.showModal) {
                    this.$set(this.$data, 'form', {
                        name: null,
                        color: null,
                        locked: 0
                    })
                }
                this.showModal = !this.showModal
            },
            select(color) {
                this.form.color = color
            },
            onCancel() {
                this.showModal = false;
                this.isEdit = false
            },
            edit(item) {
                this.isEdit = true;
                this.id = item.id;
                this.$set(this.$data, 'form', item);
                this.showModal = true
            },
            remove(item) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }
                this.loading = true;

                this.$http.delete(`/api/${this.url}/${item.id}`)
                    .then((res) => {
                        if (res.data.deleted) {
                            this.$message.success(this.$t('success_delete'));
                            this.fetch()
                        }
                    })
                    .catch((error) => {
                        this.loading = false;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                            this.$message.error(error.response.data.message)
                        }
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

                this.$http.get(`/api/${this.url}`, {params: params})
                    .then((res) => {
                        this.setData(res)
                    })
            },
            setData(res) {
                this.$set(this.$data, 'collection', res.data.collection);
                this.query.page = this.collection.current_page;
                this.query.limit = Number(this.collection.per_page);
                this.loading = false
            },
            nextPage() {
                if (this.collection.next_page_url) {
                    this.query.page = this.query.page + 1;
                    this.fetch()
                }
            },
            prevPage() {
                if (this.collection.prev_page_url) {
                    this.query.page = this.query.page - 1;
                    this.fetch()
                }
            },
            updateLimit(e) {
                this.query.limit = Number(e.target.value);
                this.fetch()
            }
        }
    }
</script>
