<?php

namespace Modules\Taxonomy\Repositories\Eloquent;

use Modules\Taxonomy\Repositories\VocabularyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

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
}
