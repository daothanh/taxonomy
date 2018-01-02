<template>
    <div class="div">
        <div class="content-header">
            <h1 v-if="vocabularyData !== ''">
                {{ vocabularyData.translations.name }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/backend">Home</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.vocabulary.index'}">{{ trans('vocabularies.title.vocabularies') }}</el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.term.index'}" v-if="vocabularyData !== ''">{{ vocabularyData.translations.name }}</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="sc-table">
                            <div class="tool-bar el-row" style="padding-bottom: 20px;">
                                <div class="actions el-col el-col-8">
                                    <el-dropdown @command="handleExtraActions" v-if="showExtraButtons">
                                        <el-button type="primary">
                                            {{ trans('core.table.actions') }}<i class="el-icon-caret-bottom el-icon--right"></i>
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-dropdown-item command="mark-online">{{ trans('core.mark as online') }}</el-dropdown-item>
                                            <el-dropdown-item command="mark-offline">{{ trans('core.mark as offline') }}</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                    <router-link :to="{name: 'admin.taxonomy.term.create', params: {vocabulary: vocabulary}}">
                                        <el-button type="primary"><i class="el-icon-edit"></i>
                                            {{ trans('terms.title.create term') }}
                                        </el-button>
                                    </router-link>
                                </div>
                            </div>

                            <el-table
                                    :data="data"
                                    stripe
                                    style="width: 100%"
                                    ref="termTable"
                                    v-loading.body="tableIsLoading"
                                    @sort-change="handleSortChange"
                                    @selection-change="handleSelectionChange">
                                <el-table-column
                                        type="selection"
                                        width="55">
                                </el-table-column>
                                <el-table-column prop="featured_image" :label="trans('terms.table.featured image')">
                                    <template slot-scope="scope">
                                        <a @click.prevent="goToEdit(scope)" href="#" v-if="scope.row.featured_image">
                                            <img :src="scope.row.featured_image" :alt="scope.row.translations.name" width="50"
                                                 height="auto">
                                        </a>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="translations.name" :label="trans('terms.table.name')">
                                    <template slot-scope="scope">
                                        <a @click.prevent="goToEdit(scope)" href="#">
                                            {{  scope.row.translations.name }}
                                        </a>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="pos" :label="trans('terms.table.description')">
                                    <template slot-scope="scope">
                                            <span v-html="scope.row.description"></span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="translations.slug" :label="trans('terms.table.slug')">
                                    <template slot-scope="scope">
                                            {{  scope.row.translations.slug }}
                                    </template>
                                </el-table-column>
                                <el-table-column :label="trans('terms.table.status')" width="100">
                                    <template slot-scope="scope">
                                        <i class="fa fa-circle" :class="(scope.row.status === 1) ? 'text-success':'text-danger'"></i>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="actions" :label="trans('core.table.actions')">
                                    <template slot-scope="scope">
                                        <el-button-group>
                                            
                                            <edit-button :to="{ name: 'admin.taxonomy.term.edit', params: { term: scope.row.id } }"></edit-button>
                                            <delete-button :scope="scope" :rows="data"></delete-button>
                                        </el-button-group>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button v-shortkey="['c']" @shortkey="pushRoute({name: 'admin.taxonomy.term.create', params: {vocabulary: vocabulary}})" v-show="false"></button>
        <button v-shortkey="['b']" @shortkey="pushRoute({name: 'admin.taxonomy.vocabulary.index'})" v-show="false"></button>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    import ShortcutHelper from '../../../../Core/Assets/js/mixins/ShortcutHelper';

    let data;

    export default {
        mixins: [ShortcutHelper],
        data() {
            return {
                data,
                meta: {
                    current_page: 1,
                    per_page: 10,
                    total: 0,
                },
                order_meta: {
                    order_by: '',
                    order: '',
                },
                links: {},
                searchQuery: '',
                tableIsLoading: false,
                selectedPages: {},
                showExtraButtons: false,
                vocabulary: this.$route.params.vocabulary,
                vocabularyData: ''
            };
        },
        watch: {
            selectedPages() {
                this.showExtraButtons = this.selectedPages.length >= 1;
            },
        },
        methods: {
            queryServer(customProperties) {
                const properties = {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    search: this.searchQuery,
                    vocabulary: this.vocabulary,
                };

                axios.get(route('api.taxonomy.term.index', _.merge(properties, customProperties)))
                    .then((response) => {
                        this.tableIsLoading = false;
                        this.data = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;

                        this.order_meta.order_by = properties.order_by;
                        this.order_meta.order = properties.order;
                    });
            },
            fetchData() {
                this.tableIsLoading = true;
                this.queryServer();
            },
            fetchVocabulary() {
                this.loading = true;
                axios.get(route('api.taxonomy.vocabulary.get', { vocabulary: this.$route.params.vocabulary }))
                    .then((response) => {
                        this.loading = false;
                        this.vocabularyData = response.data.data;
                    });
            },
            handleSizeChange(event) {
                console.log(`per term :${event}`);
                this.tableIsLoading = true;
                this.queryServer({ per_term: event });
            },
            handleCurrentChange(event) {
                console.log(`current term :${event}`);
                this.tableIsLoading = true;
                this.queryServer({ term: event });
            },
            handleSortChange(event) {
                console.log('sorting', event);
                this.tableIsLoading = true;
                this.queryServer({ order_by: event.prop, order: event.order });
            },
            performSearch(query) {
                console.log(`searching:${query.target.value}`);
                this.tableIsLoading = true;
                this.queryServer({ search: query.target.value });
            },
            handleExtraActions(action) {
                const termIds = _.map(this.selectedPages, elem => elem.id);
                axios.get(route('api.taxonomy.term.mark-status', { action, termIds: JSON.stringify(termIds) }))
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: response.data.message,
                        });
                        this.$refs.termTable.clearSelection();
                        this.data.filter(term => termIds.indexOf(term.id) >= 0)
                            .map((t) => {
                                const term = t;
                                term.status = action === 'mark-online' ? 1 : 0;
                                return term;
                            });
                    })
                    .catch(() => {
                        this.$message({
                            type: 'error',
                            message: this.trans('core.something went wrong'),
                        });
                    });
            },
            handleSelectionChange(selectedPages) {
                this.selectedPages = selectedPages;
            },
            goToEdit(scope) {
                this.$router.push({ name: 'admin.taxonomy.term.edit', params: { term: scope.row.id } });
            },
        },
        mounted() {
            if (this.$route.params.vocabulary !== undefined) {
                this.fetchVocabulary();
            }
            this.fetchData();
        },
    };
</script>
<style>
    .text-success {
        color: #13ce66;
    }
    .text-danger {
        color: #ff4949;
    }
</style>
