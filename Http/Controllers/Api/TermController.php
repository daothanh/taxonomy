<?php

namespace Modules\Taxonomy\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Http\Requests\CreateTermRequest;
use Modules\Taxonomy\Http\Requests\UpdateTermRequest;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Taxonomy\Transformers\TermTransformer;

class TermController extends Controller {
	/** @var TermRepository */
	private $term;

	public function __construct( TermRepository $term ) {
		$this->term = $term;
	}

	public function index( Request $request ) {
		return TermTransformer::collection( $this->term->serverPaginationFilteringFor( $request ) );
	}

	public function all() {
		return TermTransformer::collection( $this->term->all() );
	}

	public function find( Term $term ) {
		return new TermTransformer( $term->load( [ 'parents', 'children' ] ) );
	}

	public function findNew( Term $term ) {
		return new TermTransformer( $term->load( [ 'parents', 'children' ] ) );
	}

	public function store( CreateTermRequest $request ) {
		$data = $request->all();

		$this->term->create( $data );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::terms.messages.term created' ),
		] );
	}

	public function update( Term $term, UpdateTermRequest $request ) {
		$data = $request->all();

		$this->term->update( $term, $data );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::terms.messages.term updated' ),
		] );
	}

	public function destroy( Term $term ) {
		$this->term->destroy( $term );

		return response()->json( [
			'errors'  => false,
			'message' => trans( 'taxonomy::terms.messages.term deleted' ),
		] );
	}
}