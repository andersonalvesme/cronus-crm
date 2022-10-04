<template>
    <div class="select-form">
        <div :disabled="disabled" :tabindex="disabled ? -1 : tabindex" @click="toggle"
             @keydown.down.prevent="onKeydownMain"
             class="form-select" ref="toggle" v-bind:class="{'form-select-sm': small}">
            <div class="select-text" v-if="multiple">
                <div class="select-tags" v-if="value.length">
                    <div class="tag tag-primary" v-for="(x, i) in value">
            <span class="tag-text">
              {{x[name]}}
            </span>
                        <span @mousedown.prevent="remove(x, i)" class="icon icon-close tag-close"></span>
                    </div>
                </div>
                <div v-else>{{$t('type_or_select')}}</div>
            </div>
            <div class="select-text" v-else>
                {{value && value[name] ? value[name] : ''}}
            </div>
            <span @click="removeVal" class="select-remove icon icon-trash-a"
                  v-if="removable && value && value.id"></span>
            <span :class="[`select-icon icon icon-arrow-${showDropdown ? 'up-b' : 'down-b'}`]" v-else></span>
        </div>
        <div class="select-dropdown" v-if="showDropdown">
            <input @blur="onBlur" @input="onSearch" @keydown.down.prevent="onDownKey" @keydown.enter="onEnter"
                   @keydown.esc="onBlur" @keydown.up.prevent="onUpKey"
                   class="form-control" placeholder="Pesquisar..."
                   ref="search" type="text">
            <div class="selectize-dropdown single form-select mt-0">
                <div class="selectize-dropdown-content" ref="items">
                    <div :class="['option', selectIndex === i ? 'active':'']"
                         @mousedown.prevent="select(option)"
                         @mouseover.prevent="onMouse(i)"
                         v-for="(option, i) in availableOptions">
                        <span>{{option[name]}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {debounce} from 'lodash'

    export default {
        name: 'XTagInput',
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            resource: String,
            column: String,
            tabindex: {
                default: 0
            },
            value: [Object, Array],
            small: {
                default: false,
                type: Boolean
            },
            disabled: {
                default: false,
                type: Boolean
            },
            multiple: {
                default: false,
                type: Boolean
            },
            removable: {
                default: false,
                type: Boolean
            },
            name: {
                default: 'value'
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
            availableOptions() {
                return this.options
            }
        },
        methods: {
            removeVal() {
                const payload = {
                    id: null
                };
                this.$emit('input', payload)
            },
            remove(x, i) {
                const payload = this.value;
                payload.splice(i, 1);
                this.$emit('input', payload)
            },
            onSearch(e) {
                this.search = event.target.value;
                // xhr
                this.fetch(this.search)
            },
            fetch: debounce(function (q) {
                this.isLoading = true;
                this.$http.get(`/api/search/${this.resource}`, {
                    params: {
                        query: q,
                        column: this.column,
                        ...this.params
                    }
                })
                    .then((res) => {
                        if (res.data) {
                            this.$set(this.$data, 'options', res.data.collection)
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
                this.search = '';
                this.options = []
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
