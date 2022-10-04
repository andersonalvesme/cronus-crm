<template>
    <div class="row">
        <div class="col-3">
            <div class="sticky-top">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <ul class="dropdown-menu dropdown-menu-demo show">
                            <div class="row mt-2">
                                <div class="col-12 align-content-center">
                                    <h6 class="dropdown-header pt-1">{{$t('settings')}}</h6>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>

                            <template v-for="link in links">
                                <a :class="['dropdown-item', activeTab === link.to ? 'active' : '']"
                                   @click.stop="openTab(link.to)"
                                   href="javascript:void(0)">
                                    {{link.title}}
                                    <div class="ml-auto" v-if="hasError(link.to)">
                                        <a class="icon text-red" href="javascript:void(0)">
                                            <svg class="icon icon-tabler icon-tabler-alert-circle"
                                                 fill="none" height="44"
                                                 stroke="#cd201f" stroke-linecap="round" stroke-linejoin="round"
                                                 stroke-width="1.5"
                                                 viewBox="0 0 24 24" width="44" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                                                <circle cx="12" cy="12" r="9"/>
                                                <line x1="12" x2="12" y1="8" y2="12"/>
                                                <line x1="12" x2="12.01" y1="16" y2="16"/>
                                            </svg>
                                        </a>
                                    </div>
                                </a>
                            </template>

                            <div class="row mt-4">
                                <div class="col-12 align-content-center">
                                    <x-button @click="handleAddPage" class="float-right" size="sm">{{$t('add')}}
                                    </x-button>
                                    <h6 class="dropdown-header pt-1">{{$t('pages')}}</h6>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>

                            <draggable @end="drag=false" @start="drag=true" v-model="form.pages">
                                <template v-for="(page, index) in form.pages">
                                    <a :class="['dropdown-item', activeTab === 'pages' && currentPageIndex === index ? 'active' : '']"
                                       @click.stop="openPage(page, index)" href="javascript:void(0)">
                                        <i class="fa fa-drag"></i>
                                        <span class="template-text">{{page.title}}</span>
                                        <template v-if="page.index = index"></template>
                                        <div class="ml-auto" v-if="hasError(`pages.${index}`)">
                                            <a class="icon text-red" href="javascript:void(0)">
                                                <svg class="icon icon-tabler icon-tabler-alert-circle"
                                                     fill="none" height="44"
                                                     stroke="#cd201f" stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="1.5"
                                                     viewBox="0 0 24 24" width="44" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <line x1="12" x2="12" y1="8" y2="12"/>
                                                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </a>
                                </template>
                            </draggable>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-9">
            <div class="row mb-2">
                <div class="col-12">
                    <div v-if="isSaving">
                        <x-loading></x-loading>
                    </div>
                    <div class="float-right" v-else>
                        <router-link :to="`/templates/${form.id}`" class="btn btn-white btn-icon"
                                     v-if="mode !== 'create'">
                            <svg class="icon icon-tabler icon-tabler-arrow-left" fill="none" height="24"
                                 stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 viewBox="0 0 24 24"
                                 width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                <line x1="5" x2="19" y1="12" y2="12"></line>
                                <line x1="5" x2="11" y1="12" y2="18"></line>
                                <line x1="5" x2="11" y1="12" y2="6"></line>
                            </svg>
                        </router-link>
                        <a :href="`/api/templates/${form.id}/preview`" class="btn btn-white" size="sm"
                           target="_blank" v-if="mode !== 'create'">{{$t('preview')}}</a>
                        <x-button @click="saveTemplate" class="w-xs" type="primary">{{$t('save')}}</x-button>
                    </div>
                    <h2 class="page-title">
                        {{$t(mode)}} {{$t('template')}} / <small>({{form.name}})</small>
                    </h2>
                </div>
            </div>
            <div class="template-content" ref="content">
                <x-simple-tab :active="activeTab" :tabs="availableTabs">
                    <div slot="settings">
                        <x-panel padding>
                            <div slot="title">{{$t('settings')}}</div>
                            <x-row line>
                                <x-form-group :errors="errors.name" :label="$t('name')"
                                              col="6" v-model="form.name"></x-form-group>
                                <x-form-group :errors="errors.type_id" :label="$t('type')" col="3">
                                    <select class="form-select" v-model="form.type_id">
                                        <option :value="o.name" v-for="o in opt.types">{{o.value}}</option>
                                    </select>
                                </x-form-group>
                                <x-form-group :errors="errors.page_size" :label="$t('page_size')" col="3">
                                    <select class="form-select" v-model="form.page_size">
                                        <option :value="o.name" v-for="o in opt.sizes">{{o.value}}</option>
                                    </select>
                                </x-form-group>
                            </x-row>
                            <x-row line>
                                <x-form-group :errors="errors.orientation" :label="$t('orientation')" col="3">
                                    <select class="form-select" v-model="form.orientation">
                                        <option :value="o.name" v-for="o in opt.orientations">{{o.value}}</option>
                                    </select>
                                </x-form-group>
                                <x-form-group :errors="errors.header_height" :label="$t('header_height')"
                                              col="3" v-model="form.header_height"></x-form-group>
                                <x-form-group :errors="errors.footer_height" :label="$t('footer_height')"
                                              col="3" v-model="form.footer_height"></x-form-group>
                            </x-row>
                        </x-panel>
                    </div>
                    <div slot="stylesheet">
                        <x-panel>
                            <div slot="title">{{$t('stylesheet')}}</div>
                            <div>
                                <x-form-group :errors="errors.stylesheet" :label="$t('stylesheet')">
                                    <codemirror :options="{mode: 'text/css'}"
                                                class="border" v-model="form.stylesheet"></codemirror>
                                </x-form-group>
                            </div>
                        </x-panel>
                    </div>
                    <div slot="header">
                        <x-panel>
                            <div slot="title">
                                {{$t('header')}}
                            </div>
                            <div class="float-right" slot="extra">
                                <x-button @click="toggleTempVar" size="sm">{{$t('variables')}}</x-button>
                            </div>
                            <div>
                                <x-form-group :errors="errors.header_html" :label="$t('header_html')">
                                    <codemirror :options="{mode: 'text/html'}"
                                                class="border" v-model="form.header_html"></codemirror>
                                </x-form-group>
                            </div>
                        </x-panel>

                        <div class="row mb-2 mt-4">
                            <div class="col-12">
                                <div class="h3">
                                    <x-button @click="addSection(form.header_content_fields)" class="float-right"
                                              size="sm">
                                        {{$t('add_section')}}
                                    </x-button>
                                    {{$t('content_fields')}}
                                </div>
                            </div>
                        </div>
                        <div v-for="(section, index) in form.header_content_fields">
                            <field-section :section="section"
                                           @remove="handleSectionRemove(form.header_content_fields, index)"
                                           page="header"/>
                        </div>
                    </div>
                    <div slot="footer">
                        <x-panel>
                            <div slot="title">
                                {{$t('footer')}}
                            </div>
                            <div class="float-right" slot="extra">
                                <x-button @click="toggleTempVar" size="sm">{{$t('variables')}}</x-button>
                            </div>
                            <div>
                                <x-form-group :errors="errors.footer_html" :label="$t('footer_html')">
                                    <codemirror :options="{mode: 'text/html'}"
                                                class="border" v-model="form.footer_html"></codemirror>
                                </x-form-group>
                            </div>
                        </x-panel>
                        <div class="row mb-2 mt-4">
                            <div class="col-12">
                                <div class="h3">
                                    <x-button @click="addSection(form.footer_content_fields)" class="float-right"
                                              size="sm">
                                        {{$t('add_section')}}
                                    </x-button>
                                    {{$t('content_fields')}}
                                </div>
                            </div>
                        </div>
                        <div v-for="(section, index) in form.footer_content_fields">
                            <field-section :section="section"
                                           @remove="handleSectionRemove(form.footer_content_fields, index)"
                                           page="footer"/>
                        </div>
                    </div>
                    <div slot="pages" v-if="form.pages[currentPageIndex]">
                        <x-panel margin>
                            <div slot="title" style="width: 250px;" v-if="isEdit">
                                <input :value="form.pages[currentPageIndex].title" @input="handleTitle"
                                       class="form-control"
                                       type="text">
                            </div>
                            <div slot="title" v-else>
                                <span>{{form.pages[currentPageIndex].title}}</span>
                                <small>({{form.pages[currentPageIndex].name}})</small>
                            </div>
                            <div slot="extra" v-if="!isEdit">
                                <x-button @click="toggleEdit" icon="pencil" size="sm"></x-button>
                                <x-button @click="handleRemove" icon="trash" size="sm"></x-button>
                            </div>
                            <div slot="extra" v-else>
                                <x-button @click="update" size="sm" type="success">{{$t('ok')}}</x-button>
                            </div>
                            <div>
                                <x-row line>
                                    <x-col span="6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{$t('orientation')}}
                                                <small class="form-optional"
                                                       v-if="isEdit">({{$t('optional')}})</small>
                                            </label>
                                            <select class="form-select" v-if="isEdit"
                                                    v-model="form.pages[currentPageIndex].orientation">
                                                <option value="L">Landscape</option>
                                                <option value="P">Portrait</option>
                                            </select>
                                            <p v-else>{{form.pages[currentPageIndex].orientation ==='L' ?
                                                'Landscape' : 'Portrait'}}</p>
                                        </div>
                                    </x-col>
                                    <x-col span="6">
                                        <div class="form-group">
                                            <label class="form-label">{{$t('show_header_and_footer')}}</label>
                                            <x-switch v-if="isEdit"
                                                      v-model="form.pages[currentPageIndex].header_and_footer"></x-switch>
                                            <p v-else>{{form.pages[currentPageIndex].header_and_footer === 1 ?
                                                'Enabled' : 'Disabled'}}</p>
                                        </div>
                                    </x-col>
                                </x-row>
                                <x-row>
                                    <x-col span="12">
                                        <div class="form-group">
                                            <label class="form-label">{{$t('instruction')}}</label>
                                            <textarea class="form-control" v-if="isEdit"
                                                      v-model="form.pages[currentPageIndex].instruction"></textarea>
                                            <pre v-else>{{form.pages[currentPageIndex].instruction}}</pre>
                                        </div>
                                    </x-col>
                                </x-row>
                            </div>
                        </x-panel>
                        <x-panel>
                            <div slot="title">{{$t('page_html')}}</div>
                            <div class="float-right" slot="extra">
                                <x-button @click="toggleTempVar" size="sm">{{$t('variables')}}</x-button>
                            </div>
                            <div>
                                <codemirror :options="{mode: 'text/html'}" class="border"
                                            v-model="form.pages[currentPageIndex].page_html"></codemirror>
                                <div v-if="errors && errors[`pages.${currentPageIndex}.page_html`]">
                                    <small
                                        class="error-input">{{errors[`pages.${currentPageIndex}.page_html`][0]}}</small>
                                </div>
                            </div>
                        </x-panel>
                        <div class="row mb-2 mt-4">
                            <div class="col-12">
                                <div class="h3">
                                    <x-button @click="addSection(form.pages[currentPageIndex].content_fields)"
                                              class="float-right" size="sm">
                                        {{$t('add_section')}}
                                    </x-button>
                                    {{$t('content_fields')}}
                                </div>
                            </div>
                        </div>
                        <div v-for="(section, index) in form.pages[currentPageIndex].content_fields">
                            <field-section :page="`${form.pages[currentPageIndex].name}.${$t('cf')}`"
                                           :section="section"
                                           @remove="handleSectionRemove(form.pages[currentPageIndex].content_fields, index)"/>
                        </div>
                        <div class="row mb-2 mt-4">
                            <div class="col-12">
                                <div class="h3">
                                    <x-button @click="addSection(form.pages[currentPageIndex].user_fields)"
                                              class="float-right" size="sm">
                                        {{$t('add_section')}}
                                    </x-button>
                                    {{$t('user_fields')}}
                                </div>
                            </div>
                        </div>
                        <div v-for="(section, index) in form.pages[currentPageIndex].user_fields">
                            <field-section :page="`${form.pages[currentPageIndex].name}.${$t('uf')}`"
                                           :section="section"
                                           @remove="handleSectionRemove(form.pages[currentPageIndex].user_fields, index)"/>
                        </div>
                    </div>
                </x-simple-tab>
            </div>
        </div>
        <template-variables-modal :form="form" :index="currentPageIndex"
                                  :type="form.type_id" @cancel="toggleTempVar"
                                  v-if="showTempVar"></template-variables-modal>
    </div>
</template>
<script>
    import {snakeCase} from 'lodash'
    import {formable} from '@js/lib/mixins'
    import FieldSection from '@js/partials/FieldSection.vue'
    import shared from '@js/shared'
    import TemplateVariablesModal from '@js/partials/TemplateVariablesModal.vue'
    import Draggable from 'vuedraggable'

    export default {
        mixins: [formable],
        components: {FieldSection, TemplateVariablesModal, Draggable},
        data() {
            return {
                showTempVar: false,
                shared: shared,
                availableTabs: ['settings', 'stylesheet', 'header', 'footer', 'pages'],
                activeTab: 'settings',
                redirect: 'templates',
                currentPageIndex: null,
                doEdit: false,
                form: {
                    pages: [],
                    header_content_fields: [],
                    footer_content_fields: []
                },
                links: [
                    {title: this.$t('general'), to: 'settings'},
                    {title: this.$t('stylesheet'), to: 'stylesheet'},
                    {title: this.$t('header'), to: 'header'},
                    {title: this.$t('footer'), to: 'footer'}
                ],
                opt: {
                    types: [
                        {name: 1, value: this.$t('proposal')},
                        {name: 2, value: this.$t('contract')},
                        {name: 3, value: this.$t('invoice')},
                        {name: 4, value: this.$t('payment')},
                        // {name: 5, value: this.$t('expense')}
                    ],
                    sizes: [
                        {name: 'letter', value: this.$t('letter')},
                        {name: 'legal', value: this.$t('legal')},
                        {name: 'ledger', value: this.$t('ledger')},
                        {name: 'A0', value: this.$t('A0')},
                        {name: 'A1', value: this.$t('A1')},
                        {name: 'A2', value: this.$t('A2')},
                        {name: 'A3', value: this.$t('A3')},
                        {name: 'A4', value: this.$t('A4')}
                    ],
                    orientations: [
                        {name: 'L', value: this.$t('landscape')},
                        {name: 'P', value: this.$t('portrait')}
                    ]
                }
            }
        },
        computed: {
            hasError() {
                return (key) => {
                    if (Object.keys(this.errors).some(function (k) {
                        return ~k.indexOf(key)
                    })) {
                        return true
                    } else {
                        return false
                    }
                }
            },
            isEdit() {
                if (this.form.pages[this.currentPageIndex] && this.form.pages[this.currentPageIndex].edit) {
                    return this.form.pages[this.currentPageIndex].edit
                } else {
                    return this.doEdit
                }
            }
        },
        methods: {
            toggleTempVar() {
                this.showTempVar = !this.showTempVar
            },
            setData(res) {
                this.$set(this.$data, 'form', res.data.form);
                this.$set(this.shared, 'itemVariables', res.data.item_variables);
                this.$set(this.shared, 'template_variables', res.data.template_variables);
                this.show = true;
                this.$bar.finish()
            },
            toggleEdit() {
                this.doEdit = !this.doEdit
            },
            update() {
                this.doEdit = false;
                if (this.form.pages[this.currentPageIndex].edit) {
                    this.$delete(this.form.pages[this.currentPageIndex], 'edit')
                }
            },
            handleTitle(e) {
                const v = e.target.value;
                this.form.pages[this.currentPageIndex].title = v;
                this.form.pages[this.currentPageIndex].name = snakeCase(v)
            },
            handleRemove(e) {
                const r = confirm(this.$t('are_you_sure'));
                if (r != true) {
                    return
                }

                const dIndex = this.currentPageIndex;

                // last page
                if (dIndex === this.form.pages.length - 1) {
                    this.currentPageIndex = dIndex - 1
                }

                // only one page
                if (this.form.pages.length === 1) {
                    this.openTab('settings');
                    this.currentPageIndex = 0
                }

                this.form.pages.splice(dIndex, 1)
            },
            handleAddPage() {
                const nextIndex = this.form.pages.length;
                const t = this.$t('new_page');
                const newPage = {
                    edit: true,
                    name: `${snakeCase(t)}${nextIndex}`,
                    title: `${t} ${nextIndex}`,
                    index: nextIndex,
                    orientation: this.form.orientation,
                    page_html: '',
                    header_and_footer: 1,
                    content_fields: [
                        {title: 'Default', name: 'default', fields: []}
                    ],
                    user_fields: [
                        {title: 'Default', name: 'default', fields: []}
                    ]
                };


                this.form.pages.push(newPage);
                this.openPage(this.form.pages[nextIndex], nextIndex)
            },
            handleSectionRemove(target, index) {
                target.splice(index, 1)
            },
            openTab(name) {
                this.activeTab = name;
                this.$nextTick(() => {
                    this.$refs.content.scrollTop = 1
                })
            },
            addSection(target) {
                const nextIndex = target.length;
                const title = `${this.$t('new_section')} ${nextIndex}`;
                const section = {
                    name: snakeCase(title),
                    title: title,
                    fields: [],
                    edit: true
                };

                target.push(section);
                this.$nextTick(() => {
                    const h2 = this.$refs.content.scrollHeight;
                    this.$refs.content.scrollTop = h2
                })
            },
            removeSection(target, index) {
                target.splice(index, 1)
            },
            openPage(page, index) {
                this.currentPageIndex = index;
                // this.currentPage = page
                this.openTab('pages')
            },
            saveTemplate() {
                this.isSaving = true;
                this.errors = {};

                const {url, method} = this.getForm();

                this.$http[method](url, this.form)
                    .then((res) => {
                        if (method == 'post') {
                            this.$router.push(`/${this.redirect}/${res.data.id}/edit`)
                        }
                        this.$message.success(this.$t('saved_success'))
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.openTab('settings');
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
                    })
                    .finally(() => {
                        this.isSaving = false
                    })
            }
        }
    }
</script>
