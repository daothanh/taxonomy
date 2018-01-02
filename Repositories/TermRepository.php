<?php

namespace Modules\Taxonomy\Repositories;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Core\Repositories\BaseRepository;
use Modules\Taxonomy\Entities\Term;

interface TermRepository extends BaseRepository {

	public function getQuery();

	public function serverPaginationFilteringFor( Request $request, $relations = [] ): LengthAwarePaginator;

	public function serverFilteringFor( Request $request, $relations = [] );

	public function createTree( $vid, $items, $parent, $maxDepth = null );

	public function getTree( $vid, $parent = 0, $maxDepth = null );

	/**
	 * @param Term $term
	 * @return mixed
	 */
	public function markAsOnline(Term $term);

	/**
	 * @param Term $term
	 * @return mixed
	 */
	public function markAsOffline(Term $term);

	/**
	 * @param array $termIds [int]
	 * @return mixed
	 */
	public function markMultipleAsOnline(array $termIds);

	/**
	 * @param array $termIds [int]
	 * @return mixed
	 */
	public function markMultipleAsOffline(array $termIds);
}
