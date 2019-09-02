# Taxonomy module
Simple module that help you to manage your taxonomy (category)

## Installation

### Module Download

Using AsgardCMS's module download command:

``` bash
php artisan asgard:download:module daothanh/taxonomy --migrations
```

This will download the module, run its migrations.

### Composer

``` bash
composer require daothanh/taxonomy
php artisan module:migrate Taxonomy
```
### Add Routes

Go to  `reosources/assets/js/app.js`
- Import Routes: `import TaxonomyRoutes from '../../../Modules/Taxonomy/Assets/js/TaxonomyRoutes';`
- Add `TaxonomyRoutes` to router: `...TaxonomyRoutes,`
- Build webpack by `npm run dev`

### Add the category to form

To show the category box in your form . You must use the TermsBox (a vuejs component) or taxonomyChooseTerms directive (with blade)

[TermsBox.vue](https://github.com/daothanh/taxonomy/blob/master/Assets/js/components/TermsBox.vue)

Example for page form:
```
<template>
<TermsBox vocabularyId="1" entity="Modules\Page\Entities\Page"/>
</template>
<script>
import TermsBox from '../../../../Taxonomy/Assets/js/components/TermsBox';`
export default {
        components: {TermsBox}
}
</script>
```
