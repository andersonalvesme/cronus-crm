<template>
    <div class="filterable">
        <x-panel :loading="loading" alt margin>
            <div slot="title">
                <div class="filters-title">
                    <span>{{$t(title)}}</span>
                </div>
            </div>
            <div slot="extra">
                <x-button @click="toggleModal" type="primary" class="w-xs">{{$t('new')}}</x-button>
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
                <div class="card-footer d-flex align-items-center border-top-0" slot="footer">
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
            </div>
        </x-panel>

        <x-modal :loading="isSaving" :okText="$t('save')" @cancel="onCancel" @ok="save" v-if="showModal" width="450">
            <div slot="title">
                <div v-if="isEdit">
                    <span>{{$t('edit')}} {{$t('tasks')}}</span>
                </div>
                <div v-else>{{$t('add')}} {{$t('tasks')}}</div>
            </div>
            <x-form-group :errors="errors.title" :label="$t('title')" v-model="form.title"></x-form-group>
            <x-row>
                <x-form-group :errors="errors.start_date" :label="$t('start_date')" col="12"
                              type="date" v-model="form.start_date"></x-form-group>
                <x-form-group :errors="errors.due_date" :label="$t('due_date')" col="12"
                              type="date" v-model="form.due_date"></x-form-group>
            </x-row>
            <x-form-group :errors="errors.description" :label="$t('description')" source="textarea"
                          v-model="form.description"></x-form-group>
            <x-form-group :errors="errors.stage_id" :label="$t('stage_id')">
                <x-tag-input :value="form.stage" @input="value => { form.stage_id = value.id; form.stage = value }"
                             column="name" name="name"
                             resource="project_stages">
                </x-tag-input>
            </x-form-group>
        </x-modal>
    </div>
</template>
<script>
    export default {
        name: 'ProjectTasks',
        props: {
            title: String,
            url: String,
            type: String,
            project: Number
        },
        data() {
            return {
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
                    title: '',
                    start_date: null,
                    due_date: null,
                    description: '',
                    stage_id: null,
                    stage: null
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
                let url = `/api/${r}?project_id=${this.project}`;
                let method = 'post';

                if (this.isEdit) {
                    url = `/api/${r}/${id}?project_id=${this.project}`;
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
                    this.$set(this.form, 'name', null)
                }
                this.showModal = !this.showModal
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

                this.$http.delete(`/api/${this.url}/${item.id}?project_id=${this.project}`)
                    .then((res) => {
                        if (res.data.deleted) {
                            this.$message.success(this.$t('success_delete'));
                            this.fetch()
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

                this.$http.get(`/api/${this.url}?project_id=${this.project}`, {params: params})
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
