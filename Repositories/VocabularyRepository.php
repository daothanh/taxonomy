<?php

namespace Modules\Taxonomy\Repositories;

use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VocabularyRepository extends BaseRepository
{
    public function getQuery();
	public function serverPaginationFilteringFor(Request $request, $relations = []) : LengthAwarePaginator;
	public function serverFilteringFor(Request $request, $relations = []);
}
