import VocabularyTable from './components/VocabularyTable.vue';
import VocabularyForm from './components/VocabularyForm.vue';
import TermTable from './components/TermTable.vue';
import TermForm from './components/TermForm.vue';
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
    // Term Routes
    {
        path: '/taxonomy/vocabularies/:vocabulary/terms',
        name: 'admin.taxonomy.term.index',
        component: TermTable,
    },
    {
        path: '/taxonomy/vocabularies/:vocabulary/terms/create',
        name: 'admin.taxonomy.term.create',
        component: TermForm,
        props: {
            locales,
            pageTitle: 'title.create term',
        },
    },
    {
        path: '/taxonomy/terms/:term/edit',
        name: 'admin.taxonomy.term.edit',
        component:TermForm,
        props: {
            locales,
            pageTitle: 'title.edit term',
        },
    },
];
