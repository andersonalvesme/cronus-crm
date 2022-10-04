<template>
    <div class="select-form">
        <div :disabled="disabled" :tabindex="disabled ? -1 : tabindex" @click="toggle"
             @keydown.down.prevent="onKeydownMain" class="form-select" ref="toggle">
            <svg @click="remove" class="icon float-right text-muted" fill="none" height="24"
                 stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 style="cursor: pointer; padding-top: 3px;" v-if="removable && value && value.id"
                 viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" stroke="none"></path>
                <line x1="18" x2="6" y1="6" y2="18"></line>
                <line x1="6" x2="18" y1="6" y2="18"></line>
            </svg>
            <div class="select-text">
                {{selectVal}}
            </div>
        </div>
        <div class="select-dropdown" v-if="showDropdown">
            <input :value="search" @blur="onBlur" @input="onSearch" @keydown.down.prevent="onDownKey"
                   @keydown.enter="onEnter"
                   @keydown.esc="onBlur" @keydown.up.prevent="onUpKey"
                   class="form-control" placeholder="Pesquisar..."
                   ref="search" type="text">
            <div class="selectize-dropdown single form-select mt-0" ref="items">
                <table class="selectize-dropdown-content w-100">
                    <thead>
                    <tr>
                        <th class="option" v-for="col in columns">{{$t(col)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr :class="[selectIndex === i ? 'active':'']"
                        @mousedown.prevent="select(option)"
                        @mouseover.prevent="onMouse(i)"
                        v-for="(option, i) in availableOptions">
                        <td class="option" v-for="col in columns">{{option[col] | trim}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import {debounce} from 'lodash'

    export default {
        name: 'XTypeaheadTable',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            url: String,
            columns: {
                type: Array,
                default() {
                    return []
                }
            },
            name: String,
            tabindex: {
                default: 0
            },
            value: [Object, Array, String],
            disabled: {
                default: false,
                type: Boolean
            },
            removable: {
                default: false,
                type: Boolean
            },
            params: {
                type: [Object, Array],
                default() {
                    return {}
                }
            }
        },
        data() {
            return {
                isLoading: false,
                showDropdown: false,
                selectIndex: -1,
                search: '',
                options: []
            }
        },
        computed: {
            selectVal() {
                if (this.value) {
                    if (typeof this.value === 'string') {
                        return this.value
                    } else if (this.value.id) {
                        return this.value[this.name]
                    }
                }

                return this.$t('select')
            },
            availableOptions() {
                return this.options
            }
        },
        methods: {
            remove() {
                const payload = {
                    id: null
                };
                this.$emit('input', payload)
            },
            onSearch(e) {
                this.search = event.target.value;
                // xhr
                this.fetch(this.search)

            },
            fetch: debounce(function (q) {
                this.isLoading = true;
                this.$http.get(`/api/typeahead/${this.url}`, {
                    params: {
                        query: q,
                        ...this.params
                    }
                })
                    .then((res) => {
                        if (res.data) {
                            this.$set(this.$data, 'options', res.data.results)
                        }
                        this.isLoading = false
                    })
            }, 300),
            onUpKey(e) {
                if (this.disabled) return;
                if (this.selectIndex > 0) {
                    this.selectIndex--;
                    if (this.selectIndex > 4) {
                        this.$nextTick(() => {
                            // todo: algo to find best scroll position
                            this.$refs.items.scrollTop -= 28
                        })
                    }
                } else {
                    this.selectIndex = this.options.length - 1;
                    this.$nextTick(() => {
                        this.$refs.items.scrollTop = this.selectIndex * 28
                    })
                }
            },
            onDownKey(e) {
                if (this.disabled) return;
                if (!this.showDropdown) {
                    this.open()
                }
                if (this.options.length - 1 > this.selectIndex) {
                    this.selectIndex++;
                    if (this.selectIndex > 4) {
                        this.$nextTick(() => {
                            this.$refs.items.scrollTop += 28
                        })
                    }
                } else {
                    this.selectIndex = 0;
                    this.$nextTick(() => {
                        this.$refs.items.scrollTop = 0
                    })
                }

            },
            onKeydownMain(e) {
                this.open()
            },
            select(option) {
                if (this.multiple) {
                    const payload = this.value;
                    payload.push(option);
                    this.$emit('input', payload)
                } else {
                    this.$emit('input', option)
                }
                this.close()
            },
            onEnter() {
                if (this.disabled) return;
                if (this.selectIndex < 0) return;
                const option = this.options[this.selectIndex];
                this.select(option)
            },
            onBlur() {
                this.close()
            },
            onMouse(index) {
                this.selectIndex = index
            },
            close() {
                this.showDropdown = false;
                this.selectIndex = -1;
                this.search = ''
            },
            open() {
                this.showDropdown = true;
                this.$nextTick(() => {
                    // cannot used key from parent due to macrotask in vue,
                    // will be microtask in 2.6
                    this.$refs.search.focus();
                    if (!this.options.length) {
                        this.fetch()
                    }
                })
            },
            toggle() {
                if (this.disabled) return;
                if (this.showDropdown) {
                    this.close()
                } else {
                    this.open()
                }
            },
        }
    }
</script>
