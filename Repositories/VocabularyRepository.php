<?php

namespace Modules\Taxonomy\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface VocabularyRepository extends BaseRepository
{
    public function getQuery();
}
