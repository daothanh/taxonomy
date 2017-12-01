<?php

namespace Modules\Taxonomy\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TermRepository extends BaseRepository {

  public function getQuery();

  public function createTree($vid, $items, $parent, $maxDepth = NULL);

  public function getTree($vid, $parent = 0, $maxDepth = NULL);
}
