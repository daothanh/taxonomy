<?php

namespace Modules\Taxonomy\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use LaravelLocalization;

class FullTermForListTransformer extends Resource
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
	    $translatedTerm = optional($this->translate(locale()));
        $data = [
        	'id' => $this->id,
	        'vocabulary_id' => $this->vocabulary_id,
	        'pos' => $this->pos,
	        'status' => $this->status,
	        'featured_image' => $this->featured_image ? $this->featured_image->path->getUrl() : '',
	        'parent_ids' => count($this->parents) ? $this->parents->pluck('id')->toArray() : [0],
	        'child_ids' => count($this->children) ? $this->children->pluck('id')->toArray() : [],
	        'created_at' => $this->created_at ? $this->created_at->format('d-m-Y H:i:s') : null,
	        'depth' => $this->depth,
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


	    return $data;
    }
}
