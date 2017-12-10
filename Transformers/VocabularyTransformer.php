<?php

namespace Modules\Taxonomy\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class VocabularyTransformer extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request
	 *
	 * @return array
	 */
	public function toArray( $request ) {
		$translatedVocabulary = optional( $this->translate( locale() ) );

		return [
			'machine_name'            => $this->machine_name,
			'can_change_machine_name' => $this->can_change_machine_name,
			'translations'            => [
				'name'        => $translatedVocabulary->name,
				'description' => $translatedVocabulary->description
			],
			'urls'                    => [
				'delete_url' => route( 'api.taxonomy.vocabulary.destroy', $this->id ),
			]
		];

	}
}
