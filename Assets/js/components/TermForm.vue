<template>
    <div class="div">
        <div class="content-header">
            <h1>
                {{ trans(`terms.${pageTitle}`) }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/backend">Home</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.term.index'}">{{ trans('terms.title.terms') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.term.create'}">{{ trans(`terms.${pageTitle}`) }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form ref="form" :model="term" label-width="120px" label-position="top"
                 v-loading.body="loading"
                 @keydown="form.errors.clear($event.target.name);">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-tabs v-model="activeTab">
                                <el-tab-pane :label="localeArray.name" v-for="(localeArray, locale) in locales"
                                             :key="localeArray.name" :name="locale">
                                <span slot="label" :class="{'error' : form.errors.has(locale)}">{{ localeArray.name
                                    }}</span>
                                    <el-form-item :label="trans('terms.form.name')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.name') }">
                                        <el-input v-model="term[locale].name"></el-input>
                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.name')"
                                             v-text="form.errors.first(locale + '.name')"></div>
                                    </el-form-item>
                                    <el-form-item :label="trans('terms.form.slug')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.slug') }">
                                        <el-input v-model="term[locale].slug">
                                            <el-button slot="prepend" @click="generateSlug($event, locale)">Generate</el-button>
                                        </el-input>
                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.slug')"
                                             v-text="form.errors.first(locale + '.slug')"></div>
                                    </el-form-item>
                                    <el-form-item :label="trans('terms.form.description')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.description') }">
                                        <component :is="getCurrentEditor()" v-model="term[locale].description" :value="term[locale].description">
                                        </component>

                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.description')"
                                             v-text="form.errors.first(locale + '.description')"></div>
                                    </el-form-item>
                                    <div class="panel box box-primary">
                                        <div class="box-header">
                                            <h4 class="box-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                   :href="`#collapseMeta-${locale}`">
                                                    {{ trans('terms.form.meta data') }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div style="height: 0px;" :id="`collapseMeta-${locale}`"
                                             class="panel-collapse collapse">
                                            <div class="box-body">
                                                <el-form-item :label="trans('terms.form.meta title')">
                                                    <el-input v-model="term[locale].meta_title"></el-input>
                                                </el-form-item>
                                                <el-form-item :label="trans('terms.form.meta description')">
                                                    <el-input type="textarea"
                                                              v-model="term[locale].meta_description"></el-input>
                                                </el-form-item>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel box box-primary">
                                        <div class="box-header">
                                            <h4 class="box-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                   :href="`#collapseFacebook-${locale}`">
                                                    {{ trans('terms.form.facebook data') }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div style="height: 0px;" :id="`collapseFacebook-${locale}`"
                                             class="panel-collapse collapse">
                                            <div class="box-body">
                                                <el-form-item :label="trans('terms.form.og title')">
                                                    <el-input v-model="term[locale].og_title"></el-input>
                                                </el-form-item>
                                                <el-form-item :label="trans('terms.form.og description')">
                                                    <el-input type="textarea"
                                                              v-model="term[locale].og_description"></el-input>
                                                </el-form-item>
                                                <el-form-item :label="trans('terms.form.og type')">
                                                    <el-select v-model="term[locale].og_type"
                                                               :placeholder="trans('terms.form.og type')">
                                                        <el-option :label="trans('terms.facebook-types.website')"
                                                                   value="website"></el-option>
                                                        <el-option :label="trans('terms.facebook-types.product')"
                                                                   value="product"></el-option>
                                                        <el-option :label="trans('terms.facebook-types.article')"
                                                                   value="article"></el-option>
                                                    </el-select>
                                                </el-form-item>

                                            </div>
                                        </div>
                                    </div>
                                    <el-form-item>
                                        <el-button type="primary" @click="onSubmit()" :loading="loading">
                                            {{ trans('core.save') }}
                                        </el-button>
                                        <el-button @click="onCancel()">{{ trans('core.button.cancel') }}
                                        </el-button>
                                    </el-form-item>

                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-form-item :label="trans('terms.form.parents')">
                                <el-select v-model="term.parent_ids" multiple
                                           :placeholder="trans('terms.form.parents')" @change="chooseParent">
                                    <el-option
                                            v-for="item in terms"
                                            :key="item.id"
                                            :label="item.translations.name"
                                            :value="item.id">
                                    </el-option>

                                </el-select>
                            </el-form-item>
                            <el-form-item :label="trans('terms.form.status')">
                                <el-select v-model="term.status"
                                           :placeholder="trans('terms.form.status')">
                                    <el-option :label="trans('terms.form.show')"
                                               value="1"></el-option>
                                    <el-option :label="trans('terms.form.hidden')"
                                               value="0"></el-option>

                                </el-select>
                            </el-form-item>
                            <el-form-item :label="trans('terms.form.position')"
                                          :class="{'el-form-item is-error': form.errors.has('pos') }">
                                <el-input v-model="term.pos"></el-input>
                                <div class="el-form-item__error" v-if="form.errors.has('pos')"
                                     v-text="form.errors.first(locale + 'pos')"></div>
                            </el-form-item>
                            <single-media zone="featured_image" @singleFileSelected="selectSingleFile($event, 'term')"
                                          entity="Modules\Taxonomy\Entities\Term" :entity-id="$route.params.term"></single-media>
                        </div>
                    </div>
                </div>
            </div>
        </el-form>
        <button v-shortkey="['b']" @shortkey="pushRoute({name: 'admin.taxonomy.term.index', params: {vocabulary: vocabulary}})" v-show="false"></button>
    </div>
</template>

<script>
    import axios from 'axios';
    import Form from 'form-backend-validation';
    import Slugify from '../Slugify';
    import ShortcutHelper from '../../../../Core/Assets/js/mixins/ShortcutHelper';
    import ActiveEditor from '../../../../Core/Assets/js/mixins/ActiveEditor';
    import SingleFileSelector from '../../../../Media/Assets/js/mixins/SingleFileSelector';

    export default {
        mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
        props: {
            locales: { default: null },
            pageTitle: { default: null, String },
        },
        data() {
            return {
                term: _(this.locales)
                    .keys()
                    .map(locale => [locale, {
                        name: '',
                        description: '',
                        slug: '',
                        meta_title: '',
                        meta_description: '',
                        og_title: '',
                        og_description: '',
                        og_image: '',
                        og_type: '',
                    }])
                    .fromPairs()
                    .merge({ vocabulary_id: '', pos: 0, status: '0', parent_ids: []})
                    .value(),
                form: new Form(),
                loading: false,
                activeTab: window.AsgardCMS.currentLocale || 'en',
                vocabulary: this.$route.params.vocabulary,
                terms: [],
                pickerOptions1: {
                    shortcuts: [{
                        text: 'Today',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: 'Yesterday',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: 'A week ago',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                }
            };
        },
        methods: {
            onSubmit() {
                if (_.isEmpty(this.term.parent_ids)) {
                    this.term.parent_ids.push(0);
                }
                this.form = new Form(this.term);
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
                        this.$router.push({ name: 'admin.taxonomy.term.index', params: {vocabulary: this.vocabulary} });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.loading = false;
                        this.$notify.error({
                            title: 'Error',
                            message: 'There are some errors in the form.',
                        });
                    });
            },
            onCancel() {
                this.$router.push({ name: 'admin.taxonomy.term.index', params: {vocabulary: this.vocabulary}});
            },
            fetchTerm() {
                this.loading = true;
                axios.post(route('api.taxonomy.term.find', { term: this.$route.params.term }))
                    .then((response) => {
                        this.loading = false;
                        this.term = response.data.data;
                        this.term.status = this.term.status.toString();
                        this.vocabulary = this.term.vocabulary_id;
                        _.remove(this.term.parent_ids, function (n) {
                            return n === 0;
                        });
                        this.fetchTerms();
                    });
            },
            getRoute() {
                if (this.$route.params.term !== undefined) {
                    return route('api.taxonomy.term.update', { term: this.$route.params.term });
                }
                return route('api.taxonomy.term.store');
            },
            generateSlug(event, locale) {
                this.term[locale].slug = this.slugify(this.term[locale].name);
            },
            fetchTerms() {
                axios.get(route('api.taxonomy.term.index',{vocabulary: this.vocabulary}))
                    .then((response) => {
                        this.terms = response.data.data;
                    });
            },
            chooseParent(value) {
                console.log(value, this.term.parent_ids);
                if (this.term.parent_ids) {

                }
            }
        },
        mounted() {

            if (this.$route.params.term !== undefined) {
                this.fetchTerm();
            } else {
                this.term.vocabulary_id = this.$route.params.vocabulary;
                this.fetchTerms();
            }
        },
    };
</script>
