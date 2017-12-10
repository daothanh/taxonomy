<?php

namespace Modules\Taxonomy\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class FullVocabularyTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
	    $data = [
		    'machine_name' =>$this->machine_name,
		    'can_change_machine_name' => $this->can_change_machine_name,
		    'urls'                    => [
			    'delete_url' => route( 'api.taxonomy.vocabulary.destroy', $this->id ),
		    ]
	    ];
	    foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
		    $data[$locale] = [];
		    $translatedVocabulary = $this->translateOrNew($locale);
		    foreach ($this->translatedAttributes as $translatedAttribute) {
			    $data[$locale][$translatedAttribute] = $translatedVocabulary->$translatedAttribute;
		    }
	    }

	    return $data;
    }
}
