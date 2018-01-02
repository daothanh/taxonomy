<?php

namespace Modules\Taxonomy\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Http\Requests\CreateTermRequest;
use Modules\Taxonomy\Http\Requests\UpdateTermRequest;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Taxonomy\Transformers\FullTermForListTransformer;
use Modules\Taxonomy\Transformers\FullTermTransformer;
use Modules\Taxonomy\Transformers\TermTransformer;

class TermController extends Controller {
	/** @var TermRepository */
	private $term;

	public function __construct( TermRepository $term ) {
		$this->term = $term;
	}

	public function index( Request $request ) {
		$terms = $this->term->getTree($request->get('vocabulary'), 0);

		$total = count($terms);
		if ($total == 0) {
			$total = 1;
		}
			$paginator = new Paginator($terms, $total, $total);
		return TermTransformer::collection( $paginator );
	}

	public function all() {
		return TermTransformer::collection( $this->term->all() );
	}

	public function find( Term $term ) {
		return new FullTermTransformer( $term->load( [ 'parents', 'children' ] ) );
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

	public function get(Request $request) {
		$terms = $this->term->getTree($request->get('vocabulary'), 0);

		$total = count($terms);
		if ($total == 0) {
			$total = 1;
		}
		$paginator = new Paginator($terms, $total, $total);
		return FullTermForListTransformer::collection( $paginator );
	}

	public function getBy(Request $request) {
		return TermTransformer::collection($this->term->serverFilteringFor($request));
	}
	public function markStatus(Request $request)
	{
		$action = $request->get('action');
		$termIds = json_decode($request->get('termIds'));
		if ($action === 'mark-online') {
			$this->term->markMultipleAsOnline($termIds);
		} else {
			$this->term->markMultipleAsOffline($termIds);
		}

		return response()->json(['errors' => false, 'message' => trans('taxonomy::terms.messages.terms were updated')]);
	}
}