<?php

namespace Modules\Taxonomy\Repositories;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Core\Repositories\BaseRepository;

interface TermRepository extends BaseRepository {

	public function getQuery();

	public function serverPaginationFilteringFor( Request $request, $relations = [] ): LengthAwarePaginator;

	public function serverFilteringFor( Request $request, $relations = [] );

	public function createTree( $vid, $items, $parent, $maxDepth = null );

	public function getTree( $vid, $parent = 0, $maxDepth = null );
}
