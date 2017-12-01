<?php
namespace Modules\Taxonomy\Support\Traits;

use Modules\Taxonomy\Entities\Term;

trait Termable
{
    public function terms()
    {
        return $this->morphToMany(Term::class, 'termable', 'taxonomy__termables')
        ->withPivot('order', 'id')->withTimestamps()->orderBy('order');
    }

    public function termsByVocabularyId($vid)
    {
        return $this->morphToMany(Term::class, 'termable', 'taxonomy__termables')
        ->withPivot('order', 'id')
        ->where('taxonomy__terms.vocabulary_id', '=', $vid)
        ->withTimestamps()->orderBy('order');
    }
}
