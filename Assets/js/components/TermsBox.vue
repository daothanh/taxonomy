<template>
    <div class="box">
        <div class="box-header">
            <h2 class="box-title">{{ !ld.isEmpty(vocabulary) ? vocabulary.translations.name : trans('terms.title.terms') }}</h2>
        </div>
        <div class="box-body">
            <div class="row">

                    <el-checkbox-group v-model="selectedTermIds[vocabularyId]" @change="handleChange">
                        <div class="col-md-12" v-for="term in terms">
                    <el-checkbox :class="'depth-'+term.depth" :label="term.id" :key="term.id">{{term.translations.name}}</el-checkbox>
                        </div>
                    </el-checkbox-group>


            </div>

        </div>
    </div>
</template>
<style scoped>
    .depth-1 {
        margin-left: 24px;
    }
    .depth-2 {
         margin-left: 48px;
    }
    .depth-3 {
        margin-left: 72px;
    }
</style>
<script>
    import axios from 'axios';
    import StringHelpers from '../../../../Core/Assets/js/mixins/StringHelpers.vue';
    export default {
        mixins: [StringHelpers],
        props: {
            vocabularyId: {required: true},
            entityId: {required: false},
            entity: {required: true}
        },
        data() {
            return {
                vocabulary: {},
                terms: [],
                selectedTermIds: [],
                ld: window._,
            }
        },
        methods: {
            fetchTerms() {
                axios.get(route('api.taxonomy.term.get.all', {vocabulary: this.vocabularyId}))
                    .then((response) => {
                        this.terms = response.data.data;
                        this.terms = this.terms.map((t) => {
                            const term = t;
                            term.checked = this.selectedTermIds[this.vocabularyId].indexOf(term.id) !== -1;
                            return term;
                        });
                    });

            },
            fetchSelectedTerms() {
                const properties = {
                    vocabulary_id: this.vocabularyId,
                    entity_id: this.entityId,
                    entity: this.entity
                };

                axios.get(route('api.taxonomy.term.get.by', properties))
                    .then((response) => {
                        let selectedTerms = response.data.data, selectedTermIds = [];
                        selectedTerms.forEach(function(term) {
                            selectedTermIds.push(term.id);
                        });
                        this.selectedTermIds[this.vocabularyId] = selectedTermIds;
                    });
            },
            fetchVocabulary() {
                this.loading = true;
                axios.get(route('api.taxonomy.vocabulary.get', { vocabulary: this.vocabularyId }))
                    .then((response) => {
                        this.loading = false;
                        this.vocabulary = response.data.data;
                    });
            },
            handleChange(value) {
                this.$emit('changeTerm', this.selectedTermIds);
            }
        },
        mounted() {
            if (this.vocabularyId) {
                this.selectedTermIds[this.vocabularyId] = [];
                if (this.entityId) {
                    this.fetchSelectedTerms();
                }
                this.fetchVocabulary();
                this.fetchTerms();
            }

        }
    }
</script>