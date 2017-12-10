<?php

namespace Modules\Taxonomy\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use LaravelLocalization;

class FullTermTransformer extends Resource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request
	 *
	 * @return array
	 * @throws \Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined;
	 */
    public function toArray($request)
    {
        $data = [
        	'id' => $this->id,
	        'vocabulary_id' => $this->vocabulary_id,
	        'pos' => $this->pos,
	        'status' => $this->status,
	        'urls' => [
		        'delete_url' => route('api.taxonomy.term.destroy', $this->id),
	        ],
        ];
	    foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
		    $data[$locale] = [];
		    $translatedTerm = $this->translateOrNew($locale);
		    foreach ($this->translatedAttributes as $translatedAttribute) {
			    $data[$locale][$translatedAttribute] = $translatedTerm->$translatedAttribute;
		    }
	    }

	    return $data;
    }
}
