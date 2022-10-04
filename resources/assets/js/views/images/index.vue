<template>
    <div>
        <x-filterable :exportable="false" :filter-group="filters" :sortable="sortable" :title="title"
                      :url="url" ref="filterable">
            <div class="float-right" slot="extra">
                <x-button @click="toggleUploadModal" type="primary">{{$t('upload')}}</x-button>
            </div>
            <x-tr slot="heading">
                <x-td size="1" type="th">{{$t('id')}}</x-td>
                <x-td size="3" type="th">{{$t('image')}}</x-td>
                <x-td size="4" type="th">{{$t('title')}}</x-td>
                <x-td size="2" type="th">{{$t('size')}}</x-td>
                <x-td size="2" type="th">{{$t('created_at')}}</x-td>
                <x-td type="th"></x-td>
            </x-tr>
            <x-tr @click.native="showPreview(item)" slot-scope="{ item }">
                <x-td>{{item.id}}</x-td>
                <x-td>
                    <img :src="item.filename" class="index-thumb">
                </x-td>
                <x-td>{{item.title}}</x-td>
                <x-td>{{item.size}}</x-td>
                <x-td>{{item.created_at | toDate}}</x-td>
                <x-td>
                    <x-button @click.stop="remove(item)" icon="trash" size="sm"></x-button>
                </x-td>
            </x-tr>
        </x-filterable>
        <x-modal :footer="false" @cancel="onClose" v-if="showModal" width="900">
            <div slot="title">{{$t('image')}} / {{selected.title}}</div>
            <div class="image-preview">
                <div class="image-holder">
                    <div class="image-holder-inner">
                        <img :src="selected.filename" class="image-thumb">
                    </div>
                </div>
                <div class="image-form">
                    <x-row>
                        <x-col span="8">
                            <div class="form-group">
                                <label class="form-label">{{$t('extension')}}</label>
                                <p>{{selected.extension}}</p>
                            </div>
                        </x-col>
                        <x-col span="8">
                            <div class="form-group">
                                <label class="form-label">{{$t('size')}}</label>
                                <p>{{selected.size}}</p>
                            </div>
                        </x-col>
                        <x-col span="8">
                            <div class="form-group">
                                <label class="form-label">{{$t('dimension')}}</label>
                                <p>{{selected.dimension}}</p>
                            </div>
                        </x-col>
                    </x-row>
                    <div class="form-group">
                        <label class="form-label">{{$t('filename')}}</label>
                        <p>{{selected.filename}}</p>
                    </div>
                    <br>
                    <x-form-group :errors="errors.title" :label="$t('title')" v-model="form.title"></x-form-group>
                    <x-button :loading="isSaving" @click="saveTitle(form)" type="primary">{{$t('save')}}</x-button>
                </div>
            </div>
        </x-modal>
        <upload @cancel="onUploadClose" @saved="onSaved" v-if="showUploadModal"></upload>
    </div>
</template>
<script>
    import {indexable} from '@js/lib/mixins'
    import upload from '@js/views/images/upload.vue'

    export default {
        mixins: [indexable],
        components: {upload},
        data() {
            return {
                url: 'images',
                title: 'media_library',
                selected: null,
                showModal: false,
                form: {
                    title: null
                },
                errors: {},
                isSaving: false,
                showUploadModal: false
            }
        },
        computed: {
            sortable() {
                let columns = [
                    'id', 'title', 'size', 'extension',
                    'created_at'
                ];
                return columns
            },
            filters() {
                let groups = [{
                    title: this.$t('media_library'),
                    filters: [
                        {name: 'id', type: 'numeric'},
                        {name: 'title', type: 'string'},
                        {name: 'extension', type: 'string'},
                        {name: 'size', type: 'numeric'},
                        {name: 'dimension', type: 'string'},
                        {name: 'created_at', type: 'datetime'},
                    ]
                }];

                return groups
            }
        },
        methods: {
            remove(item) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }
                this.loading = true;

                this.$http.delete(`/api/images/${item.id}`)
                    .then((res) => {
                        if (res.data.deleted) {
                            this.$message.success(this.$t('success_delete'));
                            const id = Math.random().toString(36).substring(7);
                            this.$router.push(`/media_library?id=${id}`)
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
            onSaved(e) {
                this.onUploadClose();
                this.$router.push(`/media_library?q=${e.str_rand}`)
            },
            showPreview(item) {
                this.selected = item;
                this.form.title = item.title;
                this.showModal = true
            },
            onClose() {
                this.selected = null;
                this.showModal = false
            },
            saveTitle(form) {
                this.errors = {};
                this.isSaving = true;
                this.$http.put(`/api/images/${this.selected.id}`, form)
                    .then((res) => {
                        this.selected.title = form.title;
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
            toggleUploadModal() {
                this.showUploadModal = true
            },
            onUploadClose() {
                this.showUploadModal = false
            }
        }
    }
</script>
