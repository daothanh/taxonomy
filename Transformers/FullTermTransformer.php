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
	        'featured_image' => $this->featured_image ? $this->featured_image->path->getUrl() : '',
	        'parent_ids' => count($this->parents) ? $this->parents->pluck('id')->toArray() : [0],
	        'created_at' => $this->created_at ? $this->created_at->format('d-m-Y H:i:s') : null,
	        'urls' => [
		        'delete_url' => route('api.taxonomy.term.destroy', $this->id),
	        ],
        ];
	    foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
		    $data[$locale] = [];
		    $translatedTerm = $this->translateOrNew($locale);
		    foreach ($this->translatedAttributes as $translatedAttribute) {
		    	if ($translatedAttribute == 'name') {
		    		$data[$locale][$translatedAttribute] = !empty($this->depth) ? str_repeat('-', $this->depth)." ".$translatedTerm->name : $translatedTerm->name;
			    } else {
				    $data[$locale][$translatedAttribute] = $translatedTerm->$translatedAttribute;
			    }

		    }
	    }

	    return $data;
    }
}
