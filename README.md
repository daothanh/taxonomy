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
