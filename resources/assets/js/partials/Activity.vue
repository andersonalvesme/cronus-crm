<template>
    <div>
        <x-panel :loading="loading" alt margin>
            <div slot="title">
                <div class="filters-title">
                    <span>{{$t(title)}}</span>
                </div>
            </div>
            <div slot="extra">
                <x-button @click="toggle" size="sm" type="success">{{$t('add_activity')}}</x-button>
            </div>
            <x-table class="table table-link">
                <thead>
                <x-tr slot="heading">
                    <x-td size="4" type="th">{{$t('date')}}</x-td>
                    <x-td size="4" type="th">{{$t('type')}}</x-td>
                    <x-td colspan="2" size="16" type="th">{{$t('description')}}</x-td>
                </x-tr>
                </thead>
                <x-tbody v-if="collection.data && collection.data.length">
                    <x-tr :key="item.id" v-for="item in collection.data">
                        <x-td>{{item.date | toDate}}</x-td>
                        <x-td>
		          	<span :class="`badge bg-${item.type.color}`">
		          		{{item.type.name}}
		          	</span>
                        </x-td>
                        <x-td>{{item.description}}</x-td>
                        <x-td>
                            <span @click="remove(item)" class="form-remove icon icon-trash-a"></span>
                        </x-td>
                    </x-tr>
                </x-tbody>
                <x-tbody v-else>
                    <x-tr>
                        <x-td colspan="10">
                            <div class="table-no_results">{{$t('no_results_found')}}</div>
                        </x-td>
                    </x-tr>
                </x-tbody>
            </x-table>
            <div class="flex flex-between flex-center" slot="footer">
                <div>
                    <select :disabled="loading" @input="updateLimit"
                            class="form-select form-select-sm">
                        <option :selected="query.limit === 5" value="5">5</option>
                        <option :selected="query.limit === 15" value="15">15</option>
                    </select>
                    <small>{{$t('showing', {from: collection.from || 0, to: collection.to || 0, total:
                        collection.total})}}</small>
                </div>
                <div>
                    <x-button :disabled="!collection.prev_page_url || loading" @click="prevPage"
                              size="sm">
                        &laquo; {{$t('prev')}}
                    </x-button>
                    <x-button :disabled="!collection.next_page_url || loading" @click="nextPage"
                              size="sm">
                        {{$t('next')}} &raquo;
                    </x-button>
                </div>
            </div>
        </x-panel>
        <x-modal :loading="loading" @cancel="show = false" @ok="save" v-if="show"
                 width="600">
            <div slot="title">{{$t('add_activity')}}</div>
            <div>
                <x-row>
                    <x-form-group :errors="errors.type_id" :label="$t('type')" col="15">
                        <x-tag-input :value="form.type" @input="value => { form.type_id = value.id; form.type = value }" column="name" name="name"
                                     resource="activity_types">
                        </x-tag-input>
                    </x-form-group>
                    <x-form-group :errors="errors.date" :label="$t('date')" col="9" type="date"
                                  v-model="form.date"></x-form-group>
                </x-row>
                <x-row>
                    <x-form-group :errors="errors.description" :label="$t('description')" col="24" source="textarea"
                                  v-model="form.description"></x-form-group>
                </x-row>
            </div>
        </x-modal>
    </div>
</template>
<script>
    export default {
        props: {
            id: Number,
            type: String
        },
        data() {
            return {
                res: 'activities',
                title: 'activities',
                collection: {
                    data: []
                },
                query: {
                    sort_column: 'created_at',
                    sort_direction: 'desc',
                    filter_match: 'and',
                    limit: 5,
                    page: 1
                },
                show: false,
                url: '/api/activities',
                loading: false,
                errors: {},
                form: {
                    description: '',
                    date: null,
                    type_id: null,
                    type: null
                }
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
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
            },
            fetch() {
                this.loading = true;
                this.errors = {};

                let params = {
                    type: this.type,
                    id: this.id,
                    ...this.query
                };

                this.$http.get(`/api/${this.res}`, {params: params})
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
            },
            toggle() {
                this.show = true
            },
            save(file) {
                this.loading = false;
                this.errors = {};
                const params = {
                    ...this.form,
                    callable_id: this.id,
                    callable_type: this.type,
                };
                this.$http.post(this.url, params)
                    .then((res) => {
                        this.loading = false;
                        this.$message.success(this.$t('saved_success'));
                        this.$set(this.$data, 'form', {
                            description: '',
                            date: null,
                            type_id: null,
                            type: null
                        });
                        this.fetch();
                        this.show = false
                    })
                    .catch((error) => {
                        this.loading = false;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
                    })
            }
        }
    }
</script>
