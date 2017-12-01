<?php

namespace Modules\Taxonomy\Repositories\Cache;

use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTermDecorator extends BaseCacheDecorator implements TermRepository
{
    public function __construct(TermRepository $term)
    {
        parent::__construct();
        $this->entityName = 'taxonomy.terms';
        $this->repository = $term;
    }
}
