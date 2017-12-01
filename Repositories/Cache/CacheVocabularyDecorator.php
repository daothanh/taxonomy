<?php

namespace Modules\Taxonomy\Repositories\Cache;

use Modules\Taxonomy\Repositories\VocabularyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVocabularyDecorator extends BaseCacheDecorator implements VocabularyRepository
{
    public function __construct(VocabularyRepository $vocabulary)
    {
        parent::__construct();
        $this->entityName = 'taxonomy.vocabularies';
        $this->repository = $vocabulary;
    }
}
