import VocabularyTable from './components/VocabularyTable.vue';
import VocabularyForm from './components/VocabularyForm.vue';
const locales = window.AsgardCMS.locales;

export default [
    // Vocabulary Routes
    {
        path: '/taxonomy/vocabularies',
        name: 'admin.taxonomy.vocabulary.index',
        component: VocabularyTable,
    },
    {
        path: '/taxonomy/vocabularies/create',
        name: 'admin.taxonomy.vocabulary.create',
        component: VocabularyForm,
        props: {
            locales,
            pageTitle: 'title.create vocabulary',
        },
    },
    {
        path: '/taxonomy/vocabularies/:vocabulary/edit',
        name: 'admin.taxonomy.vocabulary.edit',
        component: VocabularyForm,
        props: {
            locales,
            pageTitle: 'title.edit vocabulary',
        },
    },
];