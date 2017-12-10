<?php

namespace Modules\Taxonomy\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TermTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
    	$translatedTerm = optional($this->translate(locale()));
        return [
        	'id' => $this->id,
	        'vocabulary_id' => $this->vocabulary_id,
	        'pos' => $this->pos,
	        'status' => $this->status,
	        'translations' => [
		        'name' => $translatedTerm->name,
		        'description' => $translatedTerm->description,
		        'slug' => $translatedTerm->slug,
		        'meta_title' => $translatedTerm->meta_title,
		        'meta_description' => $translatedTerm->meta_description,
		        'og_title' => $translatedTerm->og_title,
		        'og_description' => $translatedTerm->og_description,
		        'og_image' => $translatedTerm->og_image,
		        'og_type' => $translatedTerm->og_type,
	        ],
	        'urls' => [
		        'delete_url' => route('api.taxonomy.term.destroy', $this->id),
	        ],
        ];
    }
}
