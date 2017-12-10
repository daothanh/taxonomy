<?php

namespace Modules\Taxonomy\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Taxonomy\Repositories\VocabularyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EloquentVocabularyRepository extends EloquentBaseRepository implements VocabularyRepository
{
	/**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        $query = $this->model->query();
        if (method_exists($this->model, 'translations')) {
            $query = $query->with('translations');
        }
        return $query;
    }

	/**
	 * Paginating, ordering and searching through pages for server side index table
	 * @param Request $request
	 * @return LengthAwarePaginator
	 */
	public function serverPaginationFilteringFor(Request $request, $relations = []): LengthAwarePaginator
	{
		$query = $this->allWithBuilder($relations);

		if ($request->get('search') !== null) {
			$term = $request->get('search');
			$query->whereHas('translations', function ($q) use ($term) {
				$q->where('name', 'LIKE', "%$term%");
			})->orWhere('id', $term);
		}

		if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
			$order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

			$query->orderBy($request->get('order_by'), $order);
		} else {
			$query->orderBy('created_at', 'desc');
		}

		if ($request->get('group_by') !== null) {
			$query->groupBy(explode(",", $request->get('group_by')));
		}

		return $query->paginate($request->get('per_page', 10));
	}

	public function serverFilteringFor(Request $request, $relations = [])
	{
		$query = $this->allWithBuilder($relations);

		if ($request->get('search') !== null) {
			$term = $request->get('search');
			$query->where('id', $term);
		}

		if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
			$order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

			$query->orderBy($request->get('order_by'), $order);
		} else {
			$query->orderBy('created_at', 'desc');
		}

		if ($request->get('group_by') !== null) {
			$query->groupBy(explode(",", $request->get('group_by')));
		}

		return $query->get();
	}

	public function allWithBuilder($relations = []): Builder
	{
		if (method_exists($this->model, 'translations')) {
			$relations = array_merge($relations, ['translations']);
		}
		if (!empty($relations)) {
			$with = [];
			foreach ($relations as $key => $relation) {
				if (is_callable($relation)) {
					if (method_exists($this->model, $key)) {
						$with[$key] = $relation;
					}
				} elseif (method_exists($this->model, $relation)) {
					array_push($with, $relation);
				}
			}

			if (!empty($with)) {
				return $this->model->with($with);
			}
		}

		return $this->model->newQuery();
	}
}
