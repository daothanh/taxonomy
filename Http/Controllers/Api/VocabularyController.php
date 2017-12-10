<?php

namespace Modules\Taxonomy\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Taxonomy\Entities\Vocabulary;
use Modules\Taxonomy\Http\Requests\CreateVocabularyRequest;
use Modules\Taxonomy\Http\Requests\UpdateVocabularyRequest;
use Modules\Taxonomy\Repositories\VocabularyRepository;
use Modules\Taxonomy\Transformers\VocabularyTransformer;

class VocabularyController extends Controller {
	/** @var VocabularyRepository */
	private $vocabulary;

	public function __construct( VocabularyRepository $vocabulary ) {
		$this->vocabulary = $vocabulary;
	}

	public function index( Request $request ) {
		return VocabularyTransformer::collection( $this->vocabulary->serverPaginationFilteringFor( $request ) );
	}

	public function all() {
		return VocabularyTransformer::collection( $this->vocabulary->all() );
	}

	public function find( Vocabulary $vocabulary ) {
		return new VocabularyTransformer( $vocabulary );
	}

	public function findNew( Vocabulary $vocabulary ) {
		return new VocabularyTransformer( $vocabulary );
	}

	public function store( CreateVocabularyRequest $request ) {
		$data = $request->all();

		$this->vocabulary->create( $data );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::vocabularies.messages.vocabulary created' ),
		] );
	}

	public function update( Vocabulary $vocabulary, UpdateVocabularyRequest $request ) {
		$data = $request->all();

		$this->vocabulary->update( $vocabulary, $data );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::vocabularies.messages.vocabulary updated' ),
		] );
	}

	public function destroy( Vocabulary $vocabulary ) {
		$this->vocabulary->destroy( $vocabulary );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::vocabularies.messages.vocabulary deleted' ),
		] );
	}
}