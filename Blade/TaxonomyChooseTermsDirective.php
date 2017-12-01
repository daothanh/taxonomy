<?php

namespace Modules\Taxonomy\Blade;

use Modules\Taxonomy\Composers\Backend\BladeDirectiveAssetComposer;

class TaxonomyChooseTermsDirective
{
  /**
   * @var int
   */
    private $vid;
  /**
   * @var
   */
    private $entity;
  /**
   * @var string|null
   */
    private $view;
  /**
   * @var string|null
   */
    private $name;

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        if ($this->vid) {
            $view = $this->view ?: 'taxonomy::admin.terms.fields.new-choose-terms';
            view()->composer($view, BladeDirectiveAssetComposer::class);
            $vid = $this->vid;
            $name = $this->name ?: 'terms[]';
            $vocabulary = taxonomy_get_vocabulary($vid);
            $terms = taxonomy_get_tree($vid);
            $entityTerms = null;
            if ($this->entity !== null) {
                $entityTerms = $this->entity->termsByVocabularyId($this->vid)->get();
            }

            return view($view, compact('terms', 'entityTerms', 'vid', 'name', 'vocabulary'))->render();
        }
        return '';
    }

  /**
   * Extract the possible arguments as class properties
   * @param array $arguments
   */
    private function extractArguments(array $arguments)
    {
        $this->vid = array_get($arguments, 0);
        $this->entity = array_get($arguments, 1);
        $this->view = array_get($arguments, 2);
        $this->name = array_get($arguments, 3);
    }
}
