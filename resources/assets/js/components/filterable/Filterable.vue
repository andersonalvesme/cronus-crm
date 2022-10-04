<template>
    <div class="filterable">
        <x-panel>
            <div class="h2 mb-0" slot="title">
                {{$t(title)}}
            </div>

            <div slot="extra">
                <slot name="extra"></slot>
                <exportable :applied-filters="appliedFilters" :disabled="loading"
                            :query="query" :resource="url" :total="collection.total"
                            class="float-right mr-2" v-if="exportable"></exportable>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="input-group">
                        <input class="form-control" placeholder="Pesquisar..." type="search">
                        <button @click="toggleFilter()" class="btn btn-white btn-icon"
                                type="button" v-bind:class="{'active': showAdvancedFilter}">
                            <svg class="icon icon-tabler icon-tabler-filter" fill="none"
                                 height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2"
                                 viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                <path
                                    d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-9">
                    <div class="input-group ml-auto" style="width: fit-content">
                        <span class="input-group-text">
                          {{$t('order_by')}}
                        </span>
                        <select :disabled="loading"
                                @input="handleColumnSort" class="form-select" v-model="query.sort_column">
                            <option :value="column.name" v-for="column in getSortable">
                                {{column.value}}
                            </option>
                        </select>
                        <button @click="onDirectionSort" class="btn btn-white btn-icon filterable-direction"
                                type="button">
                            <svg class="icon icon-tabler icon-tabler-sort-descending" fill="none"
                                 height="24" stroke="currentColor" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" v-if="query.sort_direction === 'desc'"
                                 viewBox="0 0 24 24"
                                 width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                <line x1="4" x2="13" y1="6" y2="6"></line>
                                <line x1="4" x2="11" y1="12" y2="12"></line>
                                <line x1="4" x2="11" y1="18" y2="18"></line>
                                <polyline points="15 15 18 18 21 15"></polyline>
                                <line x1="18" x2="18" y1="6" y2="18"></line>
                            </svg>
                            <svg class="icon icon-tabler icon-tabler-sort-ascending" fill="none"
                                 height="24" stroke="currentColor" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" v-else viewBox="0 0 24 24"
                                 width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                <line x1="4" x2="11" y1="6" y2="6"></line>
                                <line x1="4" x2="11" y1="12" y2="12"></line>
                                <line x1="4" x2="13" y1="18" y2="18"></line>
                                <polyline points="15 9 18 6 21 9"></polyline>
                                <line x1="18" x2="18" y1="6" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mt-2" v-if="showAdvancedFilter">
                <div class="card-status-left bg-primary"></div>
                <div class="card-body">
                    <h3 class="card-title">Filtros avançados</h3>
                    <small>Exibir {{ $t(title) }} que combine com</small>
                    <select class="form-select form-select-sm d-inline" style="width: fit-content"
                            v-model="query.filter_match">
                        <option value="and">{{$t('all')}}</option>
                        <option value="or">{{$t('any')}}</option>
                    </select>
                    <small><span v-if="query.filter_match === 'or'">um d</span>os filtros abaixo</small>

                    <div class="mt-3">
                        <div class="filters">
                            <div class="row mt-1" v-for="(f, i) in filterCandidates">
                                <div class="col-3 pr-1">
                                    <select @input="onColumnSelect(f, i, $event)" class="form-select">
                                        <option value="">{{$t('select_a_filter')}}</option>
                                        <optgroup :label="group.title" v-for="group in filterGroups">
                                            <option :selected="f.column && x.name === f.column.name"
                                                    :value="JSON.stringify(x)"
                                                    v-for="x in group.filters">
                                                {{x.title}}
                                            </option>
                                        </optgroup>
                                    </select>
                                    <small class="invalid-feedback" v-if="errors[`f.${i}.column`]">
                                        {{errors[`f.${i}.column`][0]}}
                                    </small>
                                </div>
                                <div class="col-2 pr-1 pl-1" v-if="f.column">
                                    <select @input="onOperatorSelect(f, i, $event)" class="form-select">
                                        <option :selected="f.operator && y.name === f.operator.name"
                                                :value="JSON.stringify(y)"
                                                v-for="y in fetchOperators(f)">
                                            {{$t(y.name)}}
                                        </option>
                                    </select>
                                    <small class="invalid-feedback" v-if="errors[`f.${i}.operator`]">
                                        {{errors[`f.${i}.operator`][0]}}
                                    </small>
                                </div>

                                <template v-if="f.column && f.operator">
                                    <div class="col pr-1 pl-1">
                                        <div class="filters-full col" v-if="f.operator.component === 'single'">
                                            <input :placeholder="f.placeholder" class="form-control"
                                                   type="text" v-model="f.query_1">
                                            <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                {{errors[`f.${i}.query_1`][0]}}
                                            </small>
                                        </div>

                                        <div class="filters-full col" v-if="f.operator.component === 'lookup'">
                                            <x-tag-input :column="f.column.column || f.column.name"
                                                         :name="f.column.column || f.column.name"
                                                         :resource="f.column.resource" :small="true"
                                                         :value="f.query_1" @input="value => { f.query_1 = value }"
                                                         multiple>
                                            </x-tag-input>
                                            <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                {{errors[`f.${i}.query_1`][0]}}
                                            </small>
                                        </div>

                                        <div class="filters-full col" v-if="f.operator.component === 'static_lookup'">
                                            <x-select :options="setOptions(f.column.options)" :value="f.query_1"
                                                      @input="value => { f.query_1 = value }" multiple></x-select>
                                            <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                {{errors[`f.${i}.query_1`][0]}}
                                            </small>
                                        </div>
                                        <template v-else-if="f.operator.component === 'dual'">
                                            <div class="row">
                                                <div class="filters-query_1 col pr-0">
                                                    <input :placeholder="f.placeholder"
                                                           class="form-control"
                                                           type="number" v-model="f.query_1">
                                                    <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                        {{errors[`f.${i}.query_1`][0]}}
                                                    </small>
                                                </div>
                                                <div class="filters-query_2 col pl-0">
                                                    <input :placeholder="f.placeholder"
                                                           class="form-control"
                                                           type="number" v-model="f.query_2">
                                                    <small class="invalid-feedback" v-if="errors[`f.${i}.query_2`]">
                                                        {{errors[`f.${i}.query_2`][0]}}
                                                    </small>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'datetime_1'">
                                            <div class="row">
                                                <div class="filters-query_1 col pr-0">
                                                    <input :placeholder="f.placeholder" class="form-control"
                                                           type="number"
                                                           v-model="f.query_1">
                                                    <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                        {{errors[`f.${i}.query_1`][0]}}
                                                    </small>
                                                </div>
                                                <div class="filters-query_2 col pl-0">
                                                    <select class="form-select" v-model="f.query_2">
                                                        <option value="hours">{{$t('hours')}}</option>
                                                        <option value="days">{{$t('days')}}</option>
                                                        <option value="months">{{$t('months')}}</option>
                                                        <option value="years">{{$t('years')}}</option>
                                                    </select>
                                                    <small class="invalid-feedback" v-if="errors[`f.${i}.query_2`]">
                                                        {{errors[`f.${i}.query_2`][0]}}
                                                    </small>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'datetime_2'">
                                            <div class="filters-query_2 col">
                                                <select class="form-select" v-model="f.query_1">
                                                    <option value="yesterday">{{$t('yesterday')}}</option>
                                                    <option value="today">{{$t('today')}}</option>
                                                    <option value="tomorrow">{{$t('tomorrow')}}</option>
                                                    <option value="last_month">{{$t('last_month')}}</option>
                                                    <option value="this_month">{{$t('this_month')}}</option>
                                                    <option value="next_month">{{$t('next_month')}}</option>
                                                    <option value="last_year">{{$t('last_year')}}</option>
                                                    <option value="this_year">{{$t('this_year')}}</option>
                                                    <option value="next_year">{{$t('next_year')}}</option>
                                                </select>
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                    {{errors[`f.${i}.query_1`][0]}}
                                                </small>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'datetime_3'">
                                            <div class="filters-query_1 col">
                                                <input :placeholder="f.placeholder" class="form-control" type="date"
                                                       v-model="f.query_1">
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                    {{errors[`f.${i}.query_1`][0]}}
                                                </small>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'datetime_4'">
                                            <div class="filters-query_1 col">
                                                <input :placeholder="f.placeholder" class="form-control" type="number"
                                                       v-model="f.query_1">
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                    {{errors[`f.${i}.query_1`][0]}}
                                                </small>
                                            </div>
                                            <div class="filters-query_2 col">
                                                <select class="form-select" v-model="f.query_2">
                                                    <option value="hours">{{$t('hours')}} {{$t('ago')}}</option>
                                                    <option value="days">{{$t('days')}} {{$t('ago')}}</option>
                                                    <option value="months">{{$t('months')}} {{$t('ago')}}</option>
                                                    <option value="years">{{$t('years')}} {{$t('ago')}}</option>
                                                </select>
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_2`]">
                                                    {{errors[`f.${i}.query_2`][0]}}
                                                </small>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'datetime_5'">
                                            <div class="filters-query_1 col">
                                                <input :placeholder="f.placeholder" class="form-control" type="date"
                                                       v-model="f.query_1">
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                    {{errors[`f.${i}.query_1`][0]}}
                                                </small>
                                            </div>
                                            <div class="filters-query_2 col">
                                                <input :placeholder="f.placeholder" class="form-control" type="date"
                                                       v-model="f.query_2">
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_2`]">
                                                    {{errors[`f.${i}.query_2`][0]}}
                                                </small>
                                            </div>
                                        </template>
                                        <template v-else-if="f.operator.component === 'toggle'">
                                            <div class="filters-query_1 col">
                                                <div class="filter-toggle">
                                                    <x-switch v-model="f.query_1"></x-switch>
                                                </div>
                                                <small class="invalid-feedback" v-if="errors[`f.${i}.query_1`]">
                                                    {{errors[`f.${i}.query_1`][0]}}
                                                </small>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <div class="filters-remove-wrap col-auto pl-1" v-if="f">
                                    <a :disabled="loading" @click="removeFilter(f, i)"
                                       class="text-danger filters-remove" href="javascript:void(0)">
                                        <svg class="icon icon-tabler icon-tabler-trash"
                                             fill="none" height="24" stroke="currentColor"
                                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             viewBox="0 0 24 24"
                                             width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                            <line x1="4" x2="20" y1="7" y2="7"></line>
                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3" v-if="appliedFilters.length || showFilterControls">
                            <div class="w-auto pr-1">
                                <x-button :disabled="loading" @click="addFilter" size="sm">
                                    <svg class="icon icon-tabler icon-tabler-plus" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2"
                                         viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <line x1="12" x2="12" y1="5" y2="19"></line>
                                        <line x1="5" x2="19" y1="12" y2="12"></line>
                                    </svg>
                                    Adicionar
                                </x-button>
                            </div>
                            <div class="w-auto pr-1 pl-1" v-if="appliedFilters.length">
                                <div class="filters-control-item-line"></div>
                                <x-button :disabled="loading" @click="resetFilter" size="sm">
                                    <svg class="icon icon-tabler icon-tabler-refresh" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                    </svg>
                                    Limpar
                                </x-button>
                            </div>
                            <div class="w-auto pl-1">
                                <div class="filters-control-item-line"></div>
                                <x-button :disabled="loading" @click="applyFilter" size="sm" type="primary">
                                    <svg class="icon icon-tabler icon-tabler-search" fill="none"
                                         height="24" stroke="currentColor" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none"></path>
                                        <circle cx="10" cy="10" r="7"></circle>
                                        <line x1="21" x2="15" y1="21" y2="15"></line>
                                    </svg>
                                    Filtrar
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" slot="table">
                <x-table class="table table-vcenter table-hover border-top m-0">
                    <thead>
                    <slot name="heading"></slot>
                    </thead>
                    <x-tbody v-if="collection.data && collection.data.length">
                        <slot :item="item" v-for="item in collection.data"></slot>
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
                        <option :selected="query.limit === 10" value="10">10</option>
                        <option :selected="query.limit === 15" value="15">15</option>
                        <option :selected="query.limit === 25" value="25">25</option>
                        <option :selected="query.limit === 50" value="50">50</option>
                        <option :selected="query.limit === 100" value="100">100</option>
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
    </div>
</template>
<script>
    import Exportable from '../exportable/Exportable.vue'

    export default {
        components: {Exportable},
        name: 'XFilterable',
        props: {
            title: String,
            url: String,
            sortable: Array,
            filterGroup: Array,
            exportable: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                loading: true,
                showAdvancedFilter: false,
                collection: {
                    data: []
                },
                errors: {},
                query: {
                    sort_column: 'created_at',
                    sort_direction: 'desc',
                    filter_match: 'and',
                    limit: 10,
                    page: 1
                },
                filterCandidates: [],
                appliedFilters: []
            }
        },
        mounted() {
            this.addFilter()
        },
        computed: {
            setOptions() {
                return (items) => {
                    return items.map((item) => {
                        return {name: item, value: this.$t(item)}
                    })
                }
            },
            showFilterReset() {
                return this.appliedFilters.length > 0
            },
            showFilterControls() {
                if (this.filterCandidates.length === 0) return true;
                const active = this.filterCandidates.filter((f) => {
                    if (f.column && f.column.name) {
                        return f
                    }
                });

                return active.length > 0
            },
            getSortable() {
                const x = this.sortable.map((item) => {
                    if (typeof item === 'object') {
                        return item
                    }
                    return {name: item, value: this.$t(item)}
                });

                return x
            },
            filterGroups() {
                const x = this.filterGroup.map((item) => {
                    const i = item.filters.map((y) => {
                        if (typeof y.title === 'undefined') {
                            y.title = this.$t(y.name);
                            return y
                        }
                        return y
                    });
                    item.filters = i;
                    return item
                });

                return x
            },
            fetchOperators() {
                return (f) => {
                    return this.availableOperator().filter((operator) => {
                        if (f.column && operator.parent.includes(f.column.type)) {
                            return operator
                        }
                    })
                }
            }
        },
        methods: {
            toggleFilter() {
                if (this.showAdvancedFilter) {
                    this.resetFilter();
                }

                this.showAdvancedFilter = !this.showAdvancedFilter;
            },
            resetFilter() {
                this.$set(this.$data, 'appliedFilters', []);
                this.filterCandidates.splice(0);
                this.addFilter();
                this.query.page = 1;
                this.fetch()
            },
            applyFilter() {
                this.$set(this.$data, 'appliedFilters',
                    JSON.parse(JSON.stringify(this.filterCandidates))
                );
                this.query.page = 1;
                this.fetch()
            },
            onColumnSelect(f, i, e) {
                const value = event.target.value;
                if (value.length === 0) {
                    this.$set(this.filterCandidates[i], 'column', value);
                    return
                }
                const obj = JSON.parse(value);
                this.$set(this.filterCandidates[i], 'column', obj);

                switch (obj.type) {
                    case 'numeric':
                        this.filterCandidates[i].operator = this.availableOperator()[6];
                        this.filterCandidates[i].query_1 = null;
                        this.filterCandidates[i].query_2 = null;
                        break;
                    case 'lookup':
                    case 'lookup_only':
                        this.filterCandidates[i].operator = this.availableOperator()[11];
                        this.filterCandidates[i].query_1 = [];
                        this.filterCandidates[i].query_2 = null;
                        break;

                    case 'static_lookup':
                        this.filterCandidates[i].operator = this.availableOperator()[21];
                        this.filterCandidates[i].query_1 = [];
                        this.filterCandidates[i].query_2 = null;
                        break;
                    case 'string':
                        this.filterCandidates[i].operator = this.availableOperator()[8];
                        this.filterCandidates[i].query_1 = [];
                        this.filterCandidates[i].query_2 = null;
                        break;
                    case 'toggle':
                        this.filterCandidates[i].operator = this.availableOperator()[23];
                        this.filterCandidates[i].query_1 = 1;
                        this.filterCandidates[i].query_2 = null;
                        break;
                    case 'datetime':
                        this.filterCandidates[i].operator = this.availableOperator()[13];
                        this.filterCandidates[i].query_1 = 28;
                        this.filterCandidates[i].query_2 = 'days';
                        break;
                }
            },
            onOperatorSelect(f, i, e) {
                // console.log('operator change')
                const value = event.target.value;
                if (value.length === 0) {
                    this.$set(this.filterCandidates[i], 'operator', value);
                    return
                }

                const obj = JSON.parse(value);
                this.$set(this.filterCandidates[i], 'operator', obj);

                this.filterCandidates[i].query_1 = null;
                this.filterCandidates[i].query_2 = null;
                // set default values for query_1 and q2
                switch (obj.name) {
                    case 'includes':
                    case 'not_includes':
                        this.filterCandidates[i].query_1 = [];
                        this.filterCandidates[i].query_2 = null;
                        break;
                    case 'in_the_past':
                    case 'in_the_next':
                    case 'over':
                        this.filterCandidates[i].query_1 = 28;
                        this.filterCandidates[i].query_2 = 'days';
                        break;
                    case 'in_the_peroid':
                        this.filterCandidates[i].query_1 = 'today';
                        break;
                    case 'toggle':
                        this.filterCandidates[i].query_1 = 1;
                        break;
                }
            },
            addFilter() {
                this.filterCandidates.push({
                    column: '',
                    operator: '',
                    query_1: null,
                    query_2: null,
                    placeholder: ''
                })
            },
            removeFilter(f, i) {
                this.filterCandidates.splice(i, 1)
            },
            getQuery() {
                const f = {};

                this.appliedFilters.forEach((filter, i) => {
                    f[`f[${i}][column]`] = filter.column.name;
                    f[`f[${i}][operator]`] = filter.operator.name;

                    if (filter.query_1 && Array.isArray(filter.query_1)) {
                        const list = filter.query_1.map((item) => {
                            return item.value
                        });

                        f[`f[${i}][query_1]`] = list.join(',,')
                    } else {
                        f[`f[${i}][query_1]`] = filter.query_1
                    }

                    f[`f[${i}][query_2]`] = filter.query_2
                });

                let params = {
                    ...this.query,
                    ...f
                };

                return params
            },
            fetch() {
                this.loading = true;
                this.errors = {};

                const params = this.getQuery();

                this.$http.get(`/api/${this.url}`, {params: params})
                    .then((res) => {
                        this.setData(res)
                    })
                    .catch((error) => {
                        this.$bar.finish();
                        this.loading = false;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        }
                        this.$message.error(error.response.data.message)
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
            handleColumnSort(event) {
                this.query.sort_column = event.target.value;
                this.query.sort_direction = 'asc';
                this.fetch()
            },
            onDirectionSort() {
                // hack
                if (this.loading) return;

                if (this.query.sort_direction === 'desc') {
                    this.query.sort_direction = 'asc'
                } else {
                    this.query.sort_direction = 'desc'
                }
                this.fetch()
            },
            availableOperator() {
                return [
                    {name: 'equal_to', parent: ['numeric', 'string'], component: 'single'},
                    {name: 'not_equal_to', parent: ['numeric', 'string'], component: 'single'},
                    {name: 'less_than', parent: ['numeric'], component: 'single'},
                    {name: 'greater_than', parent: ['numeric'], component: 'single'},
                    {name: 'less_than_or_equal_to', parent: ['numeric'], component: 'single'},
                    {name: 'greater_than_or_equal_to', parent: ['numeric'], component: 'single'},
                    {name: 'between', parent: ['numeric'], component: 'dual'},
                    {name: 'not_between', parent: ['numeric'], component: 'dual'},
                    {name: 'contains', parent: ['string', 'lookup'], component: 'single'},
                    {name: 'starts_with', parent: ['string', 'lookup'], component: 'single'},
                    {name: 'ends_with', parent: ['string', 'lookup'], component: 'single'},

                    {name: 'includes', parent: ['lookup', 'lookup_only'], component: 'lookup'},
                    {name: 'not_includes', parent: ['lookup', 'lookup_only'], component: 'lookup'},
                    {name: 'in_the_past', parent: ['datetime'], component: 'datetime_1'},
                    {name: 'in_the_next', parent: ['datetime'], component: 'datetime_1'},
                    {name: 'over', parent: ['datetime'], component: 'datetime_4'}, // same as in_the_past
                    {name: 'between_date', parent: ['datetime'], component: 'datetime_5'},
                    {name: 'in_the_peroid', parent: ['datetime'], component: 'datetime_2'},
                    {name: 'equal_to_date', parent: ['datetime'], component: 'datetime_3'},
                    {name: 'is_empty', parent: ['date', 'numeric', 'string', 'datetime', 'lookup'], component: 'none'},
                    {
                        name: 'is_not_empty',
                        parent: ['date', 'numeric', 'string', 'datetime', 'lookup'],
                        component: 'none'
                    },
                    {name: 'includes', parent: ['static_lookup'], component: 'static_lookup'},
                    {name: 'not_includes', parent: ['static_lookup'], component: 'static_lookup'},
                    {name: 'toggle', parent: ['toggle'], component: 'toggle'},
                ]
            }
        }
    }
</script>
