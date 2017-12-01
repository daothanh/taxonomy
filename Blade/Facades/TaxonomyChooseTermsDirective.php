<?php

namespace Modules\Taxonomy\Blade\Facades;

use Illuminate\Support\Facades\Facade;

class TaxonomyChooseTermsDirective extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'taxonomy.choose.terms.directive';
  }
}