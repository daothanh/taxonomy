<template>
    <div class="div">
        <div class="content-header">
            <h1>
                {{ trans(`vocabularies.${pageTitle}`) }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/backend">Home</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.vocabulary.index'}">{{ trans('vocabularies.title.vocabularies') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.taxonomy.vocabulary.create'}">{{ trans(`vocabularies.${pageTitle}`) }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form ref="form" :model="vocabulary" label-width="120px" label-position="top"
                 v-loading.body="loading"
                 @keydown="form.errors.clear($event.target.name);">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-tabs v-model="activeTab">
                                <el-tab-pane :label="localeArray.name" v-for="(localeArray, locale) in locales"
                                             :key="localeArray.name" :name="locale">
                                <span slot="label" :class="{'error' : form.errors.has(locale)}">{{ localeArray.name
                                    }}</span>
                                    <el-form-item :label="trans('vocabularies.form.name')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.name') }">
                                        <el-input v-model="vocabulary[locale].name"></el-input>
                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.name')"
                                             v-text="form.errors.first(locale + '.name')"></div>
                                    </el-form-item>

                                    <el-form-item :label="trans('vocabularies.form.description')"
                                                  :class="{'el-form-item is-error': form.errors.has(locale + '.description') }">
                                        <component :is="getCurrentEditor()" v-model="vocabulary[locale].description" :value="vocabulary[locale].description">
                                        </component>

                                        <div class="el-form-item__error" v-if="form.errors.has(locale + '.description')"
                                             v-text="form.errors.first(locale + '.description')"></div>
                                    </el-form-item>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="box box-primary">
                        <div class="box-body">
                            <el-form-item :label="trans('vocabularies.form.machine name')"
                                          :class="{'el-form-item is-error': form.errors.has('machine_name') }">
                                <el-input v-model="vocabulary.machine_name"></el-input>
                                <div class="el-form-item__error" v-if="form.errors.has('machine_name')"
                                     v-text="form.errors.first('machine_name')"></div>
                            </el-form-item>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box-footer">

                        <el-button class="pull-left" type="primary" @click="onSubmit()" :loading="loading">
                            {{ trans('core.save') }}
                        </el-button>
                        <el-button class="pull-right" @click="onCancel()">{{ trans('core.button.cancel') }}
                        </el-button>
                    </div>
                </div>
            </div>
        </el-form>
        <button v-shortkey="['b']" @shortkey="pushRoute({name: 'admin.taxonomy.vocabulary.index'})" v-show="false"></button>
    </div>
</template>

<script>
    import axios from 'axios';
    import Form from 'form-backend-validation';
    import ShortcutHelper from '../../../../Core/Assets/js/mixins/ShortcutHelper';
    import ActiveEditor from '../../../../Core/Assets/js/mixins/ActiveEditor';

    export default {
        mixins: [ShortcutHelper, ActiveEditor],
        props: {
            locales: { default: null },
            pageTitle: { default: null, String },
        },
        data() {
            return {
                vocabulary: _(this.locales)
                    .keys()
                    .map(locale => [locale, {
                        name: '',
                        description: '',
                    }])
                    .fromPairs()
                    .merge({ machine_name: '', can_change_machine_name: 0})
                    .value(),
                form: new Form(),
                loading: false,
                activeTab: window.AsgardCMS.currentLocale || 'en',
            };
        },
        methods: {
            onSubmit() {
                this.form = new Form(this.vocabulary);
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
                        this.$router.push({ name: 'admin.taxonomy.vocabulary.index' });
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
                this.$router.push({ name: 'admin.taxonomy.vocabulary.index' });
            },
            fetchVocabulary() {
                this.loading = true;
                axios.post(route('api.taxonomy.vocabulary.find', { vocabulary: this.$route.params.vocabulary }))
                    .then((response) => {
                        this.loading = false;
                        this.vocabulary = response.data.data;
                    });
            },
            getRoute() {
                if (this.$route.params.vocabulary !== undefined) {
                    return route('api.taxonomy.vocabulary.update', { vocabulary: this.$route.params.vocabulary });
                }
                return route('api.taxonomy.vocabulary.store');
            },
        },
        mounted() {

            if (this.$route.params.vocabulary !== undefined) {
                this.fetchVocabulary();
            }
        },
    };
</script>
